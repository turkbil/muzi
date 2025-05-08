<?php
  /**
   * Gateways
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: gateways.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Gateways")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Membership::gTable, Filter::$id);?>
<div class="tubi icon heading message coral"><a class="helper tubi top right info corner label" data-help="gateway"><i class="icon help"></i></a> <i class="share icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_GW_TITLE2;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=gateways" class="section"><?php echo Lang::$word->_N_GATES;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_GW_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_GW_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_GW_SUBTITLE1 . $row->displayname;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_GW_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->displayname;?>" name="displayname">
          </label>
        </div>
        <div class="field">
          <label><?php echo $row->extra_txt;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->extra;?>" name="extra">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo $row->extra_txt2;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->extra2;?>" name="extra2">
          </label>
        </div>
        <div class="field">
          <label><?php echo $row->extra_txt3;?></label>
          <?php if($row->name == "offline"):?>
          <textarea name="extra3"><?php echo $row->extra3;?></textarea>
          <?php else:?>
          <input type="text" value="<?php echo $row->extra3;?>" name="extra3">
          <?php endif;?>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_GW_LIVE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="live" type="radio" value="1" <?php echo getChecked($row->live, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="live" type="radio" value="0" <?php echo getChecked($row->live, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <div class="inline-group">
            <label><?php echo Lang::$word->_GW_ACTIVE;?></label>
            <label class="radio">
              <input name="active" type="radio" value="1" <?php echo getChecked($row->active, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="active" type="radio" value="0" <?php echo getChecked($row->active, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_GW_IPNURL;?></label>
        <?php echo SITEURL.'/gateways/'.$row->dir.'/ipn.php';?> </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_GW_UPDATE;?></button>
      <a href="index.php?do=gateways" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processGateway" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $gaterow = $member->getGateways();?>
<div class="tubi icon heading message coral"> <i class="icon share"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_GW_TITLE2;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_GATES;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_GW_INFO2;?></div>
  <div class="tubi segment">
    <div class="tubi header"><?php echo Lang::$word->_GW_SUBTITLE2;?></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_GW_NAME;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$gaterow):?>
        <tr>
          <td colspan="3"><?php echo Filter::msgSingleAlert(Lang::$word->_GW_NOGATEWAY);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($gaterow as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->displayname;?></td>
          <td><?php echo isActive($row->active);?> <a href="index.php?do=gateways&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
</div>
<?php break;?>
<?php endswitch;?>