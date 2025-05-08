$(document).ready(function () {
	$('#article').on('click', 'a.like', function () {
		$el = $(this).children('span')
		id = $(this).data("id");
		total = $(this).data("total");
		$.post(SITEURL + "/modules/blog/controller.php", {
			doLike: 1,
			id: id,
			total: total
		}, function (data) {
			$($el).html(data);
		});
		$(this).removeClass('like');
	});

    /* == Rating Item == */
    $(".tubi.rating-vote b").on("click", function () {
        var rate = $(this).attr("data-rate");
		var id = $(this).attr("data-item");
        $.ajax({
            type: "post",
            url: SITEURL + "/modules/blog/controller.php",
            data: {
				rating: 1,
				id: id,
				stars :rate
			},
            success: function (msg) {
                $(".tubi.rating-vote").html(msg);
				$.cookie("RATE_BLG_TUBI_", id, {
					expires: 120,
					path: '/'
				});

            }
        });
        return false;
    });
});