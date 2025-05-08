<?php
  /**
   * Languages
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: language.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Language")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::lgTable, Filter::$id);?>
<div class="tubi icon heading message mortar"> <i class="chat icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_LA_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=language" class="section"><?php echo Lang::$word->_N_LANGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_LA_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_LA_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_LA_SUBTITLE1 . $row->name;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_LA_TTITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->name;?>" name="name">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_LA_COUNTRY_ABB;?></label>
          <label class="input">
            <input name="flag" type="text" disabled="disabled" value="<?php echo $row->flag;?>" readonly>
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_LA_LANGDIR;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="langdir" type="radio" value="ltr" <?php echo getChecked($row->langdir, "ltr");?>>
              <i></i><?php echo Lang::$word->_LA_LTR;?></label>
            <label class="radio">
              <input name="langdir" type="radio" value="rtl" <?php echo getChecked($row->langdir, "rtl");?>>
              <i></i><?php echo Lang::$word->_LA_RTL;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_LA_AUTHOR;?></label>
          <label class="input">
            <input name="author" type="text" value="<?php echo $row->author;?>">
          </label>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_LA_UPDATE;?></button>
      <a href="index.php?do=language" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="updateLanguage" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case "add": ?>
<div class="tubi icon heading message mortar"><a class="helper tubi top right info corner label" data-help="language"><i class="icon help"></i></a> <i class="chat icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_LA_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=language" class="section"><?php echo Lang::$word->_N_LANGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_LA_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_LA_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_LA_SUBTITLE2;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_LA_TTITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_LA_TTITLE;?>" name="name">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_LA_COUNTRY_ABB;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input name="flag" type="text" placeholder="<?php echo Lang::$word->_LA_COUNTRY_ABB;?>">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_LA_LANGDIR;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="langdir" type="radio" value="ltr" checked="checked">
              <i></i><?php echo Lang::$word->_LA_LTR;?></label>
            <label class="radio">
              <input name="langdir" type="radio" value="rtl">
              <i></i><?php echo Lang::$word->_LA_RTL;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_LA_AUTHOR;?></label>
          <label class="input">
            <input name="author" type="text" placeholder="<?php echo Lang::$word->_LA_AUTHOR;?>">
          </label>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_LA_ADD;?></button>
      <a href="index.php?do=language" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="addLanguage" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case "phrase":?>
<div class="tubi icon heading message mortar"> <i class="chat icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_LA_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=language" class="section"><?php echo Lang::$word->_N_LANGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_LA_TITLE4;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_LA_INFO4;?></div>
  <div class="tubi form stacked segment">
    <div class="tubi header"><?php echo Lang::$word->_LA_SUBTITLE4;?> / <span id="langname"><?php echo Lang::$word->_LA_MAIN;?></span></div>
    <div class="tubi double fitted divider"></div>
    <div class="two fields">
      <div class="field">
        <div class="tubi icon input">
          <input id="filter" type="text" placeholder="<?php echo Lang::$word->_SEARCH;?>">
          <i class="search icon"></i> </div>
      </div>
      <div class="field"><?php echo Lang::langSwitch()?> </div>
    </div>
  </div>
  <div id="mainsegment" class="tubi form segment">
    <div class="tubi-grid">
      <div id="langphrases" class="two columns small-gutters">
        <?php $xmlel = simplexml_load_file(BASEPATH . Lang::langdir . Core::$language . "/lang.xml"); $data = new stdClass();?>
        <?php $i = 1;?>
        <?php  foreach ($xmlel as $pkey) :?>
        <div class="row">
          <div contenteditable="true" data-path="lang" data-edit-type="language" data-id="<?php echo $i++;?>" data-key="<?php echo $pkey['data'];?>" class="tubi phrase"><?php echo $pkey;?></div>
        </div>
        <?php endforeach;?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    /* == Filter == */
    $("#filter").on("keyup", function () {
        var filter = $(this).val(),
            count = 0;
        $("div[contenteditable=true]").each(function () {
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).parent().fadeOut();
            } else {
                $(this).parent().show();
                count++;
            }
        });
    });

    /* == Group Filter == */
    $('#langchange').change(function () {
        var sel = $(this).val();
		var type = $("#langchange option:selected").data('type');
        $("#mainsegment").addClass('loading');
        $.ajax({
            type: "POST",
            url: "controller.php",
            dataType: 'json',
            data: {
                'loadLanguage': 1,
                'filename': type,
				'type': sel
            },
            beforeSend: function () {},
            success: function (json) {
                if (json.status == "success") {
                    $("#langphrases").html(json.message).fadeIn("slow");
					$("#langname").html(sel);
                } else {
                    $.sticky(decodeURIComponent(json.message), {
                        type: "error",
                        title: json.title
                    });
                }
				$("#mainsegment").removeClass('loading');
            }
        })
    });
});
// ]]>
</script>
<?php break;?>
<?php default: ?>
<div class="tubi icon heading message mortar"> <i class="chat icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_LA_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_LANGS;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_LA_INFO3;?></div>
  <div class="tubi segment"> <a class="tubi icon positive button push-right" href="index.php?do=language&amp;action=add"><i class="icon add"></i> <?php echo Lang::$word->_LA_ADD_NEW;?></a>
    <div class="tubi header"><?php echo Lang::$word->_LA_SUBTITLE3;?></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_LA_TTITLE;?></th>
          <th data-sort="string"><?php echo Lang::$word->_LA_AUTHOR;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($langlist as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->name;?></td>
          <td><?php echo $row->author;?></td>
          <td><a href="index.php?do=language&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> <a href="index.php?do=language&amp;action=phrase&amp;id=<?php echo $row->id;?>"><i class="rounded inverted info icon chat link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_LANGUAGE;?>" data-option="deleteLanguage" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->name;?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
      </tbody>
    </table>
  </div>
</div>
<?php break;?>
<?php endswitch;?>