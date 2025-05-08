<?php
  /**
   * Newsletter
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: newsletter.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Newsletter")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php $row = get('emailid') ? Core::getRowById(Content::eTable, 12) : Core::getRowById(Content::eTable, 4);?>
<?php $tplrow = $member->getNewsletterTemplates()?>
<div class="tubi icon heading message mortar"> <i class="mail reply icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_NL_TITLE1;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_NEWSL;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_NL_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="push-right">
      <div class="tubi info buttons">
        <div class="tubi button"><?php echo Lang::$word->_NL_SELECT;?></div>
        <div class="tubi floating dropdown icon button"> <i class="dropdown icon"></i>
          <div class="menu">
            <?php foreach($tplrow as $trow):?>
            <div class="item" data-value="<?php echo $trow->id;?>"><?php echo $trow->{'name'.Lang::$lang};?></div>
            <?php endforeach;?>
          </div>
        </div>
      </div>
    </div>
    <div class="tubi header"><?php echo get('emailid') ? Lang::$word->_NL_SUBTITLE2 : Lang::$word->_NL_SUBTITLE1;?></div>
    <div class="tubi double fitted divider"> </div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_NL_RECIPIENTS;?></label>
          <?php if(get('emailid')):?>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo sanitize(get('emailid'));?>" name="recipient">
          </label>
          <?php else:?>
          <select name="recipient">
            <option value="all"><?php echo Lang::$word->_NL_ALL;?></option>
            <option value="free"><?php echo Lang::$word->_NL_REGED;?></option>
            <option value="paid"><?php echo Lang::$word->_NL_PAID;?></option>
            <option value="newsletter"><?php echo Lang::$word->_NL_SUBSCRIBED;?></option>
          </select>
          <?php endif;?>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_NL_SUBJECT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input id="subject" type="text" value="<?php echo $row->{'subject'.Lang::$lang};?>" name="subject<?php echo Lang::$lang;?>">
          </label>
        </div>
      </div>
      <div class="tubi divider"></div>
      <div class="field">
        <textarea id="bodypost" class="bodypost" name="body<?php echo Lang::$lang;?>"><?php echo $row->{'body'.Lang::$lang};?></textarea>
        <p class="tubi error note"><?php echo Lang::$word->_ET_VAR_T;?></p>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_NL_SEND;?></button>
      <input name="processNewsletter" type="hidden" value="1">
      <input name="tpl" type="hidden" value="<?php echo $row->id;?>">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $(".tubi.floating .menu").on('click', '.item', function () {
        id = $(this).data('value');
        $.ajax({
            type: 'post',
            url: 'controller.php',
            dataType: 'json',
            data: {
                loadEmailTemplate: 1,
                id: id
            },
            success: function (json) {
				<?php if($core->editor == 1):?>
                $('.bodypost').redactor('set', json.content);
				<?php else:?>
				tinymce.editors[0].setContent(json.content);
				<?php endif;?>
                $('#subject').val(json.subject);
                $("input[name='tpl']").val(json.id);
            }
        });
    });
});
</script>