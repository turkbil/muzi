<?php
  /**
   * FAQ Manager
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: main.php, v4.00 2014-05-31 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  require_once(MODPATH . "faq/admin_class.php");
  Registry::set('FAQManager', new FAQManager());
  
  $faqrow = Registry::get("FAQManager")->getFaq();
?>
<!-- Start FAQ Manager -->
<div id="faq">
  <?php if($faqrow):?>
  <div class="clearfix"><a class="expand_all tubi basic button" data-hint="<?php echo Lang::$word->_MOD_FAQ_EXP;?>"><?php echo Lang::$word->_MOD_FAQ_EXP;?></a></div>
  <?php foreach ($faqrow as $fqrow):?>
  <section class="clearfix">
    <h4 class="question"><i class="icon help"></i><?php echo $fqrow->{'question' . Lang::$lang};?></h4>
    <div class="answer clearfix"><?php echo cleanOut($fqrow->{'answer' . Lang::$lang});?></div>
  </section>
  <?php endforeach;?>
  <?php unset($fqrow);?>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $('h4.question').on('click', function () {
        var parent = $(this).parent();
		var active = $(this).parent();
        var answer = parent.find('.answer');

        if (answer.is(':visible')) {
            answer.slideUp(100, function () {
                answer.slideUp();
				active.removeClass('active')
            });
        } else {
            answer.fadeIn(300, function () {
                answer.slideDown();
				active.addClass('active')
            });
        }
    });

    $("a.expand_all").on("click", function () {
        if (!$('.answer').is(':visible')) {
            $(this).text('<?php echo Lang::$word->_MOD_FAQ_COL;?>');
            $('.answer').slideDown(150);
			$('h4.question').addClass('active');
        } else {
            $(this).text('<?php echo Lang::$word->_MOD_FAQ_EXP;?>');
            $('.answer').slideUp(150);
			$('h4.question').removeClass('active');
        }
    });
});
// ]]>
</script> 
<?php endif;?>
<!-- End FAQ Manager /-->