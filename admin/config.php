<?php
  /**
   * Configuration
   *
   * @yazilim Turk Bilisim
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: config.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Bu alana giris yetkiniz bulunmuyor.');
    
  if(!$user->getAcl("Configuration")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>

<div class="tubi icon heading message mortar"><a class="helper tubi top right info corner label" data-help="configure"><i class="icon help"></i></a> <i class="setting icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_CG_TITLE1;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_CONF;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_CG_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_CG_SUBTITLE1;?></div>
    <ul class="idTabs" id="tabs">
      <li><a data-tab="#site"><?php echo Lang::$word->_SITEAYARLAR;?></a></li>
      <li><a data-tab="#ana"><?php echo Lang::$word->_TEMEL;?></a></li>
      <li><a data-tab="#ek"><?php echo Lang::$word->_YARD;?></a></li>
    </ul>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div id="site" class="tab_content">
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_SITENAME;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="site_name" type="text" value="<?php echo $core->site_name;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_COMPANY;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="company" type="text" value="<?php echo $core->company;?>">
            </label>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_WEBEMAIL;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="site_email" type="text" value="<?php echo $core->site_email;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CF_PHONE;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="telefon" type="text" value="<?php echo $core->telefon;?>">
            </label>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><i class="facebook sign icon"></i> Facebook</label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="facebook" type="text" value="<?php echo $core->facebook;?>">
            </label>
          </div>
          <div class="field">
            <label><i class="twitter sign icon"></i> Twitter</label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="twitter" type="text" value="<?php echo $core->twitter;?>">
            </label>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><i class="instagram icon"></i> Instagram</label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="instagram" type="text" value="<?php echo $core->instagram;?>">
            </label>
          </div>
          <div class="field">
            <label><i class="linkedin sign icon"></i> Linkedin</label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="linkedin" type="text" value="<?php echo $core->linkedin;?>">
            </label>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><i class="google plus sign icon"></i> Google +</label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="googleplus" type="text" value="<?php echo $core->googleplus;?>">
            </label>
          </div>
          <div class="field">
            <label><i class="foursquare icon"></i> Foursquare</label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="foursquare" type="text" value="<?php echo $core->foursquare;?>">
            </label>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><i class="youtube sign icon"></i> Youtube</label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="youtube" type="text" value="<?php echo $core->youtube;?>">
            </label>
          </div>
          <div class="field">
            <label><i class="pinterest sign icon"></i> Pinterest</label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="pinterest" type="text" value="<?php echo $core->pinterest;?>">
            </label>
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_GA;?></label>
            <textarea name="analytics"><?php echo $core->analytics;?></textarea>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_METAKEY;?></label>
            <textarea name="metakeys"><?php echo $core->metakeys;?></textarea>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_METADESC;?></label>
            <textarea name="metadesc"><?php echo $core->metadesc;?></textarea>
          </div>
        </div>
      </div>
      <div id="ana" class="tab_content">
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_THEME;?></label>
            <select name="theme" id="themeswitch">
              <option value=""><?php echo Lang::$word->_CG_THEME_SEL;?></option>
              <?php getTemplates(BASEPATH."/theme/", $core->theme)?>
            </select>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_THEME_VAR;?></label>
            <div id="themeOptions"></div>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="three fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_LOGO;?></label>
            <label class="input">
              <input type="file" name="logo" class="filefield">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_LOGO_DEL;?></label>
            <div class="inline-group">
              <label class="checkbox">
                <input name="dellogo" type="checkbox" value="1">
                <i></i><?php echo Lang::$word->_YES;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_EDITOR;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="editor" type="radio" value="1" <?php getChecked($core->editor, 1); ?> >
                <i></i>Redactor</label>
              <label class="radio">
                <input name="editor" type="radio" value="2" <?php getChecked($core->editor, 2); ?> >
                <i></i>TinyMCE</label>
            </div>
          </div>
        </div>       
        <div class="tubi fitted divider"></div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_BGIMG;?></label>
            <label class="input">
              <input type="file" name="bgimg" class="filefield">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_BGIMGOPT;?></label>
            <div class="inline-group">
              <label class="checkbox">
                <input name="dellbgimg" type="checkbox" value="1">
                <i></i><?php echo Lang::$word->_CG_DELBGIMG;?></label>
            </div>
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_BGREP;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="repbg" type="radio" value="1" <?php getChecked($core->repbg, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="repbg" type="radio" value="0" <?php getChecked($core->repbg, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_BGALIGN;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="bgalign" type="radio" value="left" <?php getChecked($core->bgalign, "left"); ?> >
                <i></i><?php echo Lang::$word->_CG_BGALIGN_L;?></label>
              <label class="radio">
                <input name="bgalign" type="radio" value="right" <?php getChecked($core->bgalign, "right"); ?> >
                <i></i><?php echo Lang::$word->_CG_BGALIGN_R;?></label>
              <label class="radio">
                <input name="bgalign" type="radio" value="center" <?php getChecked($core->bgalign, "center"); ?> >
                <i></i><?php echo Lang::$word->_CG_BGALIGN_C;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_BGFIXED;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="bgfixed" type="radio" value="1" <?php getChecked($core->bgfixed, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="bgfixed" type="radio" value="0" <?php getChecked($core->bgfixed, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
      </div>
      <div id="ek" class="tab_content">
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_WEBURL;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="site_url" type="text" value="<?php echo $core->site_url;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_DIR;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="site_dir" type="text" value="<?php echo $core->site_dir;?>">
            </label>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="three fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_SHOW_LOGIN;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="showlogin" type="radio" value="1" <?php getChecked($core->showlogin, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="showlogin" type="radio" value="0" <?php getChecked($core->showlogin, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_SHOW_SEARCH;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="showsearch" type="radio" value="1" <?php getChecked($core->showsearch, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="showsearch" type="radio" value="0" <?php getChecked($core->showsearch, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_SHOW_CRUMBS;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="showcrumbs" type="radio" value="1" <?php getChecked($core->showcrumbs, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="showcrumbs" type="radio" value="0" <?php getChecked($core->showcrumbs, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_LANG_SHOW;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_lang" type="radio" value="1" <?php getChecked($core->show_lang, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_lang" type="radio" value="0" <?php getChecked($core->show_lang, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_EUCOOKIE;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="eucookie" type="radio" value="1" <?php getChecked($core->eucookie, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="eucookie" type="radio" value="0" <?php getChecked($core->eucookie, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_OFFLINE;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="offline" type="radio" onclick="$('.offline-data').show();" value="1" <?php getChecked($core->offline, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="offline" type="radio" onclick="$('.offline-data').hide();" value="0" <?php getChecked($core->offline, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
        <div class="two fields tubi positive segment offline-data"<?php echo ($core->offline) ? "" : " style=\"display:none\""; ?>>
          <div class="field">
            <label><?php echo Lang::$word->_CG_OFFLINE_DATE;?></label>
            <label class="input"><i class="icon-prepend icon calendar"></i> <i class="icon-append icon asterisk"></i>
              <input name="offline_d" data-datepicker="true" type="text" value="<?php echo $core->offline_d;?>">
            </label>
            <div class="small-top-space"></div>
            <label><?php echo Lang::$word->_CG_OFFLINE_TIME;?></label>
            <label class="input"><i class="icon-prepend icon time"></i> <i class="icon-append icon asterisk"></i>
              <input name="offline_t" data-timepicker="true" type="text" value="<?php echo $core->offline_t;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_OFFLINE_MSG;?></label>
            <textarea class="altpost" name="offline_msg"><?php echo $core->offline_msg;?></textarea>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="three fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_SHORTDATE;?></label>
            <select name="short_date">
              <?php echo Core::getShortDate($core->short_date);?>
            </select>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_LONGDATE;?></label>
            <select name="long_date">
              <?php echo Core::getLongDate($core->long_date);?>
            </select>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_TIMEFORMAT;?></label>
            <select name="time_format">
              <?php echo Core::getTimeFormat($core->time_format);?>
            </select>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_DTZ;?></label>
            <?php echo $core->getTimezones();?> </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_LOCALES;?></label>
            <select name="locale">
              <?php echo $core->getlocaleList();?>
            </select>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_WEEKSTART;?></label>
            <select name="weekstart">
              <?php echo Core::weekList(true, true, $core->weekstart);?>
            </select>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_LANG;?></label>
            <select name="lang">
              <?php foreach($langlist as $lang):?>
              <?php $sel = ($core->lang == $lang->flag) ? ' selected="selected"' : '';?>
              <option value="<?php echo $lang->flag;?>"<?php echo $sel;?>><?php echo $lang->name;?></option>
              <?php endforeach;?>
            </select>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_THUMB_WH;?></label>
            <div class="inline field">
              <label class="input"> <i class="icon-append icon asterisk"></i>
                <input name="thumb_w" type="text" value="<?php echo $core->thumb_w;?>">
              </label>
              /
              <label class="input"> <i class="icon-append icon asterisk"></i>
                <input name="thumb_h" type="text" value="<?php echo $core->thumb_h;?>">
              </label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_IMG_WH;?></label>
            <div class="inline field">
              <label class="input"> <i class="icon-append icon asterisk"></i>
                <input name="img_w" type="text" value="<?php echo $core->img_w;?>">
              </label>
              /
              <label class="input"> <i class="icon-append icon asterisk"></i>
                <input name="img_h" type="text" value="<?php echo $core->img_h;?>">
              </label>
            </div>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_AVATAR_WH;?></label>
            <div class="inline field">
              <label class="input"> <i class="icon-append icon asterisk"></i>
                <input name="avatar_w" type="text" value="<?php echo $core->avatar_w;?>">
              </label>
              /
              <label class="input"> <i class="icon-append icon asterisk"></i>
                <input name="avatar_h" type="text" value="<?php echo $core->avatar_h;?>">
              </label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_PERPAGE;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="perpage" type="text" value="<?php echo $core->perpage;?>">
            </label>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="four fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_CURRENCY;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="currency" type="text" value="<?php echo $core->currency;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_CUR_SYMBOL;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="cur_symbol" type="text" value="<?php echo $core->cur_symbol;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_CUR_TSEP;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="tsep" type="text" value="<?php echo $core->tsep;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_CUR_DSEP;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="dsep" type="text" value="<?php echo $core->dsep;?>">
            </label>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="four fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_REGVERIFY;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="reg_verify" type="radio" value="1" <?php getChecked($core->reg_verify, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="reg_verify" type="radio" value="0" <?php getChecked($core->reg_verify, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_AUTOVERIFY;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="auto_verify" type="radio" value="1" <?php getChecked($core->auto_verify, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="auto_verify" type="radio" value="0" <?php getChecked($core->auto_verify, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_REGALOWED;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="reg_allowed" type="radio" value="1" <?php getChecked($core->reg_allowed, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="reg_allowed" type="radio" value="0" <?php getChecked($core->reg_allowed, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_NOTIFY_ADMIN;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="notify_admin" type="radio" value="1" <?php getChecked($core->notify_admin, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="notify_admin" type="radio" value="0" <?php getChecked($core->notify_admin, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
        <div class="four fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_USERLIMIT;?></label>
            <label class="input">
              <input name="user_limit" type="text" value="<?php echo $core->user_limit;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_LOGIN_ATTEMPT;?></label>
            <label class="input">
              <input name="attempt" type="text" value="<?php echo $core->attempt;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_LOGIN_TIME;?></label>
            <label class="input">
              <input name="flood" type="text" value="<?php echo $core->flood;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_CG_LOG_ON;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="logging" type="radio" value="1" <?php getChecked($core->logging, 1); ?> >
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="logging" type="radio" value="0" <?php getChecked($core->logging, 0); ?> >
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_CG_MAILER;?></label>
            <select name="mailer" id="mailerchange" class="selectbox">
              <option value="PHP" <?php if ($core->mailer == "PHP") echo "selected=\"selected\"";?>>PHP Mailer</option>
              <option value="SMAIL" <?php if ($core->mailer == "SMAIL") echo "selected=\"selected\"";?>>Sendmail</option>
              <option value="SMTP" <?php if ($core->mailer == "SMTP") echo "selected=\"selected\"";?>>SMTP Mailer</option>
            </select>
          </div>
          <div class="field showsmail">
            <label><?php echo Lang::$word->_CG_SMAILPATH;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input name="sendmail" value="<?php echo $core->sendmail;?>" type="text">
            </label>
          </div>
        </div>
        <div class="showsmtp">
          <div class="tubi thin attached divider"></div>
          <div class="two fields">
            <div class="field">
              <label><?php echo Lang::$word->_CG_SMTP_HOST;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i>
                <input name="smtp_host" value="<?php echo $core->smtp_host;?>" placeholder="<?php echo Lang::$word->_CG_SMTP_HOST;?>" type="text">
              </label>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_CG_SMTP_USER;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i>
                <input name="smtp_user" value="<?php echo $core->smtp_user;?>" placeholder="<?php echo Lang::$word->_CG_SMTP_USER;?>" type="text">
              </label>
            </div>
          </div>
          <div class="three fields">
            <div class="field">
              <label><?php echo Lang::$word->_CG_SMTP_PASS;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i>
                <input name="smtp_pass" value="<?php echo $core->smtp_pass;?>" placeholder="<?php echo Lang::$word->_CG_SMTP_PASS;?>" type="text">
              </label>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_CG_SMTP_PORT;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i>
                <input name="smtp_port" value="<?php echo $core->smtp_port;?>" placeholder="<?php echo Lang::$word->_CG_SMTP_PORT;?>" type="text">
              </label>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_CG_SMTP_SSL;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="is_ssl" type="radio" value="1" <?php getChecked($core->is_ssl, 1); ?>>
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="is_ssl" type="radio" value="0" <?php getChecked($core->is_ssl, 0); ?>>
                  <i></i> <?php echo Lang::$word->_NO;?> </label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_CG_UPDATE;?></button>
      <input name="processConfig" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript">
// <![CDATA[
 function loadThemeOpts() {
     $.ajax({
         type: 'post',
         url: "controller.php",
         data: 'themeoption=<?php echo $core->theme;?>',
         cache: false,
         success: function (html) {
             $("#themeOptions").html(html);
         }
     });
 }
 $(document).ready(function () {
     var res2 = '<?php echo $core->mailer;?>';
     (res2 == "SMTP") ? $('.showsmtp').show() : $('.showsmtp').hide();
     $('#mailerchange').change(function () {
         var res = $("#mailerchange option:selected").val();
         (res == "SMTP") ? $('.showsmtp').show() : $('.showsmtp').hide();
     });

     (res2 == "SMAIL") ? $('.showsmail').show() : $('.showsmail').hide();
     $('#mailerchange').change(function () {
         var res = $("#mailerchange option:selected").val();
         (res == "SMAIL") ? $('.showsmail').show() : $('.showsmail').hide();
     });

     loadThemeOpts();

     $('#themeswitch').change(function () {
         var option = $(this).val();
         $.post('controller.php', {
             themeoption: option
         }, function (data) {
             $('#themeOptions').html(data);
             $("select").chosen({
                 disable_search_threshold: 10,
                 width: "100%"
             });
         });

     });
 });
// ]]>
</script>