<?php
  /**
   * Account Page
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: account.tpl.php, 2014-01-20 16:17:34 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $artrow = Registry::get("Blog")->getUserArticles();?>

<div class="tubi secondary segment">
  <div class="clearfix"> <a onclick="$('#articleForm').slideToggle();" class="tubi icon positive button push-right"><i class="icon add"></i> <?php echo Lang::$word->_MOD_AM_SUBTITLE4;?></a>
    <h3 class="push-left"><?php echo Lang::$word->_MOD_AM_SUBTITLE10;?></h3>
  </div>
  <div class="tubi small space divider"></div>
  <p><i class="information icon"></i> <?php echo Lang::$word->_MOD_AM_INFO9;?></p>
  <div class="tubi divider"></div>
  <div id="articleForm" class="tubi form" style="display:none">
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_AM_NAME;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_SLUG;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_AM_SLUG;?>" name="slug">
          </label>
          <p class="tubi note info"><?php echo Lang::$word->_MOD_AM_SLUG_T;?></p>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_CATEGORY;?></label>
          <div class="scrollbox padded">
            <?php Registry::get("Blog")->getCatCheckList(0, 0,"|&nbsp;&nbsp;&nbsp;&nbsp;");?>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_IMAGE;?></label>
          <label class="input">
            <input type="file" name="thumb" class="filefield">
          </label>
          <p class="tubi note info"><?php echo Lang::$word->_MOD_AM_IMAGE_T;?></p>
          <div class="small-top-space">
            <label><?php echo Lang::$word->_MOD_AM_FILE_ATT;?></label>
            <label class="input">
              <input type="file" name="filename" class="filefield">
            </label>
          </div>
          <p class="tubi note info"><?php echo Lang::$word->_MOD_AM_FILE_ATT_T;?></p>
        </div>
      </div>
      <div class="tubi fitted divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_AM_TAGS;?></label>
        <label class="input"><i class="icon-append icon asterisk"></i> <i class="icon-prepend icon tags"></i>
          <input name="tags" type="text" placeholder="<?php echo Lang::$word->_MOD_AM_TAGS;?>">
        </label>
        <p class="tubi note info"><?php echo Lang::$word->_MOD_AM_TAGS_T;?></p>
      </div>
      <div class="tubi fitted divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_AM_LAYOUT;?></label>
        <div class="inline-group">
          <label class="radio">
            <input name="layout" type="radio" value="1" checked="checked">
            <i></i><img src="<?php echo ADMINURL;?>/modules/blog/images/layout-left.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT1;?>"></label>
          <label class="radio">
            <input name="layout" type="radio" value="2">
            <i></i><img src="<?php echo ADMINURL;?>/modules/blog/images/layout-right.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT2;?>"></label>
          <label class="radio">
            <input name="layout" type="radio" value="3">
            <i></i><img src="<?php echo ADMINURL;?>/modules/blog/images/layout-full-top.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT3;?>"></label>
          <label class="radio">
            <input name="layout" type="radio" value="4">
            <i></i><img src="<?php echo ADMINURL;?>/modules/blog/images/layout-full-bottom.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT4;?>"></label>
        </div>
      </div>
      <div class="tubi fitted divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_AM_FULLDESC;?></label>
        <textarea id="plugpost" class="plugpost" placeholder="<?php echo Lang::$word->_MOD_AM_FULLDESC;?>" name="body<?php echo LANG::$lang;?>"></textarea>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_METAKEYS;?></label>
          <textarea placeholder="<?php echo Lang::$word->_METAKEYS;?>" name="metakey<?php echo Lang::$lang;?>"></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_METADESC;?></label>
          <textarea placeholder="<?php echo Lang::$word->_METADESC;?>" name="metadesc<?php echo Lang::$lang;?>"></textarea>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button data-url="/modules/blog/controller.php" type="button" name="doartsubmit" class="tubi positive button"><i class="icon add"></i> <?php echo Lang::$word->_MOD_AM_SUBTITLE4;?></button>
      <input name="processArticle" type="hidden" value="1">
    </form>
    <div class="tubi small space divider"></div>
    <div id="altmsg"></div>
  </div>
  <table class="tubi sortable table">
    <thead>
      <tr>
        <th class="disabled"><i class="icon photo"></i></th>
        <th data-sort="string"><?php echo Lang::$word->_MOD_AM_NAME;?></th>
        <th data-sort="string"><?php echo Lang::$word->_MOD_AM_CATEGORY;?></th>
        <th data-sort="int"><?php echo Lang::$word->_CREATED;?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!$artrow):?>
      <tr>
        <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_AM_NOARTICLES);?></td>
      </tr>
      <?php else:?>
      <?php foreach ($artrow as $arow):?>
      <tr>
        <td><a class="lightbox" href="<?php echo SITEURL . '/' . Blog::imagepath . $arow->thumb;?>" title="<?php echo $arow->{'title'.Lang::$lang};?>"> <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/' . Blog::imagepath . $arow->thumb;?>&amp;w=120&amp;h=60" alt="" class="tubi image"></a></td>
        <td><?php echo $arow->{'title' . Lang::$lang};?></td>
        <td><a href="<?php echo Url::Blog("blog-cat", $arow->catslug);?>"><?php echo $arow->catname;?></a></td>
        <td data-sort-value="<?php echo strtotime($arow->created);?>"><?php echo Filter::dodate("long_date", $arow->created);?></td>
      </tr>
      <?php endforeach;?>
      <?php unset($arow);?>
      <?php endif;?>
    </tbody>
  </table>
</div>
<script type="text/javascript" src="<?php echo ADMINURL;?>/assets/js/editor.js"></script> 
<script src="<?php echo ADMINURL;?>/assets/js/fullscreen.js"></script> 
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $(".scrollbox").enscroll({
        showOnHover: true,
        addPaddingToPane: false,
        verticalTrackClass: 'scrolltrack',
        verticalHandleClass: 'scrollhandle'
    });
	$('.plugpost').redactor({
		observeLinks: true,
		toolbarFixed: true,
		minHeight: 200,
		maxHeight: 500,
		buttons: ['formatting', 'bold', 'italic', 'unorderedlist', 'orderedlist', 'outdent', 'indent'],
		plugins: ['fullscreen']
	});
	$('body').on('click', 'button[name=doartsubmit]', function () {
	   posturl = $(this).data('url')
	
		function showResponse(json) {
			if (json.status == "success") {
				$("#articleForm").removeClass("loading").slideUp();
				$("#altmsg").html(json.message);
			} else {
				$("#articleForm").removeClass("loading");
				$("#altmsg").html(json.message);
			}
		}
	
		function showLoader() {
			$("#articleForm").addClass("loading");
		}
		var options = {
			target: "#altmsg",
			beforeSubmit: showLoader,
			success: showResponse,
			type: "post",
			url: SITEURL + posturl,
			dataType: 'json'
		};
	
		$('#articleForm form').ajaxForm(options).submit();
	});
});
// ]]>
</script>