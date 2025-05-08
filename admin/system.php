<?php
  /**
   * System
   *
   * @yazilim Tubi Portal
   * @autdor turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: system.php, v4.00 2014-03-05 14:15:22 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to tdis location is not allowed.');
	  
  if(!$user->getAcl("System")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  require_once(BASEPATH . "lib/class_dbtools.php");
  Registry::set('dbTools',new dbTools());
?>
<div class="tubi icon heading message mortar"> <i class="laptop icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_SYS_TITLE;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_SYSTEM;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_SYS_INFO;?></div>
  <div class="tubi segment">
    <div class="tubi header">
      <ul class="idTabs" id="tabs">
        <li><a data-tab="#cms"><?php echo Lang::$word->_SYS_CMS_INF;?></a></li>
        <li><a data-tab="#php"><?php echo Lang::$word->_SYS_PHP_INF;?></a></li>
        <li><a data-tab="#server"><?php echo Lang::$word->_SYS_SER_INF;?></a></li>
        <li><a data-tab="#dbtables"><?php echo Lang::$word->_SYS_DBTABLE_INF;?></a></li>
      </ul>
      <?php echo Lang::$word->_SYS_SUB;?></div>
    <div class="tubi fitted divider"></div>
    <div id="cms" class="tab_content">
      <table class="tubi two column table">
        <thead>
          <tr>
            <th colspan="2"><?php echo Lang::$word->_SYS_CMS_INF;?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo Lang::$word->_SYS_CMS_VER;?>:</td>
            <td>v<?php echo $core->version;?> <span id="version"> </span></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_ROOT_URL;?>:</td>
            <td><?php echo SITEURL;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_ROOT_PATH;?>:</td>
            <td><?php echo BASEPATH;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_UPL_URL;?>:</td>
            <td><?php echo UPLOADURL;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_UPL_PATH;?>:</td>
            <td><?php echo UPLOADS;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_DEF_LANG;?>:</td>
            <td><?php echo strtoupper($core->lang);?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="php" class="tab_content">
      <table class="tubi two column table">
        <thead>
          <tr>
            <th colspan="2"><?php echo Lang::$word->_SYS_PHP_INF;?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo Lang::$word->_SYS_PHP_VER;?>:</td>
            <td><?php echo phpversion();?></td>
          </tr>
          <tr>
            <?php $gdinfo = gd_info();?>
            <td><?php echo Lang::$word->_SYS_GD_VER;?>:</td>
            <td><?php echo $gdinfo['GD Version'];?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_MQR;?>:</td>
            <td><?php echo (ini_get('magic_quotes_gpc')) ? Lang::$word->_ON : Lang::$word->_OFF;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_LOG_ERR;?>:</td>
            <td><?php echo (ini_get('log_errors')) ? Lang::$word->_ON : Lang::$word->_OFF;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_MEM_LIM;?>:</td>
            <td><?php echo ini_get('memory_limit');?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_RG;?>:</td>
            <td><?php echo (ini_get('register_globals')) ? Lang::$word->_ON : Lang::$word->_OFF;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_SM;?>:</td>
            <td><?php echo (ini_get('safe_mode')) ? Lang::$word->_ON : Lang::$word->_OFF;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_UMF;?>:</td>
            <td><?php echo ini_get('upload_max_filesize'); ?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_PMF;?>:</td>
            <td><?php echo ini_get('post_max_size');?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_SSP;?>:</td>
            <td><?php echo ini_get('session.save_path' );?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="server" class="tab_content">
      <table class="tubi two column table">
        <thead>
          <tr>
            <th colspan="2"><?php echo Lang::$word->_SYS_SER_INF;?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo Lang::$word->_SYS_SER_OS;?>:</td>
            <td><?php echo php_uname('s')." (".php_uname('r').")";?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_SER_API;?>:</td>
            <td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_SER_DB;?>:</td>
            <td><?php echo mysqli_get_client_info();?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_DBV;?>:</td>
            <td><?php echo mysqli_get_server_info($db->getLink());?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_MEMALO;?>:</td>
            <td><?php echo ini_get('memory_limit');?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->_SYS_STS;?>:</td>
            <td><?php echo getSize(disk_free_space("."));?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="dbtables" class="tab_content"> <?php print dbTools::optimizeDb();?> </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var url = 'http://www.turkbilisim.com.tr/version.json?callback=?';
    $.ajax({
        type: 'GET',
        url: url,
        async: false,
        jsonpCallback: 'jsonCallback',
        contentType: "application/json",
        dataType: 'jsonp',
        success: function (json) {
            if (json.versions[0].tubicms !==  ) {
                $("#version").html('(Latest Version: v.' + json.versions[0].tubicms + ' Released: ' + json.versions[0].cmsupdated + ')');
            }
        }
    });
});
</script>