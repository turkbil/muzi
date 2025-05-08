<?php
  /**
   * loadComments
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: loadComments.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once("../../init.php");
  
  require_once (MODPATH . "blog/admin_class.php");
  Registry::set('Blog', new Blog());

  if (isset($_GET['pg']) and isset($_GET['artid'])) :
      $page = intval($_GET['pg']);
      $pid = intval($_GET['artid']);

      $start = ($page - 1) * Registry::get("Blog")->cperpage;
      $limit = $start . ',' . Registry::get("Blog")->cperpage;

      $sql = "SELECT c.*, UNIX_TIMESTAMP(c.created) as cdate, u.avatar, u.username as uname" 
	  . "\n FROM " . Blog::cmTable . " as c" 
	  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = c.user_id" 
	  . "\n WHERE c.artid = " . intval($pid) 
	  . "\n AND c.active = 1" 
	  . "\n ORDER BY c.created " . Registry::get("Blog")->sorting . " LIMIT  " . $limit;
	  
      $comrows = $db->fetch_all($sql);
  endif;
?>
<?php if(isset($_GET['pg']) and isset($_GET['artid'])):?>
<?php if($comrows):?>
<?php foreach ($comrows as $comrow):?>
<div class="comment clearfix" data-id="<?php echo $comrow->id;?>">
<?php if($user->is_Admin()):?><a data-content="<?php echo Lang::$word->_DELETE;?>" class="delete" data-id="<?php echo $comrow->id;?>"><i class="icon danger link remove"></i></a><?php endif;?>
  <div class="avatar"> <img src="<?php echo UPLOADURL;?>avatars/<?php echo ($comrow->avatar) ? $comrow->avatar : "blank.png";?>" alt=""> </div>
  <div class="content">
    <span class="author"><?php echo ($comrow->user_id ? '<a href="' . Url::Page($core->profile_page, $comrow->uname. '/') . '"> ' .$comrow->uname. '</a>' : ($comrow->uname ? $comrow->uname : Lang::$word->_GUEST));?></span>
    <div class="metadata"> <span class="date"><i class="icon time"></i> <?php echo timesince($comrow->cdate);?></span> </div>
    <div class="text"> <?php echo cleanOut($comrow->body);?></div>
  </div>
</div>
<?php endforeach;?>
<?php unset($comrow);?>
<?php endif;?>
<?php endif;?>