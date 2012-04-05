<script type="text/javascript" src="<?php echo WP_SOCIAL_TOOLBAR_PATH;?>js/jquery-1.5.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo WP_SOCIAL_TOOLBAR_PATH;?>/js/jquery-ui-1.7.1.custom.min.js">
</script>
<script type="text/javascript">
  // When the document is ready set up our sortable with it's inherant function(s)
  	

  $(document).ready(function() {


    $(":checkbox").click(function(){
		 var n = $("input:checked").length;
		if(n>14)
		{
		  alert('Only 14 icons can be displayed');
		  $(this).attr('checked', false);
		}
		else
		{
			// $('.maxi_left input[type=checkbox]').attr('disabled','false');
		}

	
	
	});

	 
    $("#social_toolbar_icon_list").sortable({
      handle : '.handle',
      update : function () {
		  var order = $('#social_toolbar_icon_list').sortable('serialize');
  		$("#info").load("<?php echo WP_SOCIAL_TOOLBAR_PATH;?>/includes/social_icons_values.php?"+order);
      }
    });
});
</script>
<div id="info">&nbsp;</div>
<table cellspacing="5" cellpadding="5" class="widefat" width="400">
			<thead>
			<tr>
			<th scope="col" colspan="2"><?php _e('Social Account Settings','WPSOCIALTOOLBAR'); ?>
			</th>
			</tr>
			</thead>
<tr>
<td colspan="2">
			<input type="hidden" name="wpst_hidden_icon_profiles" value="UPDATED" />
			
            <input type="submit" class="button-primary" value="<?php _e('Save Settings','WPSOCIALTOOLBAR') ?>" />
</td>
</tr>
<style type="text/css">
#social_toolbar_icon_list {
	list-style: none;
}

#social_toolbar_icon_list li {
	display: block;
	padding: 10px 10px; margin-bottom: 3px;
	background-color: #efefef;
	border:1px solid #cccccc;
}
#social_toolbar_icon_list li span
{
	width:120px;
	padding:0px 20px 0px 0px;
	font-weight:bold;
	float:left;
	text-transform:capitalize;
}
#social_toolbar_icon_list li img.handle {
	margin-right: 20px;
	cursor: move;
	float:left;
}
</style>
<tr>
<td colspan="2"><span style="color:#666"><?php _e('Choose up to 14 icons at a time','WPSOCIALTOOLBAR'); ?></span></td>
</tr>
<tr>
<td colspan="2">
<?php

$social_icons=get_option('WPSocialToolbarICONS');
global $wps_social_profiles;

/* This code only runs when new icons added to the plugin */
if(count($social_icons)<count($wps_social_profiles))
{
	for($i=count($social_icons);$i<count($wps_social_profiles);$i++)
	{
		$social_icons[$i]=$wps_social_profiles[$i];
	}
	update_option('WPSocialToolbarICONS', $social_icons);
}

$DDOptions=get_option('WPSocialToolbarOptions');
$social_icons=wpst_aasorting($social_icons,"order");
?>
			<ul id="social_toolbar_icon_list">
			<?php 
			while (list($key, $value) = each($social_icons)) 
			{
			$checked = $value['enable'] ? "checked" : ""; 
			if(strtolower($value['name'])=='googleplus')
			{
				$value['name']='google+';
			}
			if(strtolower($value['name'])== 'google+')
			{
				$bgimage=WP_SOCIAL_TOOLBAR_PATH.'images/'.$DDOptions['icon_type'].'/googleplus.png';;
			}
			else
			{
				$bgimage=WP_SOCIAL_TOOLBAR_PATH.'images/'.$DDOptions['icon_type'].'/'.strtolower($value['name']).'.png';;
			}
			?>
			<li id="listItem_<?php echo $key; ?>" style="background-image:url(<?php echo $bgimage;?>); background-repeat:no-repeat; background-position:right  5px;"><img src="<?php echo WP_SOCIAL_TOOLBAR_PATH;?>images/arrow.png" alt="move" width="16" height="16" class="handle" />
			<span><?php _e($value['name'].': ','WPSOCIALTOOLBAR'); ?></span><input type="text"  name="social_profile[<?php echo $key;?>]" value="<?php echo $value['url']; ?>" size="40" />
			<input type="checkbox" name="social_toolbar_enable[]" value="<?php echo $key;?>" <?php echo $checked;?> />
			<?php 
			$social_website=strtolower($value['name']);	
			if($social_website=='twitter' || $social_website=='skype'):?>
			<p style="text-align:left;padding-left:40px;"><span>&nbsp;</span><small><?php _e('( Just Enter '.$value['name'].' Username )','WPSOCIALTOOLBAR'); ?></small></p>
			<?php endif; ?>
			<?php 
			if($social_website=='email'):?>
			<p style="text-align:left;padding-left:40px;"><span>&nbsp;</span><small><?php _e('( e.g. mailto:yourname@example.com )','WPSOCIALTOOLBAR'); ?></small></p>
			<?php endif; ?>
			</li>
			<?php
			}
			
			?>
			
</ul>
</td>
</tr>
<tr>
<td colspan="2">
			<input type="hidden" name="wpst_hidden_icon_profiles" value="UPDATED" />
			
            <input type="submit" class="button-primary" value="<?php _e('Save Settings','WPSOCIALTOOLBAR') ?>" />
</td>
</tr>
</table>