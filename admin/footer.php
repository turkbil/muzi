<?php
  /**
   * Footer
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: footer.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<!-- Start Footer-->
<footer class="clearfix">
  <div class="tubi-content">Tubi Portal; sevgiyle tasarlandı, bilgiyle kodlandı.</div>
</footer>


<!-- End Footer-->
<script src="assets/js/jquery.iframe-transport.js"></script> 
<script src="assets/js/jquery.fileupload.js"></script> 
<?php if($core->editor == 1):?>
<script src="assets/js/fullscreen.js"></script>
<script src="assets/js/fontcolor.js"></script>
<script src="assets/js/fontsize.js"></script>
<script src="assets/js/fontfamily.js"></script>
<?php endif;?>
<?php if (Filter::$do && is_file('assets/js/' . Filter::$do.".js")):?>
<script type="text/javascript" src="assets/js/<?php echo Filter::$do;?>.js"></script>
<?php endif;?>
<?php $editorPlugins = Content::getEditorPlugins();?>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $.Master({
		weekstart: <?php echo ($core->weekstart - 1);?>,
		contentPlugins: <?php echo ($core->editor == 1) ? "{" . $editorPlugins . "}" : "[" . $editorPlugins . "]";?>,
		editor: <?php echo $core->editor;?>,
		editorCss: ["<?php echo SITEURL . '/theme/' . $core->theme . '/cache/master_main.css';?>","<?php echo SITEURL . '/theme/' . $core->theme . '/css/style.css';?>"],
        lang: {
            button_text: "<?php echo Lang::$word->_CHOOSE;?>",
            empty_text: "<?php echo Lang::$word->_NOFILE;?>",
            monthsFull: [<?php echo Core::monthList(false);?>],
            monthsShort: [<?php echo Core::monthList(false, false);?>],
			weeksFull : [<?php echo Core::weekList(false);?>],
			weeksShort : [<?php echo Core::weekList(false, false);?>],
			today : "<?php echo Lang::$word->_MN_TODAY;?>",
			clear : "<?php echo Lang::$word->_CLEAR;?>",
            delMsg1: "<?php echo Lang::$word->_DEL_CONFIRM;?>",
            delMsg2: "<?php echo Lang::$word->_DEL_CONFIRM1;?>",
            working: "<?php echo Lang::$word->_WORKING;?>"
        }
    });
});
// ]]>
</script>
</body></html>