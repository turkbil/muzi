<?php
  /**
   * Transactions
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: transactions.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Transactions")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "sales": ?>
<?php $reports = $member->yearlyStats();?>
<?php $row = $member->getYearlySummary();?>

<div class="tubi icon heading message coral"> <i class="payment icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_TR_TITLE1;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=transactions" class="section"><?php echo Lang::$word->_N_TRANS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_TR_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_TR_INFO2;?></div>
  <div class="tubi form segment">
    <div data-select-range="true" class="tubi selection dropdown push-right push-right">
      <div class="text"><?php echo Lang::$word->_MN_RANGE;?></div>
      <i class="dropdown icon"></i>
      <div class="menu">
        <div class="item" data-value="day"><?php echo Lang::$word->_MN_TODAY;?></div>
        <div class="item" data-value="week"><?php echo Lang::$word->_MN_WEEK;?></div>
        <div class="item" data-value="month"><?php echo Lang::$word->_MN_MONTH;?></div>
        <div class="item" data-value="year"><?php echo Lang::$word->_MN_YEAR;?></div>
      </div>
      <input name="range" type="hidden" value="">
    </div>
    <div class="tubi header"><?php echo Lang::$word->_TR_SALES3 . ' &rsaquo; ' . $core->year;?></div>
    <div class="tubi double fitted divider"></div>
    <?php if(!$reports):?>
    <?php echo Filter::msgAlert(Lang::$word->_TR_NOYEARSALES);?>
    <?php else:?>
    <div id="chartdata" style="height:400px;overflow:hidden"></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi table">
      <thead>
        <tr>
          <th><?php echo Lang::$word->_TR_MONTHYEAR;?></th>
          <th><?php echo Lang::$word->_TR_TOTSALES;?></th>
          <th><?php echo Lang::$word->_TR_TOTREV;?></th>
        </tr>
      </thead>
      <?php foreach($reports as $report):?>
      <tr>
        <td><?php echo date("M", mktime(0, 0, 0, $report->month, 10));?> / <?php echo $core->year;?></td>
        <td><?php echo $report->total;?></td>
        <td><?php echo $core->formatMoney($report->totalprice);?></td>
      </tr>
      <?php endforeach ?>
      <?php unset($report);?>
      <tr class="info">
        <td><?php echo Lang::$word->_TR_TOTALYEAR;?></td>
        <td><?php echo $row->total;?></strong></td>
        <td><?php echo $core->formatMoney($row->totalprice);?></td>
      </tr>
    </table>
    <?php endif;?>
  </div>
</div>
<script type="text/javascript" src="../assets/jquery.flot.js"></script> 
<script type="text/javascript" src="../assets/flot.resize.js"></script> 
<script type="text/javascript" src="../assets/excanvas.min.js"></script> 
<script type="text/javascript">
function getSalesChart(range) {
    $.ajax({
        type: 'GET',
        url: 'controller.php?getTransactionStats=1&timerange=' + range,
        dataType: 'json',
        async: false,
        success: function (json) {
            var option = {
				colors: ["#79C0D8", "#F0B174"],
                shadowSize: 0,
                lines: {
                    show: true,
                    fill: true,
                    lineWidth: 1
                },
                grid: {
                    hoverable: true,
                    clickable: true,
					backgroundColor: '#E9E9E1',
					borderColor: '#C6C6BF'
                },
                xaxis: {
                    ticks: json.xaxis,
					
                }
            }
            $.plot($('#chartdata'), [json.order, json.sum], option);
        }
    });
}
getSalesChart('year')

function showTooltip(x, y, contents) {
    $('<div class="charts_tooltip">' + contents + '</div>').css({
        position: 'absolute',
        display: 'none',
        'z-index': 5000,
        top: y + 5,
        left: x + 5
    }).appendTo("body").fadeIn(200);
}
var previousPoint = null;
$("#chartdata").on("plothover", function (event, pos, item) {
    if (item) {
        if (previousPoint != item.dataIndex) {
            previousPoint = item.dataIndex;
            $(".charts_tooltip").fadeOut("fast").promise().done(function () {
                $(this).remove();
            });
            var x = item.datapoint[0].toFixed(2),
                y = item.datapoint[1].toFixed(2);
            i = item.series.xaxis.options.ticks[item.dataIndex][1]
            showTooltip(item.pageX, item.pageY, item.series.label + " for " + i + " = " + y);
        }
    } else {
        $(".charts_tooltip").fadeOut("fast").promise().done(function () {
            $(this).remove();
        });
        previousPoint = null;
    }
});

$(document).ready(function () {
    $("[data-select-range]").on('click', '.item', function () {
        v = $("input[name=range]").val();
        getSalesChart(v)
    });
});
</script>
<?php break;?>
<?php default: ?>
<?php $payrow = $member->getPayments(); ?>
<div class="tubi icon heading message coral"> <i class="icon payment"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_TR_TITLE1;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_TRANS;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_TR_INFO1;?></div>
  <div class="tubi segment">
    <div class="tubi positive right pointing dropdown icon button push-right"> <i class="reorder icon"></i>
      <div class="menu"> <a href="controller.php?exportTransactions" class="item"><i class="table icon"></i><?php echo Lang::$word->_TR_EXPORTXLS;?></a> <a href="index.php?do=transactions&amp;action=sales" class="item"><i class="bar chart icon"></i><?php echo Lang::$word->_TR_VIEW_REPORT;?></a> </div>
    </div>
    <div class="tubi header"><?php echo Lang::$word->_TR_SUBTITLE1;?></div>
    <div class="tubi fitted divider"></div>
    <div class="tubi small form basic segment">
      <form method="post" id="tubi_form" name="tubi_form">
        <div class="four fields">
          <div class="field">
            <div class="tubi input"> <i class="icon-prepend icon calendar"></i>
              <input name="fromdate" type="text" data-datepicker="true" placeholder="<?php echo Lang::$word->_TR_SHOW_FROM;?>" id="fromdate" />
            </div>
          </div>
          <div class="field">
            <div class="tubi action input"> <i class="icon-prepend icon calendar"></i>
              <input name="enddate" type="text" data-datepicker="true" placeholder="<?php echo Lang::$word->_TR_SHOW_TO;?>" id="enddate" />
              <a id="doDates" class="tubi icon button"><?php echo Lang::$word->_SR_SEARCH_GO;?></a> </div>
          </div>
          <div class="field">
            <div class="tubi icon input">
              <input type="text" name="transsearchfield" placeholder="<?php echo Lang::$word->_TR_FINDPAY;?>" id="searchfield"  />
              <i class="search icon"></i>
              <div id="suggestions"> </div>
            </div>
          </div>
          <div class="field">
            <div class="two fields">
              <div class="field"> <?php echo $pager->items_per_page();?> </div>
              <div class="field"> <?php echo $pager->jump_menu();?> </div>
            </div>
          </div>
        </div>
      </form>
      <div class="tubi fitted divider"></div>
    </div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_TR_MEMNAME;?></th>
          <th data-sort="string"><?php echo Lang::$word->_TR_USERNAME;?></th>
          <th data-sort="string"><?php echo Lang::$word->_TR_AMOUNT;?></th>
          <th data-sort="int"><?php echo Lang::$word->_TR_PAYDATE;?></th>
          <th class="disabled"><?php echo Lang::$word->_TR_PROCESSOR;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$payrow):?>
        <tr>
          <td colspan="7"><?php echo Filter::msgSingleAlert(Lang::$word->_TR_NOTRANS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($payrow as $row):?>
        <tr>
          <td>#</td>
          <td><a href="index.php?do=memberships&amp;action=edit&amp;id=<?php echo $row->mid;?>"><?php echo $row->title;?></a></td>
          <td><a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->uid;?>"><?php echo $row->username;?></a></td>
          <td><?php echo $core->formatMoney($row->rate_amount);?></td>
          <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("short_date", $row->created);?></td>
          <td><span class="tubi positive label"><?php echo $row->pp;?></span></td>
          <td><?php echo isCompleted($row->status);?> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_TRANSACTION;?>" data-option="deleteTransaction" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->txn_id;?>"><i class="rounded danger inverted remove icon link"></i></a></td>
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
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    /* == Transaction Search == */
    $("#searchfield").on('keyup', function () {
        var srch_string = $(this).val();
        var data_string = 'transSearch=' + srch_string;
        if (srch_string.length > 3) {
            $.ajax({
                type: "post",
                url: "controller.php",
                data: data_string,
                beforeSend: function () {},
                success: function (res) {
                    $('#suggestions').html(res).show();
                    $("input").blur(function () {
                        $('#suggestions').fadeOut();
                    });
                }
            });
        }
        return false;
    });
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>