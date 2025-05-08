<?php
  /**
   * Maintenance
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: maintenance.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Maintenance")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<div class="tubi icon heading message mortar"> <i class="wrench icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_SM_TITLE1;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_SMTCN;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_SM_INFO1;?></div>
  <div id="msgholder"></div>
  <form id="tubi_form" name="tubi_form" method="post">
    <div class="tubi form stacked segment">
      <div class="tubi header"><?php echo Lang::$word->_SM_SUBTITLE1;?></div>
      <div class="tubi fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_SM_DAYS;?></label>
          <select name="days">
            <option value="3">3</option>
            <option value="7">7</option>
            <option value="14">14</option>
            <option value="30">30</option>
            <option value="60">60</option>
            <option value="100">100</option>
            <option value="180">180</option>
            <option value="365">365</option>
          </select>
          <p class="tubi note"><?php echo Lang::$word->_SM_SUBTITLE1_T;?></p>
        </div>
      </div>
      <button type="button" data-type="inactive" name="inactive" class="tubi negative button"><?php echo Lang::$word->_SM_DELINACTIVE;?></button>
    </div>
    <div class="tubi form stacked segment">
      <div class="tubi header"><?php echo Lang::$word->_SM_SUBTITLE2;?></div>
      <div class="tubi fitted divider"></div>
      <div class="field"> <?php echo str_replace("[NUMBER]", countEntries("users","active","t"), Lang::$word->_SM_SUBTITLE2_T);?> </div>
      <button type="button" data-type="pending" name="pending" class="tubi negative button"><?php echo Lang::$word->_SM_DELPENDING;?></button>
    </div>
    <div class="tubi form stacked segment">
      <div class="tubi header"><?php echo Lang::$word->_SM_SUBTITLE3;?></div>
      <div class="tubi fitted divider"></div>
      <div class="field"> <?php echo str_replace("[NUMBER]", countEntries("users","active","b"), Lang::$word->_SM_SUBTITLE3_T);?> </div>
      <button type="button" data-type="banned" name="banned" class="tubi negative button"><?php echo Lang::$word->_SM_DELBANNED;?></button>
    </div>
    <div class="tubi form stacked segment">
      <div class="tubi header"><?php echo Lang::$word->_SM_SUBTITLE4;?></div>
      <div class="tubi fitted divider"></div>
      <div class="field"> <?php echo str_replace("[NUMBER]", countEntries("users","active","b"), Lang::$word->_SM_SUBTITLE4_T);?> </div>
      <?php if($core->checkTable("mod_blog")):?>
      <div class="field">
        <div class="inline-group">
          <label class="checkbox">
            <input name="am" type="checkbox" checked="checked" value="1">
            <i></i><?php echo Lang::$word->_SM_DOAM;?></label>
        </div>
      </div>
      <?php endif;?>
      <?php if($core->checkTable("mod_digishop")):?>
      <div class="field">
        <div class="inline-group">
          <label class="checkbox">
            <input name="ds" type="checkbox" checked="checked" value="1">
            <i></i><?php echo Lang::$word->_SM_DODS;?></label>
        </div>
      </div>
      <?php endif;?>
      <?php if($core->checkTable("mod_portfolio")):?>
      <div class="field">
        <div class="inline-group">
          <label class="checkbox">
            <input name="pf" type="checkbox" value="1" checked="checked">
            <i></i><?php echo Lang::$word->_SM_DOPF;?></label>
        </div>
      </div>
      <?php endif;?>
      <?php if($core->checkTable("mod_psdrive")):?>
      <div class="field">
        <div class="inline-group">
          <label class="checkbox">
            <input name="pd" type="checkbox" value="1" checked="checked">
            <i></i><?php echo Lang::$word->_SM_DOPD;?></label>
        </div>
      </div>
      <?php endif;?>
      <button type="button" data-type="sitemap" name="sitemap" class="tubi positive button"><?php echo Lang::$word->_SM_CREATESM;?></button>
    </div>
    <input name="processMaintenance" type="hidden" value="1">
  </form>
</div>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    /* == Master Form == */
    $('body').on('click', 'button', function () {
        function showResponse(json) {
			$('html, body').animate({
				scrollTop: 0
			}, 600);
            $("#msgholder").html(json.message);
        }

        function showLoader() {}
        var options = {
            target: "#msgholder",
            beforeSubmit: showLoader,
            success: showResponse,
            type: "post",
            url: "controller.php",
            dataType: 'json',
			data :{'do':$(this).data('type')}
        };

        $('#tubi_form').ajaxForm(options).submit();
    });
});
// ]]>
</script>