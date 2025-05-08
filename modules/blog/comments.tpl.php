<?php
  /**
   * Comments Form
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: form.tpl.php, 2014-01-20 16:17:34 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($row->show_comments):?>
<?php $pages = ceil($row->totalcomments / Registry::get("Blog")->cperpage);?>
<h4 class="tubi header"><?php echo ($row->totalcomments <> 0) ?  $row->totalcomments . " " . Lang::$word->_MOD_AMC_COMMENTS_C . "<em>" . $row->{'title' . Lang::$lang} . "</em>" : Lang::$word->_MOD_AMC_NOCOMMENTS;?></h4>
<div id="comments" class="tubi threaded comments"></div>
<?php if($row->totalcomments > Registry::get("Blog")->cperpage):?>
<div id="pagination" class="content-center">
  <div class="tubi pagination menu">
    <?php for($j=1; $j<=$pages; $j++):?>
    <a class="item" data-id="<?php echo $j;?>"><?php echo $j;?></a>
    <?php endfor;?>
  </div>
</div>
<?php endif;?>
<?php if(Registry::get("Blog")->public_access):?>
<?php include("form.tpl.php");?>
<?php elseif(!Registry::get("Blog")->public_access and $user->logged_in):?>
<?php include("form.tpl.php");?>
<?php else:?>
<?php echo Filter::msgSingleAlert(Lang::$word->_MOD_AMC_MSGERR3);?>
<?php endif;?>
<script type="text/javascript">
// <![CDATA[
function loadComments() {
    $("#pagination [data-id=1]").addClass("active");
	$('#comments').addClass('loader');
    $.ajax({
        url: SITEURL + "/modules/blog/loadComments.php",
        data: {
            pg: 1,
            artid: <?php echo $row->id;?>
        },
        cache: false,
        success: function (data) {
            $("#comments").fadeIn("slow", function () {
                $(this).html(data);
                setTimeout(function () {
                    $('#comments').removeClass('loader');
                }, 500);
            });
			$('body [data-content]').popover({trigger: 'hover', placement: 'auto'});
        }
    });
}
$.fn.limit = function (options) {
	var defaults = {
		limit: 200,
		id_result: false,
		alertClass: false
	}
	var options = $.extend(defaults, options);
	return this.each(function () {
		var characters = options.limit;
		if (options.id_result != false) {
			$("#" + options.id_result).append("<?php echo Lang::$word->_MOD_AM_CHAR_REMAIN1;?> " + characters + " <?php echo Lang::$word->_MOD_AM_CHAR_REMAIN2;?>");
		}
		$(this).keyup(function () {
			if ($(this).val().length > characters) {
				$(this).val($(this).val().substr(0, characters));
			}
			if (options.id_result != false) {
				var remaining = characters - $(this).val().length;
				$("#" + options.id_result).html("<?php echo Lang::$word->_MOD_AM_CHAR_REMAIN1;?> " + remaining + " <?php echo Lang::$word->_MOD_AM_CHAR_REMAIN2;?>");
				if (remaining <= 10) {
					$("#" + options.id_result).addClass(options.alertClass);
				} else {
					$("#" + options.id_result).removeClass(options.alertClass);
				}
			}
		});
	});
};
$(document).ready(function () {
    loadComments();
    $(".tubi.pagination a").click(function () {
        $('#comments').addClass('loader');
        $(".tubi.pagination a").removeClass("active");
        $(this).addClass("active");
        var page = $(this).attr("data-id");
        $.ajax({
            url: SITEURL + "/modules/blog/loadComments.php",
            data: {
                pg: page,
                artid: <?php echo $row->id;?>
            },
            cache: false,
            success: function (data) {
                $("#comments").fadeIn("slow", function () {
                    $(this).html(data);
                    setTimeout(function () {
                        $('#comments').removeClass('loader');
                    }, 500);
                });


            }
        });
    });

    $('#comments').on('click', 'a.delete', function () {
        var id = $(this).data('id');
        var $parent = $(this).closest('.comment');
        $.post('<?php echo MODURL;?>blog/controller.php', {
            delComment: 1,
            id: id
        }, function () {
            $parent.slideUp();
        });
    });

    $("#combody").limit({
        limit: <?php echo Registry::get("Blog")->char_limit;?>,
        id_result: "counter",
        alertClass: "error"
    });
});
// ]]>
</script>
<?php endif;?>