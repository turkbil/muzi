<?php
  /**
   * Search Template
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: login.tpl.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
  $keywords = post('keywords');
  $keywords = str_replace("%", '', $keywords);
  $keywords = sanitize($keywords, 15, false);
  $keywords = $db->escape($keywords);

  $contentdata = $db->fetch_all("SELECT title" . Lang::$lang . " as pagetitle, body" . Lang::$lang . ", slug" 
  . "\n FROM pages" 
  . "\n WHERE title" . Lang::$lang . " LIKE '%" . $keywords . "%' or body" . Lang::$lang . " LIKE '%" . $keywords . "%'" 
  . "\n ORDER BY created DESC LIMIT 10");

  if ($db->numrows($db->query("SHOW TABLES LIKE 'mod_blog'"))) {
      $blogdata = $db->fetch_all("SELECT *" 
	  . "\n FROM mod_blog" 
	  . "\n WHERE title" . Lang::$lang . " LIKE '%" . $keywords . "%' or body" . Lang::$lang . " LIKE '%" . $keywords . "%'" 
	  . "\n ORDER BY id LIMIT 10");
  } else {
      $blogdata = false;
  }

  if ($db->numrows($db->query("SHOW TABLES LIKE 'mod_digishop'"))) {
      $digishopdata = $db->fetch_all("SELECT *" 
	  . "\n FROM mod_digishop" 
	  . "\n WHERE title" . Lang::$lang . " LIKE '%" . $keywords . "%' or body" . Lang::$lang . " LIKE '%" . $keywords . "%'" 
	  . "\n ORDER BY id LIMIT 10");
  } else {
      $digishopdata = false;
  }

  if ($db->numrows($db->query("SHOW TABLES LIKE 'mod_portfolio'"))) {
      $portadata = $db->fetch_all("SELECT *" 
	  . "\n FROM mod_portfolio" 
	  . "\n WHERE title" . Lang::$lang . " LIKE '%" . $keywords . "%' or body" . Lang::$lang . " LIKE '%" . $keywords . "%'" 
	  . "\n ORDER BY id LIMIT 10");
  } else {
      $portadata = false;
  }
  
  if ($db->numrows($db->query("SHOW TABLES LIKE 'mod_psdrive'"))) {
      $psdrivedata = $db->fetch_all("SELECT *" 
	  . "\n FROM mod_psdrive" 
	  . "\n WHERE title" . Lang::$lang . " LIKE '%" . $keywords . "%' or body" . Lang::$lang . " LIKE '%" . $keywords . "%'" 
	  . "\n ORDER BY id LIMIT 10");
  } else {
      $psdrivedata = false;
  }
?>
<?php if (!$keywords || strlen($keywords = trim($keywords)) == 0 || strlen($keywords) < 3):?>
<?php Filter::msgAlert(Lang::$word->_SR_SEARCH_EMPTY2);?>
<?php elseif(!$contentdata and !$blogdata and !$digishopdata and !$portadata and !$psdrivedata):?>
<?php Filter::msgAlert(Lang::$word->_SR_SEARCH_EMPTY . '<span class="tubi black label">'.$keywords.'</span>' . Lang::$word->_SR_SEARCH_EMPTY1);?>
<?php else:?>
<h1><span><?php echo Lang::$word->_SR_SEARCH2 . $keywords;?></span></h1>
<?php $i = 0; $color1 = "search-even"; $color2 = "search-odd";?>
<?php foreach($contentdata as $cdata):?>
	  <?php
	      $newbody = '';
	      $body = $cdata->{'body'.Lang::$lang};
      	  $pattern = "/%%(.*?)%%/";
		  preg_match_all($pattern, $body, $matches);
		  if ($matches[1]) {
		    $body = str_replace($matches[0], '', $body);
			$string = cleanSanitize($body, 300);
			$newbody = preg_replace("|($keywords)|Ui", "<span class=\"tubi warning label\">$1</span>", $string);
		  }
      ?>
<?php $i++;?>
<div class="<?php echo(($i % 2 == 0) ? $color1 : $color2);?>"><a href="<?php echo Url::Page($cdata->slug);?>"><strong><?php echo $i.'. '.$cdata->pagetitle;?></strong></a>
  <p><?php echo $newbody;?></p>
  <hr />
</div>
<?php endforeach;?>
<?php unset($cdata,$link,$i,$contentdata);?>
<?php if($blogdata):?>
<h1><span><?php echo getValue('title'.Lang::$lang, 'modules', 'modalias = "blog"');?></span></h1>
<?php $i = 0; $color1 = "search-even"; $color2 = "search-odd";;?>
<?php foreach($blogdata as $adata):?>
<?php
  $string = cleanSanitize($adata->{'body'.Lang::$lang}, 300);
  $newbody = preg_replace("|($keywords)|Ui", "<span class=\"tubi warning label\">$1</span>", $string);
?>
<?php $i++;?>
<div class="<?php echo(($i % 2 == 0) ? $color1 : $color2);?>"><a href="<?php echo Url::Blog("item", $adata->slug);?>"><strong><?php echo $i.'. '.$adata->{'title'.Lang::$lang};?></strong></a>
  <div><?php echo $newbody;?></div>
  <hr />
</div>
<?php endforeach;?>
<?php unset($adata,$link,$i,$blogdata);?>
<?php endif;?>
<?php if($digishopdata):?>
<h1><span><?php echo getValue('title'.Lang::$lang, 'modules', 'modalias = "digishop"');?></span></h1>
<?php $i = 0; $color1 = "search-even"; $color2 = "search-odd";;?>
<?php foreach($digishopdata as $sdata):?>
<?php
  $string = cleanSanitize($sdata->{'body'.Lang::$lang}, 300);
  $newbody = preg_replace("|($keywords)|Ui", "<span class=\"tubi warning label\">$1</span>", $string);
?>
<?php $i++;?>
<div class="<?php echo(($i % 2 == 0) ? $color1 : $color2);?>"><a href="<?php echo Url::Digishop("item", $sdata->slug);?>"><strong><?php echo $i.'. '.$sdata->{'title'.Lang::$lang};?></strong></a>
  <div><?php echo $newbody;?></div>
  <hr />
</div>
<?php endforeach;?>
<?php unset($sdata,$link,$i,$digishopdata);?>
<?php endif;?>
<?php if($portadata):?>
<h1><span><?php echo getValue('title'.Lang::$lang, 'modules', 'modalias = "portfolio"');?></span></h1>
<?php $i = 0; $color1 = "search-even"; $color2 = "search-odd";;?>
<?php foreach($portadata as $pdata):?>
<?php
  $string = cleanSanitize($pdata->{'body'.Lang::$lang}, 300);
  $newbody = preg_replace("|($keywords)|Ui", "<span class=\"tubi warning label\">$1</span>", $string);
?>
<?php $i++;?>
<div class="<?php echo(($i % 2 == 0) ? $color1 : $color2);?>"><a href="<?php echo Url::Portfolio("item", $pdata->slug);?>"><strong><?php echo $i.'. '.$pdata->{'title'.Lang::$lang};?></strong></a>
  <div><?php echo $newbody;?></div>
  <hr />
</div>
<?php endforeach;?>
<?php unset($pdata,$link,$i,$portadata);?>
<?php endif;?>
<?php if($psdrivedata):?>
<h1><span><?php echo getValue('title'.Lang::$lang, 'modules', 'modalias = "psdrive"');?></span></h1>
<?php $i = 0; $color1 = "search-even"; $color2 = "search-odd";;?>
<?php foreach($psdrivedata as $pdata):?>
<?php
  $string = cleanSanitize($pdata->{'body'.Lang::$lang}, 300);
  $newbody = preg_replace("|($keywords)|Ui", "<span class=\"tubi warning label\">$1</span>", $string);
?>
<?php $i++;?>
<div class="<?php echo(($i % 2 == 0) ? $color1 : $color2);?>"><a href="<?php echo Url::Psdrive("item", $pdata->slug);?>"><strong><?php echo $i.'. '.$pdata->{'title'.Lang::$lang};?></strong></a>
  <div><?php echo $newbody;?></div>
  <hr />
</div>
<?php endforeach;?>
<?php unset($pdata,$link,$i,$psdrivedata);?>
<?php endif;?>
<?php endif;?>