<?php
  /**
   * Logs
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: logs.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Logs")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
?>
<?php $logdata = $tubi->getLogs();?>
<div class="tubi icon heading message mortar"> <i class="shield icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_LG_TITLE1;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_LOGS;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_LG_INFO1;?></div>
  <div class="tubi segment"> <a class="tubi icon negative button push-right delete" data-id="1" data-name="<?php echo Lang::$word->_N_LOGS;?>" data-option="deleteLogs" data-title="<?php echo Lang::$word->_LG_EMPTY_LOGS;?>"><i class="icon plus"></i> <?php echo Lang::$word->_LG_EMPTY;?></a>
    <div class="tubi header"><?php echo Lang::$word->_LG_SUBTITLE1;?></div>
    <div class="tubi fitted divider"></div>
    <div class="tubi small form basic segment">
      <form method="post" id="tubi_form" name="tubi_form">
        <div class="four fields">
          <div class="field">
            <div class="tubi input"> <i class="icon-prepend icon calendar"></i>
              <input name="fromdate" type="text" data-datepicker="true" placeholder="<?php echo Lang::$word->_UR_SHOW_FROM;?>" id="fromdate" />
            </div>
          </div>
          <div class="field">
            <div class="tubi action input"> <i class="icon-prepend icon calendar"></i>
              <input name="enddate" type="text" data-datepicker="true" placeholder="<?php echo Lang::$word->_UR_SHOW_TO;?>" id="enddate" />
              <a id="doDates" class="tubi icon button"><?php echo Lang::$word->_GO;?></a> </div>
          </div>
          <div class="field"> <?php echo $pager->items_per_page();?> </div>
          <div class="field"> <?php echo $pager->jump_menu();?> </div>
        </div>
      </form>
      <div class="tubi fitted divider"></div>
    </div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int"><?php echo Lang::$word->_LG_WHEN;?></th>
          <th data-sort="string"><?php echo Lang::$word->_LG_USER;?></th>
          <th data-sort="int"><?php echo Lang::$word->_LG_IP;?></th>
          <th data-sort="string"><?php echo Lang::$word->_LG_TYPE;?></th>
          <th data-sort="string"><?php echo Lang::$word->_LG_DATA;?></th>
          <th data-sort="string"><?php echo Lang::$word->_LG_MESSAGE;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$logdata):?>
        <tr>
          <td colspan="6"><?php echo Filter::msgSingleAlert(Lang::$word->_LG_NOLOGS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($logdata as $row):?>
        <?php $message = cleanSanitize($row->message);?>
        <tr>
          <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("long_date", $row->created);?></td>
          <td><?php echo $row->user_id;?></td>
          <td><?php echo $row->ip;?></td>
          <td><span class="tubi label <?php echo ($row->type == "system" ? "negative" : ($row->type == "user" ? "positive" : "info"));?>"><?php echo $row->type;?></span></td>
          <td><?php echo $row->info_icon;?></td>
          <td><?php echo $message;?></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
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