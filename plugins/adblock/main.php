<?php
  /**
   * AdBlock Plugin
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: main.php, v4.00 2014-12-24 12:12:12 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once(MODPATH . "adblock/admin_class.php");
  Registry::set('AdBlock', new AdBlock());
  
  
  Filter::$id = ###ADBLOCKID###;
  $ad = Registry::get("AdBlock")->getSingle();
  
  $ad_content = '';
  $fname = 'na';
 
  if($ad)
  {
	$fname = '';
  	$memberlevels = explode(',',$ad->memberlevels);
  	
  	//check credentials
  	if(is_array($memberlevels) && count($memberlevels))
  	{
  	  if(in_array($user->userlevel, $memberlevels))
  	  {
  	  	if(Registry::get("AdBlock")->isOnline($ad))
  	  	{
  	  		$fname = 'f_' . sha1(md5(rand() . time())).md5(sha1(Filter::$id));
  	  		$href=(strpos($ad->banner_image_link,'http://') === 0)?$ad->banner_image_link:'http://' . $ad->banner_image_link;
  	  		$ad_content = ($ad->banner_image)? ('<a href="' . $href . '" onclick="' . $fname . '()" title="' . $ad->banner_image_alt . '"><img src="' . SITEURL . '/' . AdBlock::imagepath . $ad->banner_image . '" alt="' . $ad->banner_image_alt . '" /></a>'):cleanOut($ad->banner_html);
  	  		Registry::get("AdBlock")->incrementViewsNumber();
  	  	}	
  	  }			
  	}	
  	
  }	
?>
<?php if($ad):?>
<!-- Start AdBlock Campaign -->
<div class="tubi basic segment"><?php echo $ad_content?></div>
<script type="text/javascript">
var <?php echo $fname?>_clicked = false;
function <?php echo $fname?>()
{
	if(<?php echo $fname?>_clicked) return;
	$.ajax({
		  type: 'POST',
		  url: '<?php echo SITEURL?>/modules/adblock/controller.php?adC=<?php echo Filter::$id;?>&f=<?php echo $fname?>',
		});
	<?php echo $fname?>_clicked = true;
}			
</script>
<!-- End AdBlock Campaign /-->
<?php endif;?>