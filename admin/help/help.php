<?php
  /**
   * Help
   *
   * @yazilim CMS pro
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: help.php,v 1.00 2014-01-10 21:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);

  require_once ("../init.php");
  if (!$user->is_Admin())
      redirect_to("../login.php");
?>
<div id="page-help">
  <div class="header">
    <p><?php echo Lang::$word->_PG_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_PG_TITLE;?></h5>
      <?php echo Lang::$word->_PG_TITLE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_CAPTION;?></h5>
      <?php echo Lang::$word->_PG_CAPTION_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_SLUG;?></h5>
      <?php echo Lang::$word->_PG_SLUG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_ACCESS_L;?></h5>
      <?php echo Lang::$word->_PG_ACCESS_LT;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_MEM_LEVEL;?></h5>
      <?php echo Lang::$word->_PG_MEM_LEVEL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_SEL_MODULE;?></h5>
      <?php echo Lang::$word->_PG_SEL_MODULE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_BG_IMAGE;?></h5>
      <?php echo Lang::$word->_PG_BG_IMAGE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_CC;?></h5>
      <?php echo Lang::$word->_PG_CC_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_HOME;?></h5>
      <?php echo Lang::$word->_PG_HOME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_LOGIN;?></h5>
      <?php echo Lang::$word->_PG_LOGIN_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_REGISTER;?></h5>
      <?php echo Lang::$word->_PG_REGISTER_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_ACTIVATE;?></h5>
      <?php echo Lang::$word->_PG_ACTIVATE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_ACCOUNT;?></h5>
      <?php echo Lang::$word->_PG_ACCOUNT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_SITEMAP;?></h5>
      <?php echo Lang::$word->_PG_SITEMAP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_ADMONLY;?></h5>
      <?php echo Lang::$word->_PG_ADMONLY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_SEARCH;?></h5>
      <?php echo Lang::$word->_PG_SEARCH_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_PROFILE;?></h5>
      <?php echo Lang::$word->_PG_PROFILE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_JSCODE;?></h5>
      <?php echo Lang::$word->_PG_JSCODE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_KEYS;?></h5>
      <?php echo Lang::$word->_PG_KEYS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_DESC;?></h5>
      <?php echo Lang::$word->_PG_DESC_T;?> </div>
  </div>
</div>
<div id="user-help">
  <div class="header">
    <p><?php echo Lang::$word->_UR_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_PASSWORD;?></h5>
      <?php echo Lang::$word->_UR_PASS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MEMBERSHIP;?></h5>
      <?php echo Lang::$word->_UR_NOMEMBERSHIP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_UR_STATUS;?></h5>
      <?php echo Lang::$word->_UR_STATUS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_UR_PERM;?></h5>
      <?php echo Lang::$word->_UR_PERM_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_UR_LEVEL;?></h5>
      <?php echo Lang::$word->_UR_LEVEL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_UR_BIO;?></h5>
      <?php echo Lang::$word->_UR_BIO_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_UR_NOTES;?></h5>
      <?php echo Lang::$word->_UR_NOTES_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_UR_NOTIFY;?></h5>
      <?php echo Lang::$word->_UR_NOTIFY_T;?> </div>
  </div>
</div>
<div id="plugin-help">
  <div class="header">
    <p><?php echo Lang::$word->_PL_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_PL_TITLE;?></h5>
      <?php echo Lang::$word->_PL_TITLE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PL_ALT_CLASS;?></h5>
      <?php echo Lang::$word->_PL_ALT_CLASS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PL_SHOW_TITLE;?></h5>
      <?php echo Lang::$word->_PL_SHOW_TITLE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_JSCODE;?></h5>
      <?php echo Lang::$word->_PG_JSCODE_T;?> </div>
  </div>
</div>
<div id="module-help">
  <div class="header">
    <p><?php echo Lang::$word->_MO_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MO_TITLE;?></h5>
      <?php echo Lang::$word->_MO_TITLE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MO_THEME;?></h5>
      <?php echo Lang::$word->_MO_THEME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_METAKEYS;?></h5>
      <?php echo Lang::$word->_CG_METAKEY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_METADESC;?></h5>
      <?php echo Lang::$word->_CG_METADESC_T;?> </div>
  </div>
</div>
<div id="menu-help">
  <div class="header">
    <p><?php echo Lang::$word->_PG_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MU_MENUS;?></h5>
      <?php echo Lang::$word->_MU_INFO_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MU_NAME;?></h5>
      <?php echo Lang::$word->_MU_NAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MU_CAPTION;?></h5>
      <?php echo Lang::$word->_MU_CAPTION_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MU_PARENT;?></h5>
      <?php echo Lang::$word->_MU_PARENT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MU_TOP;?></h5>
      <?php echo Lang::$word->_MU_TOP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MU_TYPE;?></h5>
      <?php echo Lang::$word->_MU_TYPE_SEL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MU_LINK;?></h5>
      <?php echo Lang::$word->_MU_LINK_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MU_COLS;?></h5>
      <?php echo Lang::$word->_MU_COLS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MU_ICON;?></h5>
      <?php echo Lang::$word->_MU_ICON_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MU_HOME;?></h5>
      <?php echo Lang::$word->_MU_HOME_T;?> </div>
  </div>
</div>
<div id="membership-help">
  <div class="header">
    <p><?php echo Lang::$word->_MS_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MS_TITLE;?></h5>
      <?php echo Lang::$word->_MS_TITLE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MS_PRICE;?></h5>
      <?php echo Lang::$word->_MS_PRICE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MS_PERIOD;?></h5>
      <?php echo Lang::$word->_MS_PERIOD_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MS_RECURRING;?></h5>
      <?php echo Lang::$word->_MS_RECURRING_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MS_PRIVATE;?></h5>
      <?php echo Lang::$word->_MS_PRIVATE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MS_ACTIVE;?></h5>
      <?php echo Lang::$word->_MS_ACTIVE_T;?> </div>
  </div>
</div>
<div id="gateway-help">
  <div class="header">
    <p><?php echo Lang::$word->_GW_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_GW_NAME;?></h5>
      <?php echo Lang::$word->_GW_NAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_GW_LIVE;?></h5>
      <?php echo Lang::$word->_GW_LIVE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_GW_LIVE;?></h5>
      <?php echo Lang::$word->_GW_LIVE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_GW_ACTIVE;?></h5>
      <?php echo Lang::$word->_GW_ACTIVE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_GW_IPNURL;?></h5>
      <?php echo Lang::$word->_GW_IPNURL_T;?> </div>
    <div class="item">
      <h5>PayPal</h5>
      <?php echo Lang::$word->_GW_HELP_PP;?> </div>
    <div class="item">
      <h5>Skrill/Moneybookers</h5>
      <?php echo Lang::$word->_GW_HELP_MB;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_GW_OFFLINE;?></h5>
      <?php echo Lang::$word->_GW_HELP_OL;?> </div>
  </div>
</div>
<div id="layout-help">
  <div class="header">
    <p><?php echo Lang::$word->_LY_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_LY_TITLE;?></h5>
      <?php echo Lang::$word->_LY_INFO_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_LY_SECTION;?></h5>
      <?php echo Lang::$word->_LY_SECTION_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_LY_SORTING;?></h5>
      <?php echo Lang::$word->_LY_SORTING_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_LY_INSERT;?></h5>
      <?php echo Lang::$word->_LY_INSERT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_LY_REMOVE;?></h5>
      <?php echo Lang::$word->_LY_REMOVE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_LY_COLS;?></h5>
      <?php echo Lang::$word->_LY_COLS_T;?> </div>
  </div>
</div>
<div id="configure-help">
  <div class="header">
    <p><?php echo Lang::$word->_CG_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_CG_SITENAME;?></h5>
      <?php echo Lang::$word->_CG_SITENAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_COMPANY;?></h5>
      <?php echo Lang::$word->_CG_COMPANY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_DIR;?></h5>
      <?php echo Lang::$word->_CG_DIR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_WEBURL;?></h5>
      <?php echo Lang::$word->_CG_WEBURL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_WEBEMAIL;?></h5>
      <?php echo Lang::$word->_CG_WEBEMAIL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_THEME;?></h5>
      <?php echo Lang::$word->_CG_THEME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_THEME_VAR;?></h5>
      <?php echo Lang::$word->_CG_THEME_VAR;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_LOGO;?></h5>
      <?php echo Lang::$word->_CG_LOGO_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_EDITOR;?></h5>
      <?php echo Lang::$word->_CG_EDITOR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_SHOW_LOGIN;?></h5>
      <?php echo Lang::$word->_CG_SHOW_LOGIN_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_SHOW_SEARCH;?></h5>
      <?php echo Lang::$word->_CG_SHOW_SEARCH_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_SHOW_CRUMBS;?></h5>
      <?php echo Lang::$word->_CG_SHOW_CRUMBS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_LANG_SHOW;?></h5>
      <?php echo Lang::$word->_CG_LANG_SHOW_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_EUCOOKIE;?></h5>
      <?php echo Lang::$word->_CG_EUCOOKIE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_OFFLINE;?></h5>
      <?php echo Lang::$word->_CG_OFFLINE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_OFFLINE_MSG;?></h5>
      <?php echo Lang::$word->_CG_OFFLINE_MSG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_OFFLINE;?></h5>
      <?php echo Lang::$word->_CG_OFFLINE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_OFFLINE_TIME;?></h5>
      <?php echo Lang::$word->_CG_OFFLINE_TIME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_BGIMG;?></h5>
      <?php echo Lang::$word->_CG_BGIMG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_LOCALES;?></h5>
      <?php echo Lang::$word->_CG_LOCALES_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_DTZ;?></h5>
      <?php echo Lang::$word->_CG_DTZ_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_THUMB_WH;?></h5>
      <?php echo Lang::$word->_CG_THUMB_WH_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_IMG_WH;?></h5>
      <?php echo Lang::$word->_CG_IMG_WH_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_AVATAR_WH;?></h5>
      <?php echo Lang::$word->_CG_AVATAR_WH_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_PERPAGE;?></h5>
      <?php echo Lang::$word->_CG_PERPAGE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_CURRENCY;?></h5>
      <?php echo Lang::$word->_CG_CURRENCY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_CUR_SYMBOL;?></h5>
      <?php echo Lang::$word->_CG_CUR_SYMBOL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_REGVERIFY;?></h5>
      <?php echo Lang::$word->_CG_REGVERIFY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_AUTOVERIFY;?></h5>
      <?php echo Lang::$word->_CG_AUTOVERIFY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_REGALOWED;?></h5>
      <?php echo Lang::$word->_CG_REGALOWED_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_NOTIFY_ADMIN;?></h5>
      <?php echo Lang::$word->_CG_NOTIFY_ADMIN_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_USERLIMIT;?></h5>
      <?php echo Lang::$word->_CG_USERLIMIT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_LOGIN_ATTEMPT;?></h5>
      <?php echo Lang::$word->_CG_LOGIN_ATTEMPT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_LOGIN_TIME;?></h5>
      <?php echo Lang::$word->_CG_LOGIN_TIME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_LOG_ON;?></h5>
      <?php echo Lang::$word->_CG_LOG_ON_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_MAILER;?></h5>
      <?php echo Lang::$word->_CG_MAILER_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_SMTP_HOST;?></h5>
      <?php echo Lang::$word->_CG_SMTP_HOST_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_SMTP_PORT;?></h5>
      <?php echo Lang::$word->_CG_SMTP_PORT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_SMTP_SSL;?></h5>
      <?php echo Lang::$word->_CG_SMTP_SSL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_SMAILPATH;?></h5>
      <?php echo Lang::$word->_CG_SMAILPATH_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_GA;?></h5>
      <?php echo Lang::$word->_CG_GA_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_METAKEY;?></h5>
      <?php echo Lang::$word->_CG_METAKEY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_CG_METADESC;?></h5>
      <?php echo Lang::$word->_CG_METADESC_T;?> </div>
  </div>
</div>
<div id="email-help">
  <div class="header">
    <p><?php echo Lang::$word->_ET_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_ET_VARS;?></h5>
      <?php echo Lang::$word->_ET_VARS_T;?> </div>
  </div>
</div>
<div id="backup-help">
  <div class="header">
    <p><?php echo Lang::$word->_BK_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_BK_INFO_I;?></h5>
      <?php echo Lang::$word->_BK_INFO_T;?> </div>
  </div>
</div>
<div id="language-help">
  <div class="header">
    <p><?php echo Lang::$word->_LA_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_LA_TTITLE;?></h5>
      <?php echo Lang::$word->_LA_TTITLE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_LA_COUNTRY_ABB;?></h5>
      <?php echo Lang::$word->_LA_COUNTRY_ABB_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_LA_LANGDIR;?></h5>
      <?php echo Lang::$word->_LA_LANGDIR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_LA_SUBTITLE2;?></h5>
      <?php echo Lang::$word->_LA_SUBTITLE2_T;?> </div>
  </div>
</div>
<div id="gallery-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_GA_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_GA_NAME;?></h5>
      <?php echo Lang::$word->_MOD_GA_NAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_GA_FOLDER;?></h5>
      <?php echo Lang::$word->_MOD_GA_FOLDER_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_GA_COLS;?></h5>
      <?php echo Lang::$word->_MOD_GA_COLS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_GA_LIKE;?></h5>
      <?php echo Lang::$word->_MOD_GA_LIKE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_GA_WATERMARK;?></h5>
      <?php echo Lang::$word->_MOD_GA_WATERMARK_T;?> </div>
  </div>
</div>
<div id="gallery_upload-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_GA_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_GA_EDIT;?></h5>
      <?php echo Lang::$word->_MOD_GA_EDIT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_GA_UPL;?></h5>
      <?php echo Lang::$word->_MOD_GA_UPL_T;?> </div>
  </div>
</div>
<div id="comments-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_CM_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_DATE;?></h5>
      <?php echo Lang::$word->_MOD_CM_DATE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_CHAR;?></h5>
      <?php echo Lang::$word->_MOD_CM_CHAR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_PERPAGE;?></h5>
      <?php echo Lang::$word->_MOD_CM_PERPAGE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_UNAME_R;?></h5>
      <?php echo Lang::$word->_MOD_CM_UNAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_EMAIL_R;?></h5>
      <?php echo Lang::$word->_MOD_CM_EMAIL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_CAPTCHA;?></h5>
      <?php echo Lang::$word->_MOD_CM_CAPTCHA_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_WWW;?></h5>
      <?php echo Lang::$word->_MOD_CM_WWW_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_UNAME_S;?></h5>
      <?php echo Lang::$word->_MOD_CM_UNAME_ST;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_EMAIL_S;?></h5>
      <?php echo Lang::$word->_MOD_CM_EMAIL_ST;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_REG_ONLY;?></h5>
      <?php echo Lang::$word->_MOD_CM_REG_ONLY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_AA;?></h5>
      <?php echo Lang::$word->_MOD_CM_AA_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_NOTIFY;?></h5>
      <?php echo Lang::$word->_MOD_CM_NOTIFY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_CM_WORDS;?></h5>
      <?php echo Lang::$word->_MOD_CM_WORDS_T;?> </div>
  </div>
</div>
<div id="gmaps-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_GM_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_GM_NAME;?></h5>
      <?php echo Lang::$word->_MOD_GM_NAME2;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_GM_MAPINFO;?></h5>
      <?php echo Lang::$word->_MOD_GM_MAPINFO_T;?> </div>
  </div>
</div>
<div id="adblock-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_AB_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AB_NAME;?></h5>
      <?php echo Lang::$word->_MOD_AB_NAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AB_DATE_S;?></h5>
      <?php echo Lang::$word->_MOD_AB_DATE_ST;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AB_DATE_E;?></h5>
      <?php echo Lang::$word->_MOD_AB_DATE_ET;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AB_MAX_VIEWS;?></h5>
      <?php echo Lang::$word->_MOD_AB_MAX_VIEWS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AB_MAX_CLICKS;?></h5>
      <?php echo Lang::$word->_MOD_AB_MAX_CLICKS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AB_MIN_CTR;?></h5>
      <?php echo Lang::$word->_MOD_AB_MIN_CTR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AB_BLOCK_ASSIGNMENT;?></h5>
      <?php echo Lang::$word->_MOD_AB_BLOCK_ASSIGNMENT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_UR_LEVEL;?></h5>
      <?php echo Lang::$word->_MOD_AB_ULEVEL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AB_ADVERTISEMENT_MEDIA;?></h5>
      <?php echo Lang::$word->_MOD_AB_ADVERTISEMENT_MEDIA_T;?> </div>
  </div>
</div>
<div id="events-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_EM_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_EM_TITLE;?></h5>
      <?php echo Lang::$word->_MOD_EM_TITLE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_EM_VENUE;?></h5>
      <?php echo Lang::$word->_MOD_EM_VENUE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_EM_COLOUR;?></h5>
      <?php echo Lang::$word->_MOD_EM_COLOUR_T;?> </div>
  </div>
</div>
<div id="poll-help">
  <div class="header">
    <p><?php echo Lang::$word->_PLG_PL_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_PL_QUESTION;?></h5>
      <?php echo Lang::$word->_PLG_PL_QUESTION_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_PL_OPTIONS;?></h5>
      <?php echo Lang::$word->_PLG_PL_OPTIONS_T;?> </div>
  </div>
</div>
<div id="upevent-help">
  <div class="header">
    <p><?php echo Lang::$word->_PLG_UE_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_UE_SELECT;?></h5>
      <?php echo Lang::$word->_PLG_UE_SELECT_T;?> </div>
  </div>
</div>
<div id="donate-help">
  <div class="header">
    <p><?php echo Lang::$word->_PLG_DP_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_DP_TARGET;?></h5>
      <?php echo Lang::$word->_PLG_DP_TARGET_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_DP_PAYPAL;?></h5>
      <?php echo Lang::$word->_PLG_DP_PAYPAL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_DP_THANKYOU;?></h5>
      <?php echo Lang::$word->_PLG_DP_THANKYOU_T;?> </div>
  </div>
</div>
<div id="twitts-help">
  <div class="header">
    <p><?php echo Lang::$word->_PLG_TW_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_TW_USER;?></h5>
      <?php echo Lang::$word->_PLG_TW_USER_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_TW_KEY;?></h5>
      <?php echo Lang::$word->_PLG_TW_KEY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_TW_COUNT;?></h5>
      <?php echo Lang::$word->_PLG_TW_COUNT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_TW_TRANS;?></h5>
      <?php echo Lang::$word->_PLG_TW_TRANS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_TW_SHOW_IMG;?></h5>
      <?php echo Lang::$word->_PLG_TW_SHOW_IMG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_TW_TRANS_T;?></h5>
      <?php echo Lang::$word->_PLG_TW_TRANS_TT;?> </div>
  </div>
</div>
<div id="slider-help">
  <div class="header">
    <p><?php echo Lang::$word->_PLG_SL_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_HEIGHT;?></h5>
      <?php echo Lang::$word->_PLG_SL_HEIGHT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_TRSPEED;?></h5>
      <?php echo Lang::$word->_PLG_SL_TRSPEED_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_TRDELAY;?></h5>
      <?php echo Lang::$word->_PLG_SL_TRDELAY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_TRANS;?></h5>
      <?php echo Lang::$word->_PLG_SL_TRANS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_TRANS_EAS;?></h5>
      <?php echo Lang::$word->_PLG_SL_TRANS_EAS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_TRANS_DIR;?></h5>
      <?php echo Lang::$word->_PLG_SL_TRANS_DIR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_SCALE;?></h5>
      <?php echo Lang::$word->_PLG_SL_SCALE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_ADPHEIGHT;?></h5>
      <?php echo Lang::$word->_PLG_SL_ADPHEIGHT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_APLAY;?></h5>
      <?php echo Lang::$word->_PLG_SL_APLAY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_SHUFLLE;?></h5>
      <?php echo Lang::$word->_PLG_SL_SHUFLLE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_WLOAD;?></h5>
      <?php echo Lang::$word->_PLG_SL_WLOAD_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_REVERSE;?></h5>
      <?php echo Lang::$word->_PLG_SL_REVERSE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_STRIP;?></h5>
      <?php echo Lang::$word->_PLG_SL_STRIP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_CAPTIONS;?></h5>
      <?php echo Lang::$word->_PLG_SL_CAPTIONS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_CAPTIONS_S;?></h5>
      <?php echo Lang::$word->_PLG_SL_CAPTIONS_ST;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_TIMER;?></h5>
      <?php echo Lang::$word->_PLG_SL_TIMER_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_PAUSE;?></h5>
      <?php echo Lang::$word->_PLG_SL_PAUSE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_ARROWS;?></h5>
      <?php echo Lang::$word->_PLG_SL_ARROWS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_SL_DOTS;?></h5>
      <?php echo Lang::$word->_PLG_SL_DOTS_T;?> </div>
  </div>
</div>
<div id="vslider-help">
  <div class="header">
    <p><?php echo Lang::$word->_PLG_VS_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_THEME;?></h5>
      <?php echo Lang::$word->_PLG_VS_THEME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_YCOLOR;?></h5>
      <?php echo Lang::$word->_PLG_VS_YCOLOR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_VQ;?></h5>
      <?php echo Lang::$word->_PLG_VS_VQ_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_HIDE;?></h5>
      <?php echo Lang::$word->_PLG_VS_HIDE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_SHOWINFO;?></h5>
      <?php echo Lang::$word->_PLG_VS_SHOWINFO_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_REL;?></h5>
      <?php echo Lang::$word->_PLG_VS_REL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_VTITLE;?></h5>
      <?php echo Lang::$word->_PLG_VS_VTITLE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_BYLINE;?></h5>
      <?php echo Lang::$word->_PLG_VS_BYLINE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_PORT;?></h5>
      <?php echo Lang::$word->_PLG_VS_PORT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_VCOLOR;?></h5>
      <?php echo Lang::$word->_PLG_VS_VCOLOR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_AUTOPLAY;?></h5>
      <?php echo Lang::$word->_PLG_VS_AUTOPLAY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_VS_FULLSCR;?></h5>
      <?php echo Lang::$word->_PLG_VS_FULLSCR_T;?> </div>
  </div>
</div>
<div id="rss-help">
  <div class="header">
    <p><?php echo Lang::$word->_PLG_RSS_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_RSS_URL;?></h5>
      <?php echo Lang::$word->_PLG_RSS_URL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_RSS_TITLETRIM;?></h5>
      <?php echo Lang::$word->_PLG_RSS_TITLETRIM_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_RSS_BODYTRIM;?></h5>
      <?php echo Lang::$word->_PLG_RSS_BODYTRIM_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_RSS_ITEMS;?></h5>
      <?php echo Lang::$word->_PLG_RSS_ITEMS_T;?> </div>
  </div>
</div>
<div id="elastic-help">
  <div class="header">
    <p><?php echo Lang::$word->_PLG_ES_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_ES_ANITYPE;?></h5>
      <?php echo Lang::$word->_PLG_ES_ANITYPE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_ES_AUTOPLAY;?></h5>
      <?php echo Lang::$word->_PLG_ES_AUTOPLAY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_ES_INTERVAL;?></h5>
      <?php echo Lang::$word->_PLG_ES_INTERVAL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_ES_SPEED;?></h5>
      <?php echo Lang::$word->_PLG_ES_SPEED_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_ES_TITLESPEED;?></h5>
      <?php echo Lang::$word->_PLG_ES_TITLESPEED_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PLG_ES_THUMB;?></h5>
      <?php echo Lang::$word->_PLG_ES_THUMB_T;?> </div>
  </div>
</div>
<div id="portfolio-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_PF_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PF_NAME;?></h5>
      <?php echo Lang::$word->_MOD_PF_NAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PF_SLUG;?></h5>
      <?php echo Lang::$word->_MOD_PF_SLUG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_GAL;?></h5>
      <?php echo Lang::$word->_MOD_GAL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PF_SHORTDESC;?></h5>
      <?php echo Lang::$word->_MOD_PF_SHORTDESC_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_KEYS;?></h5>
      <?php echo Lang::$word->_PG_KEYS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_DESC;?></h5>
      <?php echo Lang::$word->_PG_DESC_T;?> </div>
  </div>
</div>
<div id="pfconfig-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_PF_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PF_COLS;?></h5>
      <?php echo Lang::$word->_MOD_PF_COLS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PF_ITEMPP;?></h5>
      <?php echo Lang::$word->_MOD_PF_ITEMPP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PF_ITEMPPF;?></h5>
      <?php echo Lang::$word->_MOD_PF_ITEMPPF_T;?> </div>
  </div>
</div>
<div id="dsconfig-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_DS_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_FILEDIR;?></h5>
      <?php echo Lang::$word->_MOD_DS_FILEDIR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_IS_FREE;?></h5>
      <?php echo Lang::$word->_MOD_DS_IS_FREE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_LAYOUT;?></h5>
      <?php echo Lang::$word->_MOD_DS_LAYOUT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_LIKE;?></h5>
      <?php echo Lang::$word->_MOD_DS_LIKE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_SHOWCOUNT;?></h5>
      <?php echo Lang::$word->_MOD_DS_SHOWCOUNT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_COLS;?></h5>
      <?php echo Lang::$word->_MOD_DS_COLS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_LATEST;?></h5>
      <?php echo Lang::$word->_MOD_DS_LATEST_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_ITEMPP;?></h5>
      <?php echo Lang::$word->_MOD_DS_ITEMPP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_TEMPLATE;?></h5>
      <?php echo Lang::$word->_MOD_DS_TEMPLATE_T;?> </div>
  </div>
</div>
<div id="digishop-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_DS_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_NAME;?></h5>
      <?php echo Lang::$word->_MOD_DS_NAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_SLUG;?></h5>
      <?php echo Lang::$word->_MOD_DS_SLUG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_MEMBERSHIP;?></h5>
      <?php echo Lang::$word->_MOD_DS_MEMBERSHIP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_GAL;?></h5>
      <?php echo Lang::$word->_MOD_GAL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_PRODIMG;?></h5>
      <?php echo Lang::$word->_MOD_DS_PRODIMG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_PRODFILE;?></h5>
      <?php echo Lang::$word->_MOD_DS_PRODFILE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_KEYS;?></h5>
      <?php echo Lang::$word->_PG_KEYS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_DESC;?></h5>
      <?php echo Lang::$word->_PG_DESC_T;?> </div>
  </div>
</div>
<div id="dscats-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_DS_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_TITLE5;?></h5>
      <?php echo Lang::$word->_MOD_DS_INFO5_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_CATNAME;?></h5>
      <?php echo Lang::$word->_MOD_AM_CATNAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_CATSLUG;?></h5>
      <?php echo Lang::$word->_MOD_DS_CATSLUG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_DS_PARENT;?></h5>
      <?php echo Lang::$word->_MOD_DS_PARENT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_KEYS;?></h5>
      <?php echo Lang::$word->_PG_KEYS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_DESC;?></h5>
      <?php echo Lang::$word->_PG_DESC_T;?> </div>
  </div>
</div>
<div id="forms-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_VF_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_VF_FTITLE;?></h5>
      <?php echo Lang::$word->_MOD_VF_FTITLE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_VF_FSUBJECT;?></h5>
      <?php echo Lang::$word->_MOD_VF_FSUBJECT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_VF_EMAILS;?></h5>
      <?php echo Lang::$word->_MOD_VF_EMAILS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_VF_TEMPLATE;?></h5>
      <?php echo Lang::$word->_MOD_VF_TEMPLATE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_VF_SBUTTON;?></h5>
      <?php echo Lang::$word->_MOD_VF_SBUTTON_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_VF_MESSAGE;?></h5>
      <?php echo Lang::$word->_MOD_VF_MESSAGE_T;?> </div>
  </div>
</div>
<div id="amconfig-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_AM_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_LATEST;?></h5>
      <?php echo Lang::$word->_MOD_AM_LATEST_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_BOX_LATPP;?></h5>
      <?php echo Lang::$word->_MOD_AM_BOX_LATPP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_BOX_POPPP;?></h5>
      <?php echo Lang::$word->_MOD_AM_BOX_POPPP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_BOX_COMPP;?></h5>
      <?php echo Lang::$word->_MOD_AM_BOX_COMPP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_COUNTER;?></h5>
      <?php echo Lang::$word->_MOD_AM_COUNTER_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_UNAME_R;?></h5>
      <?php echo Lang::$word->_MOD_AM_UNAME_RT;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CAPTCHA;?></h5>
      <?php echo Lang::$word->_MOD_AM_CAPTCHA_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_WWW;?></h5>
      <?php echo Lang::$word->_MOD_AM_WWW_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_UNAME_S;?></h5>
      <?php echo Lang::$word->_MOD_AM_UNAME_ST;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_UPOST;?></h5>
      <?php echo Lang::$word->_MOD_AM_UPOST_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_EMAIL_R;?></h5>
      <?php echo Lang::$word->_MOD_AM_EMAIL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_REG_ONLY;?></h5>
      <?php echo Lang::$word->_MOD_AM_REG_ONLY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_LAYOUT;?></h5>
      <?php echo Lang::$word->_MOD_AM_LAYOUT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_NOTIFY;?></h5>
      <?php echo Lang::$word->_MOD_AM_NOTIFY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_AA;?></h5>
      <?php echo Lang::$word->_MOD_AM_AA_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_NOTIFY;?></h5>
      <?php echo Lang::$word->_MOD_AM_NOTIFY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CHAR;?></h5>
      <?php echo Lang::$word->_MOD_AM_CHAR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_PERPAGE;?></h5>
      <?php echo Lang::$word->_MOD_AM_PERPAGE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_WORDS;?></h5>
      <?php echo Lang::$word->_MOD_AM_WORDS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_TPL_ADM;?></h5>
      <?php echo Lang::$word->_MOD_AM_TPL_ADM_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_TPL_USR;?></h5>
      <?php echo Lang::$word->_MOD_AM_TPL_USR_T;?> </div>
  </div>
</div>
<div id="blog-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_AM_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_NAME;?></h5>
      <?php echo Lang::$word->_MOD_AM_NAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_SLUG;?></h5>
      <?php echo Lang::$word->_MOD_AM_SLUG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CATEGORY;?></h5>
      <?php echo Lang::$word->_MOD_AM_CATEGORY_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_IMAGE;?></h5>
      <?php echo Lang::$word->_MOD_AM_IMAGE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_FILE_ATT;?></h5>
      <?php echo Lang::$word->_MOD_AM_FILE_ATT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_MEMBERSHIP;?></h5>
      <?php echo Lang::$word->_MOD_AM_MEMBERSHIP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_GAL;?></h5>
      <?php echo Lang::$word->_MOD_GAL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_START;?></h5>
      <?php echo Lang::$word->_MOD_AM_START_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_TAGS;?></h5>
      <?php echo Lang::$word->_MOD_AM_TAGS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_LAYOUT;?></h5>
      <?php echo Lang::$word->_MOD_AM_LAYOUT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_KEYS;?></h5>
      <?php echo Lang::$word->_PG_KEYS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_DESC;?></h5>
      <?php echo Lang::$word->_PG_DESC_T;?> </div>
  </div>
</div>
<div id="amcats-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_AM_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CATEGORIES;?></h5>
      <?php echo Lang::$word->_MOD_AM_INFO5_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CATNAME;?></h5>
      <?php echo Lang::$word->_MOD_AM_CATNAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CATSLUG;?></h5>
      <?php echo Lang::$word->_MOD_AM_CATSLUG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_PARENT;?></h5>
      <?php echo Lang::$word->_MOD_AM_PARENT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CATNAME;?></h5>
      <?php echo Lang::$word->_MOD_AM_CATNAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CATSLUG;?></h5>
      <?php echo Lang::$word->_MOD_AM_CATSLUG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CICON;?></h5>
      <?php echo Lang::$word->_MOD_AM_CICON_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CLAYOUT;?></h5>
      <?php echo Lang::$word->_MOD_AM_LAYOUT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CIPP;?></h5>
      <?php echo Lang::$word->_MOD_AM_CIPP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_DESC;?></h5>
      <?php echo Lang::$word->_MOD_AM_DESC_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_AM_CLAYOUT;?></h5>
      <?php echo Lang::$word->_MOD_AM_LAYOUT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_KEYS;?></h5>
      <?php echo Lang::$word->_PG_KEYS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_DESC;?></h5>
      <?php echo Lang::$word->_PG_DESC_T;?> </div>
  </div>
</div>
<div id="booking-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_BM_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_BM_TITLE;?></h5>
      <?php echo Lang::$word->_MOD_BM_TITLE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_BM_SLUG;?></h5>
      <?php echo Lang::$word->_MOD_BM_SLUG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_BM_VENUE;?></h5>
      <?php echo Lang::$word->_MOD_BM_VENUE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_BM_ADDRESS;?></h5>
      <?php echo Lang::$word->_MOD_BM_ADDRESS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_BM_CAPACITY_RESTR;?></h5>
      <?php echo Lang::$word->_MOD_BM_CAPACITY_RESTR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_BM_COST;?></h5>
      <?php echo Lang::$word->_MOD_BM_COST_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_BM_DATES;?></h5>
      <?php echo Lang::$word->_MOD_BM_DATES_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_BM_IMAGE;?></h5>
      <?php echo Lang::$word->_MOD_BM_IMAGE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_BM_COLOUR;?></h5>
      <?php echo Lang::$word->_MOD_BM_COLOUR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_KEYS;?></h5>
      <?php echo Lang::$word->_PG_KEYS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_DESC;?></h5>
      <?php echo Lang::$word->_PG_DESC_T;?> </div>
  </div>
</div>
<div id="fbconfig-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_FB_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_FB_IPP;?></h5>
      <?php echo Lang::$word->_MOD_FB_IPP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_FB_HASH;?></h5>
      <?php echo Lang::$word->_MOD_FB_HASH_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_FB_SORT;?></h5>
      <?php echo Lang::$word->_MOD_FB_SORT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_FB_TEMPLATE;?></h5>
      <?php echo Lang::$word->_MOD_FB_TEMPLATE_T;?> </div>
  </div>
</div>
<div id="forum-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_FB_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_FB_NAME;?></h5>
      <?php echo Lang::$word->_MOD_FB_NAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_FB_SLUG;?></h5>
      <?php echo Lang::$word->_MOD_FB_SLUG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_FB_ACCESS;?></h5>
      <?php echo Lang::$word->_MOD_FB_ACCESS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_FB_PPOST;?></h5>
      <?php echo Lang::$word->_MOD_FB_PPOST_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_FB_ICON;?></h5>
      <?php echo Lang::$word->_MOD_FB_ICON_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_FB_SHORTDESC;?></h5>
      <?php echo Lang::$word->_MOD_FB_SHORTDESC_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_KEYS;?></h5>
      <?php echo Lang::$word->_PG_KEYS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_PG_DESC;?></h5>
      <?php echo Lang::$word->_PG_DESC_T;?> </div>
  </div>
</div>
<div id="slidecms-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_SLC_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_SLC_NAME;?></h5>
      <?php echo Lang::$word->_MOD_SLC_NAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_SLC_HEIGHT;?></h5>
      <?php echo Lang::$word->_MOD_SLC_HEIGHT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_SLC_RESMETHOD;?></h5>
      <?php echo Lang::$word->_MOD_SLC_RESMETHOD_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_SLC_TRANSDURRATION;?></h5>
      <?php echo Lang::$word->_MOD_SLC_TRANSDURRATION_T;?> </div>
  </div>
</div>
<div id="imconfig-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_IM_CONFIGHELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_IM_SEQUENCE;?></h5>
      <?php echo Lang::$word->_MOD_IM_SEQUENCE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_IM_GRACE;?></h5>
      <?php echo Lang::$word->_MOD_IM_GRACE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_IM_COPYRIGHT;?></h5>
      <?php echo Lang::$word->_MOD_IM_COPYRIGHT_T;?> </div>
  </div>
</div>
<div id="psdrive-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_PD_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PD_NAME;?></h5>
      <?php echo Lang::$word->_MOD_PD_NAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PD_TAGS;?></h5>
      <?php echo Lang::$word->_MOD_PD_TAGS_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PD_MEMBERSHIP;?></h5>
      <?php echo Lang::$word->_MOD_PD_MEMBERSHIP_T;?> </div>
  </div>
</div>
<div id="pdconfig-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_PD_CONFIGHELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PD_FILEDIR;?></h5>
      <?php echo Lang::$word->_MOD_PD_FILEDIR_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PD_LIKE;?></h5>
      <?php echo Lang::$word->_MOD_PD_LIKE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PD_FEATURED_COL;?></h5>
      <?php echo Lang::$word->_MOD_PD_FEATURED_COL_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PD_FEATURED_CAT;?></h5>
      <?php echo Lang::$word->_MOD_PD_FEATURED_CAT_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PD_ITEMPP;?></h5>
      <?php echo Lang::$word->_MOD_PD_ITEMPP_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_PD_LATEST;?></h5>
      <?php echo Lang::$word->_MOD_PD_LATEST_T;?> </div>
  </div>
</div>
<div id="tmconfig-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_TM_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_TM_MAX;?></h5>
      <?php echo Lang::$word->_MOD_TM_MAX_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_TM_LMORE;?></h5>
      <?php echo Lang::$word->_MOD_TM_LMORE_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_TM_LIMITER;?></h5>
      <?php echo Lang::$word->_MOD_TM_LIMITER_T;?> </div>
    <div class="item">
      <?php echo Lang::$word->_MOD_TM_ITEMS_T;?> </div>
  </div>
</div>

<div id="tline-help">
  <div class="header">
    <p><?php echo Lang::$word->_MOD_TM_HELP;?></p>
    <a class="helper"><i class="icon reorder"></i></a></div>
  <div class="tubi-content" id="help-items">
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_TM_IIMG;?></h5>
      <?php echo Lang::$word->_MOD_TM_IIMG_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_TM_READ_MOREU;?></h5>
      <?php echo Lang::$word->_MOD_TM_READ_MOREU_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_TM_IFRAME;?></h5>
      <?php echo Lang::$word->_MOD_TM_IFRAME_T;?> </div>
    <div class="item">
      <h5><?php echo Lang::$word->_MOD_TM_IFRAMEH;?></h5>
      <?php echo Lang::$word->_MOD_TM_IFRAMEH_T;?> </div>
  </div>
</div>