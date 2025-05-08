<?php
  /**
   * Memberships
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: membership.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Memberships")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Membership::mTable, Filter::$id);?>
<div class="tubi icon heading message coral"><a class="helper tubi top right info corner label" data-help="membership"><i class="icon help"></i></a> <i class="bookmark icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MS_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=memberships" class="section"><?php echo Lang::$word->_N_MEMBS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MS_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MS_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MS_SUBTITLE1 . $row->{'title'.Lang::$lang};?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MS_TITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MS_PRICE;?></label>
          <label class="input"><i class="icon-prepend icon dollar"></i><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->price;?>" name="price">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MS_PERIOD;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->days;?>" name="days">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MS_PERIOD;?></label>
          <?php echo Membership::getMembershipPeriod($row->period);?> </div>
      </div>
      <div class="tubi divider"></div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_MS_TRIAL;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="trial" type="radio" value="1" <?php echo getChecked($row->trial, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="trial" type="radio" value="0" <?php echo getChecked($row->trial, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MS_RECURRING;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="recurring" type="radio" value="1" <?php echo getChecked($row->recurring, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="recurring" type="radio" value="0" <?php echo getChecked($row->recurring, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MS_PRIVATE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="private" type="radio" value="1" <?php echo getChecked($row->private, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="private" type="radio" value="0" <?php echo getChecked($row->private, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MS_ACTIVE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="active" type="radio" value="1" <?php echo getChecked($row->active, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="active" type="radio" value="0" <?php echo getChecked($row->active, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="tubi divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_MS_DESC;?></label>
        <textarea name="description<?php echo Lang::$lang;?>" rows="4" cols="45"><?php echo $row->{'description'.Lang::$lang};?></textarea>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MS_UPDATE;?></button>
      <a href="index.php?do=memberships" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processMembership" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="tubi icon heading message coral"><a class="helper tubi top right info corner label" data-help="membership"><i class="icon help"></i></a> <i class="bookmark icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MS_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=memberships" class="section"><?php echo Lang::$word->_N_MEMBS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MS_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MS_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MS_SUBTITLE2;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MS_TITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MS_TITLE;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MS_PRICE;?></label>
          <label class="input"><i class="icon-prepend icon dollar"></i><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MS_PRICE;?>" name="price">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MS_PERIOD;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MS_PERIOD;?>" name="days">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MS_PERIOD;?></label>
          <?php echo Membership::getMembershipPeriod();?> </div>
      </div>
      <div class="tubi divider"></div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_MS_TRIAL;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="trial" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="trial" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MS_RECURRING;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="recurring" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="recurring" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MS_PRIVATE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="private" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="private" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MS_ACTIVE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="active" type="radio" value="1" checked="checked">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="active" type="radio" value="0">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="tubi divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_MS_DESC;?></label>
        <textarea placeholder="<?php echo Lang::$word->_MS_DESC;?>" name="description<?php echo Lang::$lang;?>" rows="4" cols="45"></textarea>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MS_ADD;?></button>
      <a href="index.php?do=memberships" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processMembership" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $memrow = $member->getMemberships();?>
<div class="tubi icon heading message coral"> <i class="icon bookmark"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MS_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_MEMBS;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MS_INFO3;?></div>
  <div class="tubi segment"> <a class="tubi icon positive button push-right" href="index.php?do=memberships&amp;action=add"><i class="icon add"></i> <?php echo Lang::$word->_MS_ADD_NEW;?></a>
    <div class="tubi header"><?php echo Lang::$word->_MS_SUBTITLE3;?></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_MS_TITLE4;?></th>
          <th data-sort="int"><?php echo Lang::$word->_MS_PRICE2;?></th>
          <th data-sort="string"><?php echo Lang::$word->_MS_EXPIRY;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$memrow):?>
        <tr>
          <td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->_MS_NOMBS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($memrow as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td><?php echo $core->formatMoney($row->price);?></td>
          <td><?php echo $row->days . ' ' . $member->getPeriod($row->period);?></td>
          <td><?php echo isActive($row->active);?> <a href="index.php?do=memberships&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MEMBERSHIP;?>" data-option="deleteMembership" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
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
