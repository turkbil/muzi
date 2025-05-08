<?php
  /**
   * Email Templates
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: templates.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Templates")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::eTable, Filter::$id);?>
<div class="tubi icon heading message mortar"> <i class="mail icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_ET_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=templates" class="section"><?php echo Lang::$word->_N_EMAILS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_ET_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_ET_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_ET_SUBTITLE2 . $row->{'name'.Lang::$lang};?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_ET_TTITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'name'.Lang::$lang};?>" name="name<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_ET_SUBJECT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'subject'.Lang::$lang};?>" name="subject<?php echo Lang::$lang;?>">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_ET_BODY;?></label>
        <textarea id="bodypost" class="bodypost" name="body<?php echo Lang::$lang;?>"><?php echo $row->{'body'.Lang::$lang};?></textarea>
        <p class="tubi error note"><?php echo Lang::$word->_ET_VAR_T;?></p>
      </div>
      <div class="tubi divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_ET_TPL_DESC;?></label>
        <textarea name="help<?php echo Lang::$lang;?>"><?php echo $row->{'help'.Lang::$lang};?></textarea>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_ET_UPDATE;?></button>
      <a href="index.php?do=templates" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processTemplate" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="tubi icon heading message mortar"> <a class="helper tubi top right info corner label" data-help="email"><i class="icon help"></i></a><i class="mail icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_ET_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=templates" class="section"><?php echo Lang::$word->_N_EMAILS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_ET_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_ET_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_ET_SUBTITLE1;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_ET_TTITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_ET_TTITLE;?>" name="name<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_ET_SUBJECT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_ET_TTITLE;?>" name="subject<?php echo Lang::$lang;?>">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_ET_BODY;?></label>
        <textarea id="bodypost" class="bodypost" placeholder"<?php echo Lang::$word->_ET_BODY;?>" name="body<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="tubi divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_ET_TPL_DESC;?></label>
        <textarea placeholder"<?php echo Lang::$word->_ET_TPL_DESC;?>" name="help<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_ET_ADD;?></button>
      <a href="index.php?do=templates" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processTemplate" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $tplrow = $member->getEmailTemplates()?>
<div class="tubi icon heading message mortar"> <i class="mail icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_ET_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_EMAILS;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_ET_INFO3;?></div>
  <div class="tubi segment"><a class="tubi icon positive button push-right" href="index.php?do=templates&amp;action=add"><i class="icon add"></i> <?php echo Lang::$word->_ET_ADD;?></a>
    <div class="tubi header"><?php echo Lang::$word->_ET_SUBTITLE3;?></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_ET_TTITLE;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$tplrow):?>
        <tr>
          <td colspan="3"><?php Filter::msgSingleAlert(Lang::$word->_ET_NOTEMPLATE);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($tplrow as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->{'name'.Lang::$lang};?></td>
          <td><a href="index.php?do=templates&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a></td>
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