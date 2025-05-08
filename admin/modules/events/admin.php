<?php
  /**
   * Event Manager
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: admin.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("events")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;

  Registry::set('eventManager', new eventManager());
?>
<?php switch(Filter::$maction): case "edit": ?>
<?php $row = Core::getRowById(eventManager::mTable, Filter::$id);?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="events"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_EM_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=events" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_EM_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_EM_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_EM_SUBTITLE1 . $row->{'title'.Lang::$lang};?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_TITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_VENUE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'venue'.Lang::$lang};?>" name="venue<?php echo Lang::$lang;?>">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_CONTACT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->contact_person;?>" name="contact_person">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_CONTACT_U;?></label>
          <select name="user_id">
            <?php foreach(Registry::get("eventManager")->getUserList() as $urow):?>
            <option value="<?php echo $urow->id;?>"<?php if($row->user_id == $urow->id) echo ' selected="selected"';?>><?php echo $urow->name;?></option>
            <?php endforeach;?>
            <?php unset($urow);?>
          </select>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_EMAIL;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->contact_email;?>" name="contact_email">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_PHONE;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->contact_phone;?>" name="contact_phone">
          </label>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_DATE_S;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i><i class="icon-prepend icon calendar"></i>
            <input data-datepicker="true" data-value="<?php echo $row->date_start;?>" type="text" value="<?php echo $row->date_start;?>" name="date_start">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_DATE_S;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i><i class="icon-prepend icon time"></i>
            <input data-timepicker="true" type="text" value="<?php echo $row->time_start;?>" name="time_start">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_TIME_S;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i><i class="icon-prepend icon calendar"></i>
            <input data-datepicker="true" data-value="<?php echo $row->date_end;?>" type="text" value="<?php echo $row->date_end;?>" name="date_end">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_TIME_S;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i><i class="icon-prepend icon time"></i>
            <input data-timepicker="true" type="text" value="<?php echo $row->time_end;?>" name="time_end">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_COLOUR;?></label>
          <label class="input">
            <input data-color-format="hex" type="text" value="<?php echo $row->color;?>" name="color">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_PUB;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="active" type="radio" value="1" <?php getChecked($row->active, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="active" type="radio" value="0" <?php getChecked($row->active, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="tubi fitted divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_EM_BODY;?></label>
        <textarea id="plugpost" class="plugpost" name="body<?php echo Lang::$lang;?>"><?php echo Filter::out_url($row->{'body'.Lang::$lang});?></textarea>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_EM_UPDATE;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=events" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processEvent" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $('input[name=color]').ColorPickerSliders({
        previewontriggerelement: true,
        flat: false,
        customswatches: false,
        swatches: ['#F0B174', '#79C0D8', '#3CC9CA', '#B2D280', '#FB4434', '#fff'],
        order: {
            rgb: 1,
            preview: 2
        }
    });
});
</script>
<?php break;?>
<?php case"add": ?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="events"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_EM_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=events" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_EM_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_EM_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_EM_SUBTITLE2;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_TITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_EM_TITLE;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_VENUE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_EM_VENUE;?>" name="venue<?php echo Lang::$lang;?>">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_CONTACT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_EM_CONTACT;?>" name="contact_person">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_CONTACT_U;?></label>
          <select name="user_id">
            <?php foreach(Registry::get("eventManager")->getUserList() as $urow):?>
            <option value="<?php echo $urow->id;?>"><?php echo $urow->name;?></option>
            <?php endforeach;?>
            <?php unset($urow);?>
          </select>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_EMAIL;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_EM_EMAIL;?>" name="contact_email">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_PHONE;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_EM_PHONE;?>" name="contact_phone">
          </label>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_DATE_S;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i><i class="icon-prepend icon calendar"></i>
            <input data-datepicker="true" data-value="<?php echo date('Y-m-d');?>" type="text" value="<?php echo date('Y-m-d');?>" name="date_start">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_DATE_S;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i><i class="icon-prepend icon time"></i>
            <input data-timepicker="true" type="text" name="time_start">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_TIME_S;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i><i class="icon-prepend icon calendar"></i>
            <input data-datepicker="true" type="text" name="date_end">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_TIME_S;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i><i class="icon-prepend icon time"></i>
            <input data-timepicker="true" type="text" name="time_end">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_COLOUR;?></label>
          <label class="input">
            <input data-color-format="hex" type="text" name="color">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_EM_PUB;?></label>
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
      <div class="tubi fitted divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_EM_BODY;?></label>
        <textarea id="plugpost" class="plugpost" name="body<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_EM_ADD;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=events" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processEvent" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $('input[name=color]').ColorPickerSliders({
        previewontriggerelement: true,
        flat: false,
        customswatches: false,
        swatches: ['#F0B174', '#79C0D8', '#3CC9CA', '#B2D280', '#FB4434', '#fff'],
        order: {
            rgb: 1,
            preview: 2
        }
    });
});
</script>
<?php break;?>
<?php case"view": ?>
<div class="tubi icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_EM_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=events" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_EM_TITLE4;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_EM_INFO4;?></div>
  <div class="tubi segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_EM_VIEWCAL2;?></div>
    <div class="tubi fitted divider"></div>
    <div id="calendar">
      <?php Registry::get("eventManager")->renderCalendar();?>
    </div>
  </div>
</div>
<script type="text/javascript">
// <![CDATA[
  function loadList() {
      $.ajax({
          type: "POST",
          url: "modules/events/controller.php",
          data: {
              'getcal': 1
          },
          success: function (data) {
              $("#calendar").fadeIn("fast", function () {
                  $(this).html(data);
              });
          }
      });
  }
  $(document).ready(function () {
      $("#calendar").on("click", "a.changedate", function () {
          $('.tubi.segment').addClass('loading');
          var caldata = $(this).data('id');
          var month = caldata.split(":")[0];
          var year = caldata.split(":")[1];
          $.ajax({
              type: "POST",
              url: "modules/events/controller.php",
              data: {
                  'year': year,
                  'month': month,
                  'getcal': 1
              },
              success: function (data) {
                  $("#calendar").fadeIn("slow", function () {
                      $(this).html(data);
                  });
				  $('.tubi.segment').removeClass('loading');
              }
          });
          return false;
      });
	  
      $("#calendar").on("click", "a.loadevent", function () {
          var id = $(this).data('id');
          var caption = $(this).data('title');
          Messi.load('modules/events/controller.php', {
              loadEvent: 1,
              id: id
          }, {
              title: caption
          });
      });
  });
// ]]>
</script>
<?php break;?>
<?php default: ?>
<?php $eventrow = Registry::get("eventManager")->getEvents();?>
<div class="tubi icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_EM_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_EM_INFO3;?></div>
  <div class="tubi segment">
    <div class="tubi buttons push-right"> <a href="<?php echo Core::url("modules", "view");?>" class="tubi positive button"><i class="icon add"></i><?php echo Lang::$word->_MOD_EM_VIEWCAL;?></a> <a href="<?php echo Core::url("modules", "add");?>" class="tubi info button"><i class="icon add"></i><?php echo Lang::$word->_MOD_EM_ADD;?></a> </div>
    <div class="tubi header"><?php echo Lang::$word->_MOD_EM_SUBTITLE3;?></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_EM_TITLE;?></th>
          <th data-sort="int"><?php echo Lang::$word->_MOD_EM_DSTART;?></th>
          <th data-sort="int"><?php echo Lang::$word->_MOD_EM_TSTART;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$eventrow):?>
        <tr>
          <td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_EM_NOEVENT);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($eventrow as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td data-sort-value="<?php echo strtotime($row->date_start);?>"><?php echo Filter::dodate("short_date", $row->date_start);?></td>
          <td data-sort-value="<?php echo strtotime($row->time_start);?>"><?php echo Filter::dotime($row->time_start);?></td>
          <td><a href="<?php echo Core::url("modules", "edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_EM_EVENT;?>" data-option="deleteEvent" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($slrow);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
  <div class="tubi-grid">
    <div class="two columns horizontal-gutters">
      <div class="row"> <span class="tubi label"><?php echo Lang::$word->_PAG_TOTAL.': '.$pager->items_total;?> / <?php echo Lang::$word->_PAG_CURPAGE.': '.$pager->current_page.' '.Lang::$word->_PAG_OF.' '.$pager->num_pages;?></span> </div>
      <div class="row">
        <div id="pagination"><?php echo $pager->display_pages();?></div>
      </div>
    </div>
  </div>
</div>
<?php break;?>
<?php endswitch;?>