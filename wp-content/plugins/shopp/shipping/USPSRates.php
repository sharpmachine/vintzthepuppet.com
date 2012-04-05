<?php
/**
 * USPS Rates
 *
 * Uses USPS Webtools to get live shipping rates based on product weight
 *
 * INSTALLATION INSTRUCTIONS
 * Upload USPSRates.php to your Shopp install under:
 * ./wp-content/plugins/shopp/shipping/
 *
 * @author Jonathan Davis
 * @version 1.2
 * @copyright Ingenesis Limited, 26 February, 2009
 * @package shopp
 * @since 1.2
 * @subpackage USPSRates
 *
 * $Id: USPSRates.php 16 2012-02-07 15:30:31Z jdillick $
 **/

class USPSRates extends ShippingFramework implements ShippingModule {

	var $url = 'http://production.shippingapis.com/ShippingAPI.dll';
	var $dimensions = true;
	var $weight = 0;

	var $xml = true;		// Requires the XML parser
	var $postcode = true;	// Requires a postal code for rates
	var $singular = true;	// Module can only be used once
	var $realtime = true;	// Provides real-time rates

	/* Test URL */
	// var $url = 'http://testing.shippingapis.com/ShippingAPITest.dll';

	var $services = array(
		"d0" => "First-Class",
		"d1" => "Priority Mail",
		"d2" => "Express Mail Hold for Pickup",
		"d3" => "Express Mail PO to Addressee",
		"d4" => "Parcel Post",
		"d5" => "Bound Printed Matter",
		"d6" => "Media Mail",
		"d7" => "Library",
		"d12" => "First-Class Postcard Stamped",
		"d13" => "Express Mail Flat-Rate Envelope",
		"d16" => "Priority Mail Flat-Rate Envelope",
		"d17" => "Priority Mail Flat-Rate Boxes",
		"d18" => "Priority Mail Keys and IDs",
		"d19" => "First-Class Keys and IDs",
		"d22" => "Priority Mail Flat-Rate Large Box",
		"d23" => "Express Mail Sunday/Holiday",
		"d25" => "Express Mail Flat-Rate Envelope Sunday/Holiday",
		"d27" => "Express Mail Flat-Rate Envelope Hold for Pickup",
		"d28" => "Priority Mail Small Flat-Rate Box",
		"i1" => "Express Mail International",
		"i2" => "Priority Mail International",
		"i4" => "Global Express Guaranteed",
		"i5" => "Global Express Guaranteed Document used",
		"i6" => "Global Express Guaranteed Non-Document Rectangular",
		"i7" => "Global Express Guaranteed Non-Document Non-Rectangular",
		"i8" => "Priority Mail International Flat Rate Envelope",
		"i9" => "Priority Mail International Flat Rate Box",
		"i10" => "Express Mail International Flat Rate Envelope",
		"i11" => "Priority Mail International Large Flat Rate Box",
		"i12" => "Global Express Guaranteed Envelope",
		"i13" => "First Class Mail International Letters",
		"i14" => "First Class Mail International Flats",
		"i15" => "First Class Mail International Package",
		"i16" => "Priority Mail International Small Flat-Rate Box",
		"i21" => "International PostCards"
	);

	function __construct () {
		parent::__construct();

		$this->setup('userid','postcode');

		add_action('shipping_service_settings',array(&$this,'settings'));
		add_action('shopp_verify_shipping_services',array(&$this,'verify'));
	}

	function init () {
		$this->weight = 0;
	}

	function calcitem ($id,$Item) {
		if ($Item->freeshipping) return;
		$this->packager->add_item($Item);
	}

	function methods () {
		if ($this->base['country'] != "US") return array(); // Require base of operations in USA
		return __('USPS Rates','Shopp');
	}

	function calculate ($options,$Order) {
		// Don't get an estimate without a postal code
		if (empty($Order->Shipping->postcode)) return $options;

		$request = $this->build($Order->Shipping->postcode, $Order->Shipping->country);
		$Response = $this->send($request);
		if (!$Response) {
			new ShoppError(__('Shipping options and rates are not available from USPS. Please try again.','Shopp'),'usps_rate_error',SHOPP_TRXN_ERR);
			return false;
		}
		if ( $Response->tag('Error') ) {
			new ShoppError('USPS &mdash; '.$Response->content('Description'),'usps_rate_error',SHOPP_TRXN_ERR);
			return false;
		}

		$estimate = false;
		if ($Order->Shipping->country == $this->base['country']) $type = "domestic";
		else $type = "intl";

		if ($type == "domestic") $Estimates = $Response->tag('Postage');
		else $Estimates = $Response->tag('Service');

		while ($rated = $Estimates->each()) {
			$delivery = "5d-7d";
			if ($type == "domestic") {
				$mailsvc = $rated->content('MailService');
				$service = substr($type,0,1).$rated->attr(false,'CLASSID');
				$amount = $rated->content('Rate');
				$delivery = false;
			} else {
				$mailsvc = $rated->content('MailService');
				$service = substr($type,0,1).$rated->attr(false,'ID');
				$amount = $rated->content('Postage');
				if ($SvcCommitments = $rated->content('SvcCommitments'))
					$delivery = $this->delivery($SvcCommitments);
			}


			if (is_array($this->settings['services']) && in_array($service,$this->settings['services']) ) { // && in_array($service,$this->rate['services']) WTF was this for??
				if ($service != 'd0' || "Package" == substr($mailsvc,-7)) {
					$slug = sanitize_title_with_dashes("$this->module-$service");
					$rate = array();
					$rate['name'] = $this->services[$service];
					$rate['slug'] = $slug;
					$rate['amount'] = $amount;
					$rate['delivery'] = $delivery;
					$options[$slug] = new ShippingOption($rate);
				}
			}
		}

		return $options;
	}

	function build ($postcode,$country) {
		$type = "RateV3"; // Domestic shipping rates
		if ($country != $this->base['country']) {
			global $Shopp;
			$type = "IntlRate";
			$countries = Lookup::countries();
			if ($country == "GB") $country = $countries[$country]['name'].' (Great Britain)';
			else $country = $countries[$country]['name'];
		}

		$_ = array('API='.$type.'&XML=<?xml version="1.0" encoding="utf-8"?>');
		$_[] = '<'.$type.'Request USERID="'.$this->settings['userid'].'">';

		$count = 1;
		while ( $this->packager->packages() ) {
			$pkg = $this->packager->package();

			$pounds = $ounces = 0;
			$weight = $pkg->weight();
			$weight = convert_unit($weight,'lb'); // Ensure we're working in pounds

			list($pounds,$ounces) = explode(".",$weight);
			$ounces = ceil( ( $weight - $pounds ) * 16 );
			// echo "pounds: $pounds, ounces: $ounces".BR;

			$_[] = '<Package ID="'.$count++.'">';
				if ($type == "IntlRate") {
					$_[] = '<Pounds>'.$pounds.'</Pounds>';
					$_[] = '<Ounces>'.$ounces.'</Ounces>';
					$_[] = '<Machinable>TRUE</Machinable>';
					$_[] = '<MailType>Package</MailType>';
					$_[] = '<ValueOfContents>'.$pkg->value().'</ValueOfContents>';
					$_[] = '<Country>'.$country.'</Country>';
					if ( $pkg->length() + $pkg->width() + $pkg->height() > 0 ) {
						$_[] = '<GXG><Length>'.convert_unit($pkg->length(), 'in').'</Length>';
						$_[] = '<Width>'.convert_unit($pkg->width(), 'in').'</Width>';
						$_[] = '<Height>'.convert_unit($pkg->height(), 'in').'</Height></GXG>';
					}
				} else {
					$_[] = '<Service>ALL</Service>';
					$_[] = '<FirstClassMailType>PARCEL</FirstClassMailType>';
					$_[] = '<ZipOrigination>'.substr($this->settings['postcode'],0,5).'</ZipOrigination>';
					$_[] = '<ZipDestination>'.substr($postcode,0,5).'</ZipDestination>';
					$_[] = '<Pounds>'.$pounds.'</Pounds>';
					$_[] = '<Ounces>'.$ounces.'</Ounces>';
					$_[] = '<Container>VARIABLE</Container>';
					$_[] = '<Size>REGULAR</Size>';
					if ( $pkg->length() + $pkg->width() + $pkg->height() > 0 ) {
						$_[] = '<Width>'.convert_unit($pkg->width(), 'in').'</Width>';
						$_[] = '<Length>'.convert_unit($pkg->length(), 'in').'</Length>';
						$_[] = '<Height>'.convert_unit($pkg->height(), 'in').'</Height>';
					}
					$_[] = '<Machinable>TRUE</Machinable>';

				}
			$_[] = '</Package>';
		}
		$_[] = '</'.$type.'Request>';

		return join("\n",apply_filters('shopp_usps_request',$_));
	}

	function delivery ($timeframe) {
		list($start,$end) = sscanf($timeframe,"%d - %d Days");
		$days = $start.'d'.(!empty($end)?'-'.$end.'d':'');
		if (empty($start)) $days = "5d-15d";
		return $days;
	}

	function verify () {
		if (!$this->activated()) return;


		$this->weight = 1;
		$Item = new stdClass;
		$Item->quantity = 1;
		$Item->weight = 1;
		$Item->width = 1;
		$Item->length = 1;
		$Item->height = 1;
		$Item->sku = 'TESTSKU';
		$this->packager->add_item($Item);

		$request = $this->build('10022','US');
		$Response = $this->send($request);
		if ($Response->tag('Error')) new ShoppError($Response->content('Description'),'usps_verify_auth',SHOPP_ADDON_ERR);
	}

	function send ($data,$url=false,$options=array()) {
		$response = parent::send($data,$this->url);
		if (empty($response)) return false;
		return new xmlQuery($response);
	}

	function settings () {

		$this->ui->multimenu(0,array(
			'name' => 'services',
			'options' => $this->services,
			'selected' => $this->settings['services']
		));

		$this->ui->text(1,array(
			'name' => 'userid',
			'value' => $this->settings['userid'],
			'size' => 16,
			'label' => __('USPS User ID','Shopp')
		));

		$this->ui->text(1,array(
			'name' => 'postcode',
			'value' => $this->settings['postcode'],
			'size' => 16,
			'label' => __('Your postal code','Shopp')
		));

	}

	function logo () {
		return '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';
	}

}
?>