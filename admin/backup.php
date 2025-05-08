<?php
  /**
   * Backup
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: backup.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("Backup")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php
  require_once(BASEPATH . "lib/class_dbtools.php");
  Registry::set('dbTools',new dbTools());
	  
  if (isset($_GET['backupok']) && $_GET['backupok'] == "1")
      Filter::msgOk(Lang::$word->_BK_BACKUP_OK,1,0);
	    
  if (isset($_GET['create']) && $_GET['create'] == "1")
      Registry::get("dbTools")->doBackup('',false);
	  
  $dir = BASEPATH . 'admin/backups/';
?>
<div class="tubi icon heading message mortar"><a class="helper tubi top right info corner label" data-help="backup"><i class="icon help"></i></a> <i class="hdd icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_BK_TITLE1;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_BACK;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_BK_INFO1;?></div>
  <div class="tubi segment"><a class="tubi icon positive button push-right" href="index.php?do=backup&amp;create=1"><i class="icon add"></i> <?php echo Lang::$word->_BK_CREATE;?></a>
    <div class="tubi header"><?php echo Lang::$word->_BK_SUBTITLE1;?></div>
    <div class="tubi fitted divider"></div>
    <?php if (is_dir($dir)):?>
    <?php $getDir = dir($dir);?>
    <div class="tubi divided list">
      <?php while (false !== ($file = $getDir->read())):?>
      <?php if ($file != "." && $file != ".." && $file != "index.php"):?>
      <?php $latest =  ($file == $core->backup) ? " active" : "";?>
      <div class="item<?php echo $latest;?>"><i class="big icon hdd"></i>
        <div class="header"><?php echo getSize(filesize(BASEPATH . 'admin/backups/' . $file));?></div>
        <div class="push-right"> <a class="dbdelete" data-content="<?php echo Lang::$word->_DELETE;?>" data-option="deleteBackup" data-file="<?php echo $file;;?>"><i class="rounded danger inverted trash icon"></i></a> <a href="<?php echo ADMINURL . '/backups/' . $file;?>" data-content="<?php echo Lang::$word->_DOWNLOAD;?>"><i class="rounded success inverted download alt icon"></i></a> <a class="restore" data-content="<?php echo Lang::$word->_BK_RESTORE_DB;?>" data-file="<?php echo $file;?>"><i class="rounded warning inverted refresh icon"></i></a> </div>
        <div class="content"><?php echo str_replace(".sql", "", $file);?></div>
      </div>
      <?php endif;?>
      <?php endwhile;?>
      <?php $getDir->close();?>
    </div>
    <?php endif;?>
  </div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $('a.restore').on('click', function () {
        var parent = $(this).closest('div.item');
        var id = $(this).data('file')
        var title = id;
        var text = "<div class=\"messi-warning\"><i class=\"massive icon warn warning sign\"></i></p><p><?php echo Lang::$word->_BK_DORESTORE1;?><br><strong><?php echo Lang::$word->_BK_DORESTORE2;?></strong></p></div>";
        new Messi(text, {
            title: "<?php echo Lang::$word->_BK_RESTORE_DB1;?>",
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: "<?php echo Lang::$word->_BK_RESTORE_DB;?>",
                val: 'Y',
				class: 'negative'
            }],
            callback: function (val) {
                if (val === "Y") {
					$.ajax({
						type: 'post',
						dataType: 'json',
						url: "controller.php",
						data: 'restoreBackup=' + id,
						success: function (json) {
							parent.effect('highlight', 1500);
							$.sticky(decodeURIComponent(json.message), {
								type: json.type,
								title: json.title
							});
						}
					});
                }
            }
        })
    });
	
    $('body').on('click', 'a.dbdelete', function () {
        var file = $(this).data('file');
        var name = $(this).data('file');
        var title = $(this).data('file');
        var option = $(this).data('option');
        var parent = $(this).parent().parent();

        new Messi("<div class=\"messi-warning\"><i class=\"massive icon warn warning sign\"></i></p><p><?php echo Lang::$word->_DEL_CONFIRM;?><br><strong><?php echo Lang::$word->_DEL_CONFIRM1;?></strong></p></div>", {
            title: title,
            titleClass: '',
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: '<?php echo Lang::$word->_DELETE;?>',
                class: 'negative',
                val: 'Y'
            }],
            callback: function (val) {
                $.ajax({
                    type: 'post',
                    url: "controller.php",
                    dataType: 'json',
                    data: {
                        file: file,
                        delete: option,
                        title: encodeURIComponent(name)
                    },
                    beforeSend: function () {
                        parent.animate({
                            'backgroundColor': '#FFBFBF'
                        }, 400);
                    },
                    success: function (json) {
                        parent.fadeOut(400, function () {
                            parent.remove();
                        });
                        $.sticky(decodeURIComponent(json.message), {
                            type: json.type,
                            title: json.title
                        });
                    }

                });
            }
        });
    });

});
// ]]>
</script> 