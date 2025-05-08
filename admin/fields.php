<?php
  /**
   * Custom Fields
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: logs.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Fields")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::cfTable, Filter::$id);?>
<div class="tubi icon heading message mortar"> <i class="tasks icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_CFL_TITLE1;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=fields" class="section"><?php echo Lang::$word->_N_FIELDS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_CFL_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_CFL_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_CFL_SUBTITLE2 . $row->{'title'.Lang::$lang};?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_CFL_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_CFL_TIP;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'tooltip'.Lang::$lang};?>" name="tooltip<?php echo Lang::$lang;?>">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_CFL_SECTION;?></label>
          <select name="type">
            <?php echo Content::getFieldSection($row->type);?>
          </select>
        </div>
        <div class="field">
          <div class="two fields">
            <div class="field">
              <label><?php echo Lang::$word->_CFL_REQ;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="req" type="radio" value="1" <?php echo getChecked($row->req, 1);?>>
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="req" type="radio" value="0" <?php echo getChecked($row->req, 0);?>>
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_PUBLISHED;?></label>
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
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_CFL_UPDATE;?></button>
      <a href="index.php?do=fields" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processField" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="tubi icon heading message mortar"> <i class="tasks icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_CFL_TITLE1;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=fields" class="section"><?php echo Lang::$word->_N_FIELDS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_CFL_TITLE3;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_CFL_INFO3. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_CFL_SUBTITLE3;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_CFL_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_CFL_NAME;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_CFL_TIP;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_CFL_TIP;?>" name="tooltip<?php echo Lang::$lang;?>">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_CFL_SECTION;?></label>
          <select name="type">
            <?php echo Content::getFieldSection();?>
          </select>
        </div>
        <div class="field">
          <div class="two fields">
            <div class="field">
              <label><?php echo Lang::$word->_CFL_REQ;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="req" type="radio" value="1">
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="req" type="radio" value="0" checked="checked">
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_PUBLISHED;?></label>
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
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_CFL_ADD;?></button>
      <a href="index.php?do=fields" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processField" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $fieldrow = $content->getCustomFields();?>
<div class="tubi icon heading message mortar"> <i class="tasks icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_CFL_TITLE1;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_FIELDS;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_CFL_INFO1;?></div>
  <div class="tubi segment"> <a class="tubi icon positive button push-right" href="index.php?do=fields&amp;action=add"><i class="icon add"></i> <?php echo Lang::$word->_CFL_ADDNEW;?></a>
    <div class="tubi header"><?php echo Lang::$word->_CFL_SUBTITLE1;?></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th class="disabled"></th>
          <th class="left sortable"><?php echo Lang::$word->_CFL_NAME;?></th>
          <th class="left sortable"><?php echo Lang::$word->_CFL_SECTION;?></th>
          <th class="sortable"><?php echo Lang::$word->_CFL_POSITION;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$fieldrow):?>
        <tr>
          <td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->_CFL_NOFIELDS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($fieldrow as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="id-handle"><i class="icon reorder"></i></td>
          <td><?php echo $row->{'title' . Lang::$lang};?></td>
          <td><?php echo Content::fieldSection($row->type);?></td>
          <td><span class="tubi black label"><?php echo $row->sorting;?></span></td>
          <td><?php echo isRequired($row->req);?> <a href="index.php?do=fields&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_CFL_FIELD;?>" data-option="deleteField" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $(".tubi.table tbody").sortable({
        helper: 'clone',
        handle: '.id-handle',
        placeholder: 'placeholder',
        opacity: .6,
        update: function (event, ui) {
            serialized = $(".tubi.table tbody").sortable('serialize');
            $.ajax({
                type: "POST",
                url: "controller.php?sortfields",
                data: serialized,
                success: function (msg) {}
            });
        }
    });
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>