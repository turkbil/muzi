<?php
  /**
   * Users
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: users.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Users")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php if($user->userlevel == 8 and $user->userid == 1): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;?>
<?php $row = Core::getRowById(Users::uTable, Filter::$id);?>
<?php $memrow = $member->getMemberships();?>
<div class="tubi icon heading message dust"><a class="helper tubi top right info corner label" data-help="user"><i class="icon help"></i></a> <i class="user icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_UR_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=users" class="section"><?php echo Lang::$word->_N_USERS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_UR_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_UR_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_UR_SUBTITLE1 . $row->username;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_USERNAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->username;?>" disabled="disabled" name="username">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PASSWORD;?></label>
          <input type="text" name="password">
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_UR_FNAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->fname;?>" name="fname">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_LNAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->lname;?>" name="lname">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_UR_EMAIL;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->email;?>" name="email">
          </label>
        </div>
        <div class="field">
          <div class="two fields">
            <div class="field">
              <label><?php echo Lang::$word->_UR_AVATAR;?></label>
              <label class="input">
                <input type="file" name="avatar" class="filefield">
              </label>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_UR_AVATAR;?></label>
              <div class="tubi avatar image">
                <?php if($row->avatar):?>
                <img src="<?php echo UPLOADURL;?>avatars/<?php echo $row->avatar;?>" alt="<?php echo $user->username;?>">
                <?php else:?>
                <img src="<?php echo UPLOADURL;?>avatars/blank.png" alt="<?php echo $row->username;?>">
                <?php endif;?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php echo $content->rendertCustomFields('profile', $row->custom_fields);?>
      <div class="tubi fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MEMBERSHIP;?></label>
          <select name="membership_id">
            <option value="0"><?php echo Lang::$word->_UR_NOMEMBERSHIP;?></option>
            <?php if($memrow):?>
            <?php foreach ($memrow as $mlist):?>
            <?php $selected = ($row->membership_id == $mlist->id) ? " selected=\"selected\"" : "";?>
            <option value="<?php echo $mlist->id;?>"<?php echo $selected;?>><?php echo $mlist->{'title'.Lang::$lang};?></option>
            <?php endforeach;?>
            <?php unset($mlist);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_STATUS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="active" type="radio" value="y" <?php echo getChecked($row->active, "y");?>>
              <i></i><?php echo Lang::$word->_USER_A;?></label>
            <label class="radio">
              <input name="active" type="radio" value="n" <?php echo getChecked($row->active, "n");?>>
              <i></i><?php echo Lang::$word->_USER_I;?></label>
            <label class="radio">
              <input name="active" type="radio" value="b" <?php echo getChecked($row->active, "b");?>>
              <i></i><?php echo Lang::$word->_USER_B;?></label>
            <label class="radio">
              <input name="active" type="radio" value="t" <?php echo getChecked($row->active, "t");?>>
              <i></i><?php echo Lang::$word->_USER_P;?></label>
          </div>
        </div>
      </div>
      <?php if($user->userlevel == 9):?>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_UR_PERM;?></label>
          <?php echo $user->getPermissionList($row->access);?> </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_LEVEL;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="userlevel" type="radio" value="9" <?php echo getChecked($row->userlevel, 9);?>>
              <i></i><?php echo Lang::$word->_UR_SADMIN;?></label>
            <label class="radio">
              <input name="userlevel" type="radio" value="8" <?php echo getChecked($row->userlevel, 8);?>>
              <i></i><?php echo Lang::$word->_UR_ADMIN;?></label>
            <label class="radio">
              <input name="userlevel" type="radio" value="1" <?php echo getChecked($row->userlevel, 1);?>>
              <i></i><?php echo Lang::$word->_USER;?></label>
          </div>
        </div>
      </div>
      <?php endif;?>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_UR_DATE_REGGED;?></label>
          <input type="text" value="<?php echo Filter::dodate("long_date", $row->created);?>" name="created" disabled="disabled">
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_IS_NEWSLETTER;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="newsletter" type="radio" value="1" <?php echo getChecked($row->newsletter, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="newsletter" type="radio" value="0" <?php echo getChecked($row->newsletter, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_UR_BIO;?></label>
          <textarea name="info"><?php echo $row->info;?></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_NOTES;?></label>
          <textarea name="notes"><?php echo $row->notes;?></textarea>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_UR_LASTLOGIN;?></label>
          <input type="text" value="<?php echo Filter::dodate("long_date", $row->lastlogin);?>" name="lastlogin" disabled="disabled">
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_LASTLOGIN_IP;?></label>
          <input type="text" value="<?php echo $row->lastip;?>" name="lastip" disabled="disabled">
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_UR_UPDATE;?></button>
      <a href="index.php?do=users" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processUser" type="hidden" value="1">
      <?php if($user->userlevel == 8):?>
      <input name="userlevel" type="hidden" value="<?php echo $user->userlevel;?>">
      <?php endif;?>
      <input name="username" type="hidden" value="<?php echo $row->username;?>">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<?php $memrow = $member->getMemberships();?>
<div class="tubi icon heading message dust"><a class="helper tubi top right info corner label" data-help="user"><i class="icon help"></i></a> <i class="user icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_UR_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=users" class="section"><?php echo Lang::$word->_N_USERS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_UR_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_UR_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_UR_SUBTITLE2;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_USERNAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_USERNAME;?>" name="username">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PASSWORD;?></label>
          <input type="text" placeholder="<?php echo Lang::$word->_PASSWORD;?>" name="password">
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_UR_FNAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_UR_FNAME;?>" name="fname">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_LNAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_UR_LNAME;?>" name="lname">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_UR_EMAIL;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_UR_EMAIL;?>" name="email">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_AVATAR;?></label>
          <label class="input">
            <input type="file" name="avatar" class="filefield">
          </label>
        </div>
      </div>
      <?php echo $content->rendertCustomFields('profile', false);?>
      <div class="tubi fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MEMBERSHIP;?></label>
          <select name="membership_id">
            <option value="0"><?php echo Lang::$word->_UR_NOMEMBERSHIP;?></option>
            <?php if($memrow):?>
            <?php foreach ($memrow as $mlist):?>
            <option value="<?php echo $mlist->id;?>"><?php echo $mlist->{'title'.Lang::$lang};?></option>
            <?php endforeach;?>
            <?php unset($mlist);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_STATUS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="active" type="radio" value="y" checked="checked">
              <i></i><?php echo Lang::$word->_USER_A;?></label>
            <label class="radio">
              <input name="active" type="radio" value="n">
              <i></i><?php echo Lang::$word->_USER_I;?></label>
            <label class="radio">
              <input name="active" type="radio" value="b">
              <i></i><?php echo Lang::$word->_USER_B;?></label>
            <label class="radio">
              <input name="active" type="radio" value="t">
              <i></i><?php echo Lang::$word->_USER_P;?></label>
          </div>
        </div>
      </div>
      <?php if($user->userlevel == 9):?>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_UR_PERM;?></label>
          <?php echo $user->getPermissionList();?> </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_LEVEL;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="userlevel" type="radio" value="9">
              <i></i><?php echo Lang::$word->_UR_SADMIN;?></label>
            <label class="radio">
              <input name="userlevel" type="radio" value="8">
              <i></i><?php echo Lang::$word->_UR_ADMIN;?></label>
            <label class="radio">
              <input name="userlevel" type="radio" value="1" checked="checked">
              <i></i><?php echo Lang::$word->_USER;?></label>
          </div>
        </div>
      </div>
      <?php endif;?>
      <div class="tubi fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_UR_BIO;?></label>
          <textarea placeholder="<?php echo Lang::$word->_UR_BIO;?>" name="info"></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_NOTES;?></label>
          <textarea placeholder="<?php echo Lang::$word->_UR_NOTES;?>" name="notes"></textarea>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_UR_IS_NEWSLETTER;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="newsletter" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="newsletter" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_NOTIFY;?></label>
          <div class="inline-group">
            <label class="checkbox">
              <input name="notify" type="checkbox" value="1">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_UR_ADD;?></button>
      <a href="index.php?do=users" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processUser" type="hidden" value="1">
      <?php if($user->userlevel == 8):?>
      <input name="userlevel" type="hidden" value="1">
      <?php endif;?>
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default:?>
<?php  $userrow = $user->getUsers();?>
<div class="tubi icon heading message dust"> <i class="icon user"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_UR_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_USERS;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_UR_INFO3;?></div>
  <div class="tubi segment"> <a class="tubi icon positive button push-right" href="index.php?do=users&amp;action=add"><i class="icon add"></i> <?php echo Lang::$word->_UR_ADD;?></a>
    <div class="tubi header"><?php echo Lang::$word->_UR_SUBTITLE3;?></div>
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
              <a id="doDates" class="tubi icon button"><?php echo Lang::$word->_SR_SEARCH_GO;?></a> </div>
          </div>
          <div class="field">
            <div class="tubi icon input">
              <input type="text" name="usersearchfield" placeholder="<?php echo Lang::$word->_UR_FIND_UNAME;?>" id="searchfield"  />
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
      <div class="tubi divider"></div>
      <div id="abc"> <?php echo alphaBits('index.php?do=users', "letter");?> </div>
      <div class="tubi fitted divider"></div>
    </div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_USERNAME;?></th>
          <th data-sort="string"><?php echo Lang::$word->_UR_NAME;?></th>
          <th data-sort="string"><?php echo Lang::$word->_MEMBERSHIP;?></th>
          <th class="disabled"><?php echo Lang::$word->_UR_STATUS;?></th>
          <th class="disabled"><?php echo Lang::$word->_UR_LEVEL;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$userrow):?>
        <tr>
          <td colspan="7"><?php echo Filter::msgSingleAlert(Lang::$word->_UR_NOUSER);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($userrow as $row):?>
        <?php if($row->id == '1'): ?>
        
		<?php else: ?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php if($row->avatar):?>
            <img src="<?php echo UPLOADURL;?>avatars/<?php echo $row->avatar;?>" alt="<?php echo $user->username;?>" class="tubi image avatar"/>
            <?php else:?>
            <img src="<?php echo UPLOADURL;?>avatars/blank.png" alt="<?php echo $row->username;?>" class="tubi image avatar"/>
            <?php endif;?>
            <a href="index.php?do=newsletter&amp;emailid=<?php echo urlencode($row->email);?>"><?php echo $row->username;?></a></td>
          <td><?php echo $row->name;?></td>
          <td><?php if($row->membership_id == 0):?>
            --/--
            <?php else:?>
            <a href="index.php?do=memberships&amp;action=edit&amp;id=<?php echo $row->mid;?>"><?php echo $row->{'title'.Lang::$lang};?></a>
            <?php endif;?></td>
          <td><?php echo userStatus($row->active, $row->id);?></td>
          <td><?php echo isAdmin($row->userlevel);?></td>
          <td><a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a>
            <?php if($row->id == 1):?>
            <a><i class="rounded black inverted remove icon link"></i></a>
            <?php else:?>
            <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_USER;?>" data-option="deleteUser" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->username;?>"><i class="rounded danger inverted remove icon link"></i></a>
            <?php endif;?></td>
        </tr>
        <?php endif;?>
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
    /* == User Search == */
    $("#searchfield").on('keyup', function () {
        var srch_string = $(this).val();
        var data_string = 'userSearch=' + srch_string;
        if (srch_string.length > 4) {
            $.ajax({
                type: "post",
                url: "controller.php",
                data: data_string,
                beforeSend: function () {

                },
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