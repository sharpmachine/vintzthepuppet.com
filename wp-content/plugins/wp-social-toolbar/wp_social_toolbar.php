<?php
/*
Plugin Name: WP Social Toolbar
Plugin URI: http://www.daddydesign.com/wordpress/social-toolbar-wordpress-plugin/
Description: Wordpress plugin for adding a customizable toolbar with color selection, social network icons, recent tweet and share buttons in footer.
Version: 2.3
Author: DaddyDesign
Tags: footer, toolbar, social networking, social icons, tool bar, share, facebook like, tweet, recent tweet, facebook, twitter, settings, customize, colors,wibiya, social toolbar,google +1,google plusone,plusone,google share
Author URI: http://www.daddydesign.com
*/

/*  Copyright 2011  daddydesign.com  (email : daddydesign@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
global $wp_version;	
$plugin_name="Wordpress Social Toolbar Plugin";
$exit_msg=$plugin_name.' requires WordPress 2.9 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';

$wpst_version='2.3';

/* LOAD PLUGIN LANGUAGE FILES */
load_plugin_textdomain('WPSOCIALTOOLBAR',false,'wp-social-toolbar/languages');

$wp_footer_plugin=defined('WP_PLUGIN_URL') ? (WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__))) : trailingslashit(get_bloginfo('wpurl')) . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__)); 

if (version_compare($wp_version,"2.9","<"))
{
	exit ($exit_msg);
}
if (!defined('WP_CONTENT_URL')) {
	$content_url=content_url();
	define('WP_CONTENT_URL', $content_url);
}
define('WP_SOCIAL_TOOLBAR_PATH',WP_CONTENT_URL.'/plugins/wp-social-toolbar/');

global $WPSocialDefaults,$WPSocialSettings,$wps_social_profiles,$wps_social_settings;

$WPSocialSettings=get_option('WPSocialToolbarOptions');
$wps_social_settings=get_option('WPSocialToolbarICONS');
$rss_url='';
$wps_social_profiles=array(
'0'=>array('name'=>'RSS','url'=>'','order'=>0,'enable'=>1),
'1'=>array('name'=>'twitter','url'=>'daddydesign','order'=>1,'enable'=>1),
'2'=>array('name'=>'facebook','url'=>'','order'=>2,'enable'=>1),
'3'=>array('name'=>'myspace','url'=>'','order'=>3,'enable'=>1),
'4'=>array('name'=>'LinkedIn','url'=>'','order'=>4,'enable'=>1),
'5'=>array('name'=>'flickr','url'=>'','order'=>5,'enable'=>1),
'6'=>array('name'=>'vimeo','url'=>'','order'=>6,'enable'=>1),
'7'=>array('name'=>'YouTube','url'=>'','order'=>7,'enable'=>1),
'8'=>array('name'=>'apple','url'=>'','order'=>8,'enable'=>1),
'9'=>array('name'=>'bebo','url'=>'','order'=>9,'enable'=>1),
'10'=>array('name'=>'Dribble','url'=>'','order'=>0,'enable'=>0),
'11'=>array('name'=>'foursquare','url'=>'','order'=>11,'enable'=>0),
'12'=>array('name'=>'hi5','url'=>'','order'=>12,'enable'=>0),
'13'=>array('name'=>'iLike','url'=>'','order'=>13,'enable'=>0),
'14'=>array('name'=>'ning','url'=>'','order'=>14,'enable'=>0),
'15'=>array('name'=>'ping','url'=>'','order'=>15,'enable'=>0),
'16'=>array('name'=>'reverbnation','url'=>'','order'=>16,'enable'=>0),
'17'=>array('name'=>'Skype','url'=>'','order'=>17,'enable'=>0),
'18'=>array('name'=>'Lastfm','url'=>'','order'=>18,'enable'=>0),
'19'=>array('name'=>'MeetUp','url'=>'','order'=>19,'enable'=>0),
'20'=>array('name'=>'Orkut','url'=>'','order'=>20,'enable'=>0),
'21'=>array('name'=>'StumbleUpon','url'=>'','order'=>21,'enable'=>0),
'22'=>array('name'=>'Digg','url'=>'','order'=>22,'enable'=>0),
'23'=>array('name'=>'Tumblr','url'=>'','order'=>23,'enable'=>0),
'24'=>array('name'=>'Xing','url'=>'','order'=>24,'enable'=>0),
'25'=>array('name'=>'Beatport','url'=>'','order'=>25,'enable'=>0),
'26'=>array('name'=>'SoundCloud','url'=>'','order'=>26,'enable'=>0),
'27'=>array('name'=>'Spotify','url'=>'','order'=>27,'enable'=>0),
'28'=>array('name'=>'Google+','url'=>'','order'=>10,'enable'=>0),
'29'=>array('name'=>'Email','url'=>'','order'=>11,'enable'=>0)
);

$WPSocialDefaults=array(
'background_color'=>'000000', //Default Background Color
'twitter_background'=>'999999', //Twitter Background Color
'border_color'=>'666666', //Border Color
'icon_type'=>'gray', //Icon Type
'font_family'=>'Arial, Helvetica, sans-serif', //Font Family
'font_size'=>'12px', //Font Size
'font_color'=>'ffffff', //Font Color
'link_color'=>'ffffff', //Link Color
'button_color'=>'white', // Button color
'bird_color'=>'white', //Link Color
'show_tweeter'=>'yes', // Show Tweeter Message
'hover_background'=>'ffffff', // Hover Image Background Color
'rss_url'=>$rss_url, //RSS URL,
'home_page'=>1, //RSS URL,
'category_archive'=>1, //RSS URL,
'blog_single_post'=>'blog_single_post',
'share_home'=>'true',
'google_plus_one'=>'false',
'twitter_timestamp'=>'false',
'max_icons'=>14,
'facebook_setting'=>'false',
'fan_page'=>'https://www.facebook.com/wordpressdesign'
);


/*Function to Call when Plugin get activated*/
function WPSOCIALTOOLBAR_activate()
{
	global $WPSocialDefaults,$values,$wps_social_profiles;
	$default_settings = get_option('WPSocialToolbarOptions');
	$default_settings= wp_parse_args($default_settings, $WPSocialDefaults);
	$default_social_settings = get_option('WPSocialToolbarICONS');
	$default_social_settings= wp_parse_args($default_social_settings, $wps_social_profiles);
	add_option('WPSocialToolbarOptions',$default_settings);
	add_option('WPSocialToolbarICONS',$default_social_settings);
}

/* Function to Call when Plugin Deactivated */
function WPSOCIALTOOLBAR_deactivate()
{
  /* Code needs to be added for deactivate action */


}

register_activation_hook( __FILE__, 'WPSOCIALTOOLBAR_activate' );
register_deactivation_hook( __FILE__, 'WPSOCIALTOOLBAR_deactivate' );

/* Add Administrator Menus */
function WPSOCIALTOOLBAR_admin_menu()
{
	$level = 'level_7';
	add_menu_page('Social Toolbar', 'Social Toolbar', $level, __FILE__, 'wpsocialtoolbar_options_page',WP_SOCIAL_TOOLBAR_PATH.'images/icon.png');
	add_submenu_page(__FILE__, 'Social Profiles', 'Social Profiles', $level, 'wpsocialtoolbar_social_icons','wpsocialtoolbar_social_icons');
}

add_action('admin_menu','WPSOCIALTOOLBAR_admin_menu');	

/*WPSOCIALTOOLBAR Options Page*/
function wpsocialtoolbar_options_page()
{
	include_once dirname(__FILE__).'/includes/options.php';
}

/*wpsocialtoolbar_social_icons ICONS*/
function wpsocialtoolbar_social_icons()
{
	include_once dirname(__FILE__).'/includes/social_profiles.php';
}

/* Function to Get Recend Feeds */
function WPSOCIALTOOLBARNewsFeeds($feed='http://feeds2.feedburner.com/daddydesign',$count=5)
{
			include_once(ABSPATH . WPINC . '/feed.php');
		// Get a SimplePie feed object from the specified feed source.
		$rss = fetch_feed($feed);
		if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
	    // Figure out how many total items there are, but limit it to 5. 
		$maxitems = $rss->get_item_quantity($count); 
	    // Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items(0, $maxitems); 
		endif;
	echo '<ol class="WPSOCIALTOOLBAR_latest_news">';
    if ($maxitems == 0) echo '<li>No items.</li>';
    else
    // Loop through each feed item and display each item as a hyperlink.
    foreach ( $rss_items as $item ) : 
    echo '<li>';
    echo '<a href="'.$item->get_permalink().'" title="">'.$item->get_title().'</a></li>';
    endforeach; 
	echo '</ol>';
}
// ADD Content Slide JS TO HEAD SECTION

function WPSOCIALTOOLBAR_print_scripts() {
	global $WPSocialSettings;
    wp_enqueue_script ('jquery');
	wp_enqueue_script('wpsocialtoolbar',WP_SOCIAL_TOOLBAR_PATH.'js/scripts.js',array('jquery'));
	wp_enqueue_script('wpstcorescripts',WP_SOCIAL_TOOLBAR_PATH.'js/corescripts.js',array('jquery'));
	if($WPSocialSettings['google_plus_one']=='true')
	{
		//wp_enqueue_script('googleplusone','https://apis.google.com/js/plusone.js');		
	}
}
add_action('wp_print_scripts', 'WPSOCIALTOOLBAR_print_scripts');
add_action('wp_head', 'WPSOCIALTOOLBAR_script_style');
function WPSOCIALTOOLBAR_script_style() { 
global $WPSocialSettings; 
if($WPSocialSettings['background_color']!='')
{
$background_color=$WPSocialSettings['background_color'];
}
else
{
$background_color='000000';
}
if($WPSocialSettings['border_color']!='')
{
$border_color=$WPSocialSettings['border_color'];
}
else
{
$border_color='999999';
}
if($WPSocialSettings['twitter_background']!='')
{
$twitter_background=$WPSocialSettings['twitter_background'];
}
else
{
$twitter_background='999999';
}
if($WPSocialSettings['opacity']!='')
{
$opacity=$WPSocialSettings['opacity'];
}
else
{
$opacity='0.7';
}
if($WPSocialSettings['hover_background']!='')
{
$hover_background=$WPSocialSettings['hover_background'];
}
else
{
$hover_background='0.7';
}
if($WPSocialSettings['font_color']!='')
{
$twitter_color=$WPSocialSettings['font_color'];
}
else
{
$twitter_color='ffffff';
}
if($WPSocialSettings['link_color']!='')
{
$twitter_link=$WPSocialSettings['link_color'];
}
else
{
$twitter_link='fffffff';
}
if($WPSocialSettings['font_size']!='')
{
$font_size=$WPSocialSettings['font_size'];
}
else
{
$font_size='13px';
}
if($WPSocialSettings['font_family']!='')
{
$font_fam=stripslashes($WPSocialSettings['font_family']);
$font_family='font-family:'.$font_fam.';';
}
else
{
$font_family='';
}



	$bird_color=$WPSocialSettings['bird_color'];

?>
<link rel="stylesheet" type="text/css" href="<?php echo WP_SOCIAL_TOOLBAR_PATH;?>css/wp_social_toolbar.css" />
<style type="text/css" media="screen">
#wps-toolbar-show
{ background:#<?php echo $border_color; ?> !important; }
#wp-social-toolbar-show-box
{
	border-bottom:5px solid #<?php echo $border_color; ?> !important;
}
#wps-toolbar-content #wps-toolbar-top #wps-close-button,.wpcs-border
{
	background:#<?php echo $border_color;?> !important;
}
#wps-toolbar-content #wps-toolbar-top #wps-twitter-status
	{
	background-color:#<?php echo $twitter_background; ?> !important;
	<?php echo $font_family;?>
	color:#<?php echo $twitter_color;?>;
	font-size:<?php echo $font_size;?>;
	background-image:url('<?php echo WP_SOCIAL_TOOLBAR_PATH;?>/images/icons/<?php echo $bird_color;?>/bird.png');
	background-repeat:no-repeat;
	}

#wpsc-social-accounts,#wps-toolbar-bottom
{
	background:#<?php echo $background_color;?> !important;
}
#wpsc-social-accounts img:hover,.daddydesign:hover
	{
	background:#<?php echo $hover_background;?>;
	}
#wp-social-toolbar-show-box,#wps-toolbar-content #wps-toolbar-bottom #wpsc-social-accounts img,#wps-toolbar-content #wps-toolbar-bottom,.wpcs-share-icons
{
	border-color:#<?php echo $border_color;?> !important;
}
#wps-toolbar-content #wps-toolbar-top #wps-twitter-status a
{
	color:#<?php echo $twitter_link;?>;
}
<?php
	if($WPSocialSettings['opacity']!='')
	{
?>
<?php
	}
?>
</style>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="<?php echo WP_SOCIAL_TOOLBAR_PATH;?>css/ie.css" />
<![endif]-->
<?php
}

function WPSOCIALTOOLBAR_parse_feed($feed) {
$stepOne = explode("<content type=\"html\">", $feed);
$stepTwo = explode("</content>", $stepOne[1]);
$tweet = $stepTwo[0];
$tweet = str_replace("&lt;", "<", $tweet);
$tweet = str_replace("&gt;", ">", $tweet);
return $tweet;
}
function WPSOCIALTOOLBAR_TWITTER_MESSAGE()
{
global $WPSocialSettings;
	$social_icons=get_option('WPSocialToolbarICONS'); 

?>
<div id="twitter_div"><ul id="twitter_update_list"></ul></div>
	<?php
	if($social_icons[1]['url']=='' || $social_icons[1]['url']==' ')
	{
		$social_icons[1]['url']='daddydesign';
	}
	?>
	<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
	<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $social_icons[1]['url'];?>.json?callback=twitterCallback2&count=1"></script>
<?php
}
/* Include HTML Code to footer */
function WPSOCIALTOOLBAR_html_code()
{	
	if(wpst_display_check())
	{
		WPSOCIALTOOLBAR_display_code();
	}
}

function WPSOCIALTOOLBAR_display_code()
{
	global $WPSocialSettings,$wpst_version;
	$WPSocialSettings=get_option('WPSocialToolbarOptions');
	$theme_folder=$WPSocialSettings['icon_type'];
	$button_color=$WPSocialSettings['button_color'];
	$bird_color=$WPSocialSettings['bird_color'];
	?>
<div id="wp-social-toolbar" class="wp-social-toolbar-<?php echo $wpst_version;?>">
	<div id="wp-social-toolbar-show-box">
			<div id="wps-toolbar-show">
			<img src="<?php echo plugins_url('images/icons/'.$button_color.'/show.png',__FILE__); ?>" class="wpsc_show_button" alt="show"/>
			</div>    
    </div>
    <div class="wpcs-border">&nbsp;</div>
    <div id="wps-toolbar-content">
    	<div id="wps-toolbar-top">
        	<div id="wps-close-button">
            	<img src="<?php echo plugins_url('images/icons/'.$button_color.'/close.png',__FILE__); ?>" class="wpsc_close_button" alt="close" />
            </div>
			<?php
			if($WPSocialSettings['show_tweeter']=='yes')
			{
			?>
            
            	<?php
				wpst_new_tweets();
				?>
	        
			<?php
			}
			else
			{
				echo '<div id="wps-twitter-status-no"></div>';
			}
			?>
        </div>
        <div id="wps-toolbar-bottom">
        	<div id="wpsc-social-accounts">
			
				<?php
				$social_icons=get_option('WPSocialToolbarICONS');
				$social_settings=get_option('WPSocialToolbarOptions');
				$social_icons=wpst_aasorting($social_icons,"order");
				?>
			<!-- START LOOP -->
			<?php 
			$count=0;
			while (list($key, $value) = each($social_icons)) 
			{	
				if($value['enable']==1)
				{
					$value['name']=strtolower($value['name']);
					if($value['name']=='twitter')
					{
						if($value['url']=='' || $value['url']==' ')
						{
							$value['url']='daddydesign';
						}
					?>
					
					<a href="http://www.twitter.com/<?php echo $value['url']; ?>" title="" target="_blank"><img src="<?php echo plugins_url('images/'.$theme_folder.'/'.$value['name'].'.png',__FILE__); ?>" alt="Follow on Twitter" /></a>
					<?php
					}
					elseif($value['name']=='skype')
					{
						$value['url']=trim($value['url']);
						?>
					<a href="skype:<?php echo $value['url']; ?>?add" title="" target="_blank"><img src="<?php echo plugins_url('images/'.$theme_folder.'/'.$value['name'].'.png',__FILE__); ?>" alt="Skype" /></a>
						<?php
					}
					elseif($value['name']=='gtalk')
					{
						$value['url']=trim($value['url']);
						?>
					<a href="gtalk:chat?jid=<?php echo $value['url']; ?>" title="" target="_blank"><img src="<?php echo plugins_url('images/'.$theme_folder.'/'.$value['name'].'.png',__FILE__); ?>" alt="gtalk" /></a>
						<?php
					}
					elseif($value['name']=='google+')
					{
					?>
					<a href="<?php echo $value['url']; ?>" title="Google +" target="_blank"><img src="<?php echo plugins_url('images/'.$theme_folder.'/googleplus.png',__FILE__); ?>" alt="google+" /></a>
					<?php
					}
					else
					{
					?>
					<a href="<?php echo $value['url']; ?>" title="" target="_blank"><img src="<?php echo plugins_url('images/'.$theme_folder.'/'.$value['name'].'.png',__FILE__); ?>" alt="<?php echo $value['name']; ?>" /></a>
					<?php
					}
				}
			}
			?>
			<!-- END LOOP -->
				
			
            	
				
            </div>
			<?php
			$social_icons=get_option('WPSocialToolbarICONS'); 
			if($WPSocialSettings['share_home']=='true')
			{
				$share_url=get_bloginfo('url');
			}
			else
			{
				if(is_single()||is_page())
				{
				$share_url=urlencode(get_permalink($post->ID));
				}
				elseif(is_archive())
				{
				
				$share_url=wpst_curPageURL();
				}
				else
				{
				$share_url=wpst_curPageURL();
				}
			}
			if($WPSocialSettings['facebook_setting']=='true')
			{
				$fb_share=$WPSocialSettings['fan_page'];
			}
			else
			{
				$fb_share=$share_url;
			}
		echo base64_decode('PGRpdiBpZD0id3BzYy1zb2NpYWwtY291bnRzIj48ZGl2IGNsYXNzPSJ3cGNzLXNoYXJlLWljb25zIGRhZGR5ZGVzaWduIj48YSBocmVmPSJodHRwOi8vd3d3LmRhZGR5ZGVzaWduLmNvbS93b3JkcHJlc3Mvc29jaWFsLXRvb2xiYXItd29yZHByZXNzLXBsdWdpbi8iIHRpdGxlPSJDdXN0b20gV29yZHByZXNzIERlc2lnbiIgdGFyZ2V0PSJfYmxhbmsiPjxpbWcgc3JjPSJodHRwOi8vc29jaWFsdG9vbGJhcnByby5jb20vY3JlZGl0L2RhZGR5ZGVzaWduLnBuZyIgLz48L2E+PC9kaXY+');
		$output='<div class="wpcs-share-icons"><script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script><a href="http://twitter.com/share?url='.$share_url.'&via='.$social_icons[1]['url'].'&count=horizontal" class="twitter-share-button">Tweet</a></div>';
		if($WPSocialSettings['google_plus_one']=='true')
		{
			if($WPSocialSettings['share_home']!='true')
			{
			$output.='<div class="wpcs-share-icons"><div class="g-plusone" data-size="medium"></div></div>';
			}
			else
			{
			$output.='<div class="wpcs-share-icons"><div class="g-plusone" data-size="medium" data-href="'.get_bloginfo('url').'"></div></div>';
			}
			$output.='<script type="text/javascript"> (function() { var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;  po.src = \'https://apis.google.com/js/plusone.js\'; var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s); })(); </script>';
		}
		$output.='<div class="wpcs-share-icons"><iframe src="http://www.facebook.com/plugins/like.php?href='.$fb_share.'&amp;layout=button_count&amp;show_faces=true&amp;width=90&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=25" scrolling="no" frameborder="0" style="border:none;margin-left:auto;margin-right:auto; overflow:hidden; width:90px; height:25px;" allowTransparency="true"></iframe></div></div></div></div>';
		echo $output;
			?>
</div>
	<?php
}


	add_action('wp_footer', 'WPSOCIALTOOLBAR_html_code');
function wpst_aasorting (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
	return $array;
}

/* Wordpress Add Widget to Wordpress Dashboard */
// Create the function to output the contents of our Dashboard Widget

function wpst_dashboard_widget_function() {

	include_once dirname(__FILE__).'/includes/dashboard_widget.php'; 
} 

// Create the function use in the action hook

function wpst_add_dashboard_widgets() {
wp_add_dashboard_widget('wpst_dashboard_widget', 'DaddyDesign.com News', 'wpst_dashboard_widget_function');	
} 

// Hook into the 'wp_dashboard_setup' action to register our other functions

add_action('wp_dashboard_setup', 'wpst_add_dashboard_widgets',1 );


// Function to DETECT mobile phones

function wpst_mobileCSS() {
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))|| strstr($useragent,"iPad"))
	{
	echo '<style type="text/css"> #wp-social-toolbar{ display:none !important; } </style>';

	}
}

add_action('wp_footer', 'wpst_mobileCSS');

function wpst_new_tweets()
{
	global $WPSocialSettings;
	if (false === ( $fs_tweets = get_transient('wpst_recent_tweet_1_5') ) ) {//if tweets are not in the cache
     $fs_tweets = wpst_get_tweets();//fetch them
     set_transient('wpst_recent_tweet_1_5', $fs_tweets, 60*5);//cache them for 1 hour
	}
	if($fs_tweets!=FALSE)
	{
	echo '<div id="wps-twitter-status">';
	echo make_clickable($fs_tweets[0]->text);
	if($WPSocialSettings['twitter_timestamp']=='true')
	{
	$real_time=wpst_twitter_time_difference($fs_tweets[0]->created_at);
	echo '<span class="wps-tweetstamp">'.$real_time.'</span>';
	}
	echo '</div>';
	}
}
function wpst_get_tweets()
{
	global $WPSocialSettings;
	$social_icons=get_option('WPSocialToolbarICONS'); 
	if($social_icons[1]['url']=='' || $social_icons[1]['url']==' ')
	{
		$social_icons[1]['url']='daddydesign';
	}
	$social_icons[1]['url']=trim($social_icons[1]['url']);
	$url = "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=".$social_icons[1]['url']."&include_rts=true&count=1";	
    $twitter = @file_get_contents($url);
	if($twitter!=FALSE)
	{
    $fs_tweets = json_decode($twitter);
	}
	else
	{
		$fs_tweets=FALSE;
	}
    return $fs_tweets;
}
/* Function to get current page url */
function wpst_curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL; 
}

/* Added in wp-social-toolbar 1.8 to test Display Settings */
function wpst_display_check()
{
	global $WPSocialSettings;

	$social_icons=get_option('WPSocialToolbarICONS'); 
	$url = wpst_curPageURL();
	$display_code=0;
	$specific_pages=explode(',',$WPSocialSettings['specific_pages']);
	if(is_single() || is_page())
	{
		global $post,$posts;
		$page_id=$post->ID;
	}
	else
	{
		$page_id=0;
	}
	if($WPSocialSettings['whole_website']=='true')
	{
		return true;
	}
	else
	{
		if(isset($WPSocialSettings['home_page']) && $url==get_bloginfo('url').'/')
		{

			return true;
		}
		elseif(isset($WPSocialSettings['category_archive']) && (is_archive() || is_tag() || is_tax() || is_author()))
		{
			return true;
		}
		elseif(isset($WPSocialSettings['blog_single_post']) && is_single())
		{
			return true;
		}
		elseif(count($specific_pages)>0 && (is_single() || is_page()))
		{
			if(in_array($page_id,$specific_pages))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

}
function wpst_twitter_time_difference($date)
{
    if(empty($date)) {
        return "No date provided";
    }
   
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
   
    $now             = time();
    $unix_date         = strtotime($date);
   
       // check validity of date
    if(empty($unix_date)) {   
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {   
        $difference     = $now - $unix_date;
        $tense         = "ago";
       
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
   
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
   
    $difference = round($difference);
   
    if($difference != 1) {
        $periods[$j].= "s";
    }
   
    return "$difference $periods[$j] {$tense}";
}
?>