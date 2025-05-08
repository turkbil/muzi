<?php
  /**
   * Layout
   *
   * @yazilim Turk Bilisim
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: layout.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Bu alana giris yetkiniz bulunmuyor.');
	  
  if(!$user->getAcl("Layout")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php
  if (isset($_GET['modid']) and intval($_GET['modid'])) {
      if ($mod = getValuesById("id, modalias, title" . Lang::$lang, Content::mdTable, intval($_GET['modid']))) {
          $modid = $mod->id;
          $modslug = $mod->modalias;
          $title = $mod->{'title' . Lang::$lang};
		  $type = "mod_id";
          $pageid = 0;
          $pageslug = false;
		  $id = $mod->id;
  	  	  @$pos = sanitize($_POST['position']);
    } else {
          redirect_to("index.php?do=layout");
      }
  } else {
      if (isset($_GET['pageid']) and intval($_GET['pageid'])) {
          $pageid = intval($_GET['pageid']);
          if ($page = getValuesById("id, slug, title" . Lang::$lang, Content::pTable, intval($_GET['pageid']))) {
              $pageid = $page->id;
              $pageslug = $page->slug;
              $title = $page->{'title' . Lang::$lang};
			  $type = "page_id";
			  $id = $page->id;
 			  @$pos = sanitize($_POST['position']);
         } else {
              redirect_to("index.php?do=layout");
          }
      } else {
          $home = getValues("id, slug, title" . Lang::$lang, Content::pTable, "home_page = 1");
          $pageid = $home->id;
          $pageslug = $home->slug;
          $title = $home->{'title' . Lang::$lang};
		  $type = "page_id";
		  $id = $home->id;
 		  @$pos = sanitize($_POST['position']);
     }
      $modid = 0;
      $modslug = false;
  }

  $layrow = $content->getLayoutOptions($pageid, $modid);
  $pagerow = $content->getPages();
  $pagemainrow = $content->getPagesMain();
  $modlist = $content->displayMenuModule();
?>

<div id="layout" class="tubi-large-content" style="margin-top: -10px; padding-bottom: 0;">
  <div class="tubi segment">
    <div class="tubi small basic form segment">
      <div class="three fields">
        <div class="field">
          <div class="tubi header"><?php echo $title;?> <?php echo Lang::$word->_LY_VIEW_FOR;?></div>
        </div>
        <div class="field">
          <select name="page_id" id="page_id" onchange="if(this.value!='0') window.location = 'index.php?do=layout&amp;pageid='+this[this.selectedIndex].value; else window.location = 'index.php?do=layout';">
            <option value="0"><?php echo Lang::$word->_LY_SEL_PAGE;?></option>
            <?php if($pagerow):?>
            <?php foreach ($pagerow as $prow):?>
            <?php $sel = ($pageid == $prow->id) ? ' selected="selected"' : '' ;?>
            <option value="<?php echo $prow->id;?>"<?php echo $sel;?>><?php echo $prow->{'title'.Lang::$lang};?></option>
            <?php endforeach;?>
            <?php if($pagemainrow):?>
            <option value="0"><?php echo Lang::$word->_LY_SEL_PAGEMAIN;?></option>
            <?php foreach ($pagemainrow as $pmrow):?>
            <?php $sel = ($pageid == $pmrow->id) ? ' selected="selected"' : '' ;?>
            <option value="<?php echo $pmrow->id;?>"<?php echo $sel;?>><?php echo $pmrow->{'title'.Lang::$lang};?></option>
            <?php endforeach;?>
            <?php endif;?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <?php if($modlist) :?>
          <select name="modid" id="mod_id" onchange="if(this.value!='0') window.location = 'index.php?do=layout&amp;modid='+this[this.selectedIndex].value; else window.location = 'index.php?do=layout';">
            <option value="0"><?php echo Lang::$word->_LY_SEL_MODULE;?></option>
            <?php foreach ($modlist as $mrow):?>
            <?php $sel = ($modid == $mrow->id) ? ' selected="selected"' : '' ;?>
            <option value="<?php echo $mrow->id;?>"<?php echo $sel;?>><?php echo $mrow->{'title'.Lang::$lang};?></option>
            <?php endforeach;?>
          </select>
          <?php endif;?>
        </div>
      </div>
    </div>
    <div class="tubi double fitted divider"></div>
    <div class="tubi-grid">
      <div id="top-position" class="bottom-space">
        <div class="tubi warning segment plholder"> <span class="tubi top right attached label"><?php echo Lang::$word->_LY_TOP;?></span>
          <ul data-position="top" id="top-<?php echo ($modid) ? $modid : $pageid;?>" class="tubi sortable sortable-small top-position">
            <?php if($layrow): ?>
            <?php foreach ($layrow as $trow): ?>
            <?php if ($trow->place == "top"): ?>
            <li id="list-<?php echo $trow->plid;?>" data-type="<?php echo $type;?>" data-typeid="<?php echo $id;?>" data-id="<?php echo $trow->plid;?>" data-space="<?php echo $trow->space;?>"><?php echo $trow->{'title'.Lang::$lang};?>
              <div class="act-holder push-right">
                <div class="tubi right basic pointing dropdown icon"> <i class="settings icon"></i>
                  <div class="menu"><?php if ($trow->system == "1" && $trow->hasconfig == "1" ): ?><a href="index.php?do=plugins&action=config&plugname=<?php echo $trow->plugalias;?>" target="_blank"> <i class="setting icon mr10" data-content="Eklenti Ayarları"></i></a><?php endif;?> <?php if ($trow->system == "0"): ?><a href="index.php?do=plugins&action=edit&id=<?php echo $trow->plid;?>" target="_blank"> <i class="edit icon mr10" data-content="İçeriği Düzenle"></i></a><?php endif;?>  <a class="item setspace"><i class="edit icon"></i><?php echo Lang::$word->_EDIT;?></a> <a class="item remove"><i class="delete icon"></i><?php echo Lang::$word->_REMOVE;?></a> </div>
                </div>
              </div>
            </li>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php unset($trow);?>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <div class="columns horizontal-gutters">
        <div class="screen-30 tablet-30 phone-100" style="margin-bottom: 20px;">
          <div class="tubi teal segment plholder"> <span class="tubi top right attached label"><?php echo Lang::$word->_LY_LEFT;?></span>
            <ul data-position="left" id="left-<?php echo $id;?>" class="tubi sortable left-position">
              <?php if($layrow): ?>
              <?php foreach ($layrow as $lrow): ?>
              <?php if ($lrow->place == "left"): ?>
              <li id="list-<?php echo $lrow->plid;?>" data-type="<?php echo $type;?>" data-typeid="<?php echo $id;?>" data-id="<?php echo $lrow->plid;?>"><?php echo $lrow->{'title'.Lang::$lang};?>
                <div class="act-holder push-right"> <?php if ($lrow->system == "1" && $lrow->hasconfig == "1" ): ?><a href="index.php?do=plugins&action=config&plugname=<?php echo $lrow->plugalias;?>" target="_blank"> <i class="setting icon mr10" data-content="Eklenti Ayarları"></i></a><?php endif;?> <?php if ($lrow->system == "0"): ?><a href="index.php?do=plugins&action=edit&id=<?php echo $lrow->plid;?>" target="_blank"> <i class="edit icon mr10" data-content="İçeriği Düzenle"></i></a><?php endif;?> <a class="remove"> <i class="danger trash icon" data-content="Kaldır"></i></a></div>
              </li>
              <?php endif; ?>
              <?php endforeach; ?>
              <?php unset($lrow);?>
              <?php endif;?>
            </ul>
          </div>
        </div>
        <div class="screen-40 tablet-40 phone-100">
          <div class="tubi purple segment plholder" style="margin-bottom: 20px;"> <span class="tubi top right attached label"><?php echo Lang::$word->_LY_MAIN;?> / Orta Bölüm</span>
            <ul data-position="cenbot" id="cenbot-<?php echo $id;?>" class="tubi sortable cenbot-position">
              <?php if($layrow): ?>
              <?php foreach ($layrow as $crow): ?>
              <?php if ($crow->place == "cenbot"): ?>
              <li id="list-<?php echo $crow->plid;?>" data-type="<?php echo $type;?>" data-typeid="<?php echo $id?>" data-id="<?php echo $crow->plid;?>"><?php echo $crow->{'title'.Lang::$lang};?>
                <div class="act-holder push-right"> <?php if ($crow->system == "1" && $crow->hasconfig == "1" ): ?><a href="index.php?do=plugins&action=config&plugname=<?php echo $crow->plugalias;?>" target="_blank"> <i class="setting icon mr10" data-content="Eklenti Ayarları"></i></a><?php endif;?> <?php if ($crow->system == "0"): ?><a href="index.php?do=plugins&action=edit&id=<?php echo $crow->plid;?>" target="_blank"> <i class="edit icon mr10" data-content="İçeriği Düzenle"></i></a><?php endif;?> <a class="remove"> <i class="danger trash icon" data-content="Kaldır"></i></a></div>
              </li>
              <?php endif; ?>
              <?php endforeach; ?>
              <?php unset($crow);?>
              <?php endif;?>
            </ul>
          </div>
        </div>
        <div class="screen-30 tablet-30 phone-100">
          <div class="tubi positive segment plholder"> <span class="tubi top right attached label"><?php echo Lang::$word->_LY_RIGHT;?></span>
            <ul data-position="right" id="right-<?php echo $id;?>" class="tubi sortable right-position">
              <?php if($layrow): ?>
              <?php foreach ($layrow as $rrow): ?>
              <?php if ($rrow->place == "right"): ?>
              <li id="list-<?php echo $rrow->plid;?>" data-type="<?php echo $type;?>" data-typeid="<?php echo $id?>" data-id="<?php echo $rrow->plid;?>"><?php echo $rrow->{'title'.Lang::$lang};?>
                <div class="act-holder push-right"> <?php if ($rrow->system == "1" && $rrow->hasconfig == "1" ): ?><a href="index.php?do=plugins&action=config&plugname=<?php echo $rrow->plugalias;?>" target="_blank"> <i class="setting icon mr10" data-content="Eklenti Ayarları"></i></a><?php endif;?> <?php if ($rrow->system == "0"): ?><a href="index.php?do=plugins&action=edit&id=<?php echo $rrow->plid;?>" target="_blank"> <i class="edit icon mr10" data-content="İçeriği Düzenle"></i></a><?php endif;?> <a class="remove"> <i class="danger trash icon" data-content="Kaldır"></i></a></div>
              </li>
              <?php endif; ?>
              <?php endforeach; ?>
              <?php unset($rrow);?>
              <?php endif;?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div id="bottom-position" class="top-space">
      <div class="tubi warning segment plholder"> <span class="tubi top right attached label"><?php echo Lang::$word->_LY_BOTTOM;?></span>
        <ul data-position="bottom" id="bottom-<?php echo $id;?>" class="tubi sortable sortable-small bottom-position">
          <?php if($layrow): ?>
          <?php foreach ($layrow as $brow): ?>
          <?php if ($brow->place == "bottom"): ?>
          <li id="list-<?php echo $brow->plid;?>" data-type="<?php echo $type;?>" data-typeid="<?php echo $id;?>" data-id="<?php echo $brow->plid;?>" data-space="<?php echo $brow->space;?>"><?php echo $brow->{'title'.Lang::$lang};?>
            <div class="act-holder push-right">
              <div class="tubi right basic pointing dropdown icon"> <i class="settings icon"></i>
                <div class="menu"><?php if ($brow->system == "1" && $brow->hasconfig == "1" ): ?><a href="index.php?do=plugins&action=config&plugname=<?php echo $brow->plugalias;?>" target="_blank"> <i class="setting icon mr10" data-content="Eklenti Ayarları"></i></a><?php endif;?> <?php if ($brow->system == "0"): ?><a href="index.php?do=plugins&action=edit&id=<?php echo $brow->plid;?>" target="_blank"> <i class="edit icon mr10" data-content="İçeriği Düzenle"></i></a><?php endif;?> <a class="item setspace"><i class="edit icon"></i><?php echo Lang::$word->_EDIT;?></a> <a class="item remove"><i class="delete icon"></i><?php echo Lang::$word->_REMOVE;?></a> </div>
              </div>
            </div>
          </li>
          <?php endif; ?>
          <?php endforeach; ?>
          <?php unset($brow);?>
          <?php endif;?>
        </ul>
      </div>
      <div class="tubi-grid hide-phone">
        <div class="column-group gutters">
          <ul data-position="no-position" id="default-<?php echo $id;?>" class="tubi sortable sortable-no sortable-small bottom-position alttaraf">
            <?php 
    $pluginrow = $content->getAvailablePlugins($pageid, $modid);
      if (!$pluginrow):
          print Filter::msgSingleInfo(Lang::$word->_LY_NOMODS);
      else:
          foreach ($pluginrow as $mrow):
		  print '<li id="list-' . $mrow->id . '"  data-id="' . $mrow->id . '">' . $mrow->{'title' . Lang::$lang} . '</li>';
          endforeach;
      endif;
?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $slug = ($modid) ? 'modslug='.$modslug : 'pageslug='.$pageslug;?>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $(".bottom-position, .top-position").on("sortreceive", function (event, ui) {
        $('div.act-holder', ui.item).html('<div class="tubi right basic pointing dropdown icon"> <i class="settings icon"></i><div class="menu"><a class="item setspace"><i class="edit icon"></i><?php echo Lang::$word->_EDIT;?></a><a class="item remove"><i class="delete icon"></i><?php echo Lang::$word->_REMOVE;?></a></div></div>');
        $('.tubi.dropdown').dropdown();
    });
    $(".left-position, .right-position, .cenbot-position").on("sortreceive", function (event, ui) {
        $('div.act-holder', ui.item).html('<a class="remove"><i class="danger trash icon"></i></a>');
    });

    $("#bottom-<?php echo $id;?>,#left-<?php echo $id;?>,#right-<?php echo $id;?>,#top-<?php echo $id;?>,#cenbot-<?php echo $id;?>").sortable({
        connectWith: '.tubi.sortable',
        placeholder: 'placeholder',
        tolerance: "pointer",
        cursorAt: {
            top: 0,
            left: 0
        },
        start: function (event, ui) {
            $(ui.item).width($('#left-<?php echo $id;?>').width());
        },
        update: savePosition
    });
	
    $("#default-<?php echo $id;?>").sortable({
        connectWith: '.tubi.sortable',
        placeholder: 'placeholder',
        tolerance: "pointer",
        cursorAt: {
            top: 0,
            left: 0
        },
        start: function (event, ui) {
            $(ui.item).width($('#default-<?php echo $id;?>').width());
        },
   });

    $('#layout').on('doubletap', '.plholder', function () {
        var $this = $(this).children('ul');
        var pos = $($this).data('position')
        Messi.load('controller.php', {
            loadAvailPlugs: 1,
            position: pos,
            page_id: <?php echo $pageid;?> ,
            mod_id: <?php echo $modid;?>
        }, {
            title: '<?php echo Lang::$word->_LY_SELECT;?>'
        });
         
    });
			  
    $('body').on('click', '#plavailable a.list', function () {
        var pos = $(this).data('position');
        var id = $(this).data('id');
        var name = $(this).text();

        if (pos == "top" || pos == "bottom") {
            var $list = ('<li id="list-' + id + '" data-type="<?php echo $type;?>" data-typeid="<?php echo $id?>" data-id="' + id + '" data-space="10">' + name + '<div class="act-holder push-right"><div class="tubi right basic pointing dropdown icon"> <i class="settings icon"></i><div class="menu"><a class="item setspace"><i class="edit icon"></i><?php echo Lang::$word->_EDIT;?></a><a class="item remove"><i class="delete icon"></i><?php echo Lang::$word->_REMOVE;?></a></div></div></div></li>');
            $('.tubi.dropdown').dropdown();
        } else {
            var $list = ('<li id="list-' + id + '" data-type="<?php echo $type;?>" data-id="' + id + '">' + name + '<div class="act-holder push-right"><a class="remove"> <i class="danger trash icon"></i></a></div></li>');
        }
		
		$("ul[data-position='" + pos + "']").prepend($list);
		$(this).parent().remove()
		
        var place = "";
        var count = 0;
        $("ul[data-position='" + pos + "'] [id^=list-]").each(function () {
            count++;
            place += (this.parentNode.id + "[]" + "=" + count + "|" + this.id + "&");
        });
        $.ajax({
            type: "post",
            url: "controller.php?<?php echo $slug;?>&layout=" + pos + '-' + <?php echo $id;?>,
            data: place
        });
		
		$('.tubi.dropdown').dropdown();
    });

    $('body').on('click', 'a.remove', function () {
        var $li = $(this).closest('li');
        var type = $($li).data("type");
        var type_id = $($li).data("typeid");
        var id = $($li).data("id");
		
        $li.slideUp(500, function () {
            $li.remove();
            $.ajax({
                type: "post",
                url: "controller.php",
                data: {
                    removeLayoutPlugin: 1,
					id: id,
					type: type,
					type_id: type_id,
                },
                success: function (msg) {}
            });

        });
    });
	
    $('#layout').on('click', 'a.setspace', function () {
        var $li = $(this).closest('li');
        var curspace = $($li).data("space");
        var type = $($li).data("type");
        var type_id = $($li).data("typeid");
        var id = $($li).data("id");
		
        var text = '<div class="spacegrid">';
        for (var i = 1; i <= 10; i++) {
            var cls = (curspace == i) ? "active" : null;
            text += '<span class="spacelist ' + cls + '">' + i + '</span>';
        }
        text += '</div>';

        new Messi(text, {
            title: '<?php echo Lang::$word->_LY_SPTITLE;?>',
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: '<?php echo Lang::$word->_SUBMIT;?>',
                class: 'positive',
                val: 'Y'
            }],
            callback: function (val) {
                newcol = $('.spacelist.active').text();
                $.ajax({
                    type: 'post',
                    url: "controller.php",
                    data: {
                        setPluginCols: 1,
                        id: id,
                        type: type,
                        type_id: type_id,
                        cols: newcol
                    },
                    beforeSend: function () {},
                    success: function (msg) {
                        $($li).data("space", msg);
                    }

                });
            }
        });
    });

    /* == Toggle Space Columns == */
    $('body').on('click', 'span.spacelist', function () {
        $('body span.spacelist.active').not(this).removeClass('active');
        $(this).toggleClass("active");
    });
});

function savePosition() {
    var place = "";
    var count = 0;
    $("[id^=list-]").each(function () {
        count++;
        place += (this.parentNode.id + "[]" + "=" + count + "|" + this.id + "&");
    });
    $.ajax({
        type: "post",
        url: "controller.php?<?php echo $slug;?>&layout=" + this.id,
        data: place
    });
}
// ]]>
</script> 
<!-- End Footer--> 
<script src="assets/js/jquery.iframe-transport.js"></script> 
<script src="assets/js/jquery.fileupload.js"></script> 
<script src="assets/js/fullscreen.js"></script>
<?php if (Filter::$do && is_file('assets/js/' . Filter::$do.".js")):?>
<script type="text/javascript" src="assets/js/<?php echo Filter::$do;?>.js"></script>
<?php endif;?>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $.Master({
		weekstart: <?php echo ($core->weekstart - 1);?>,
		contentPlugins: {<?php echo Content::getEditorPlugins();?>},
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
</body></html><?php exit(); ?>