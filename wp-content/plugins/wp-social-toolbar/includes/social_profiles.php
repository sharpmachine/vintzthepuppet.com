<div class="wrap">
	<h2><?php echo _e("Social Profile URL's",'WPSOCIALTOOLBAR'); ?></h2>

	<?php include_once dirname(__FILE__).'/go_pro_ad.php'; ?>
	<?php
	if(isset($_POST['wpst_hidden_icon_profiles']))
	{

		unset($_POST['update']);
		
		ksort($_POST['social_profile']);
		

		$old_values=get_option('WPSocialToolbarICONS');
		
		
		for($i=0;$i<count($old_values);$i++)
		{
			$old_values[$i]['url']=$_POST['social_profile'][$i];
			if(in_array($i,$_POST['social_toolbar_enable']))
			{
				$old_values[$i]['enable']=1;
			}
			else
			{
				$old_values[$i]['enable']=0;
			}
		}
		update_option('WPSocialToolbarICONS', $old_values);


		echo '<div class="updated fade" id="message"><p>';
		_e('Wordpress Social Toolbar Settings <strong>Updated</strong>');
		echo '</p></div>';
		
	}
	?>


		<table cellspacing="5" cellpadding="5" border="0" width="100%">
	<tr>
	<td width="70%" valign="top">
	<div class="maxi_left">
	<?php
	$options=get_option('WPSocialToolbarOptions');
	$form_url=admin_url().'admin.php?page=wpsocialtoolbar_social_icons';
	?>
		<form name="social_toolbar_icons_form" id="social_toolbar_icons_form" method="POST" action="<?php echo $form_url;?>">
		<?php include_once dirname(__FILE__).'/social_icons.php'; ?>	
		</form>
	</div>
	</td>
	<td width="30%" valign="top">
	<div class="maxi_right">
	<?php include_once dirname(__FILE__).'/our_feeds.php'; ?>
	</div>
	</td></tr>
	</table>
</div>