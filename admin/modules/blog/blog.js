function loadList() {
    $.ajax({
        type: 'post',
        url: "modules/blog/controller.php",
        data: 'getcats=1',
        cache: false,
        success: function (html) {
            $("#menusort").html(html);
        }
    });
}
$(document).ready(function () {

    $("button[name='docategory']").click(function () {
        $(".tubi.form").addClass("loading");
        var str = $('#tubi_form').serialize()
        $.ajax({
            type: "post",
            url: "modules/blog/controller.php",
            dataType: 'json',
            data: str,
            cache: false,
            success: function (json) {
                if (json.type == "success") {
                    $(".tubi.form").removeClass("loading");
                    $("#msgholder").html(json.message);
                    loadList();
                } else {
                    $(".tubi.form").removeClass("loading");
                    $("#msgholder").html(json.message);
                }
            }
        });
    });

    $('body').on('click', "#serialize", function () {
        serialized = $('#menusort').nestedSortable('serialize');
        serialized += '&doCatSort=1';
        $.ajax({
            type: 'post',
            url: "modules/blog/controller.php",
            data: serialized,
            success: function (msg) {
                $("#msgalt").html(msg);
                setTimeout(function () {
                    $(loadList()).fadeIn("slow");
                }, 2000);
                $("html, body").animate({
                    scrollTop: 0
                }, 600);
            }
        });
    })

    $('div#menusort').nestedSortable({
        forcePlaceholderSize: true,
        listType: 'ul',
        handle: 'div',
        helper: 'clone',
        items: 'li',
        opacity: .6,
        placeholder: 'placeholder',
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div'
    });
});