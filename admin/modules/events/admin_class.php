<?php
  /**
   * EventManager Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: class_admin.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class eventManager
  {

	  const mTable = "mod_events";
	  const dTable = "mod_events_data";
	  
      public $weekDayNameLength;
	  public $monthNameLength;
      private $arrWeekDays = array();
      private $arrMonths = array();
      private $pars = array();
      private $today = array();
      private $prevYear = array();
      private $nextYear = array();
      private $prevMonth = array();
      private $nextMonth = array();
	  public $eventMonth;
	  public $daterange;
	  
	  private static $db;


      /**
       * eventManager::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Registry::get("Database");
		  
		  $this->weekStartedDay = $this->setWeekStart();
		  $this->weekDayNameLength = "long";
		  $this->monthNameLength = "long";
		  $this->init();
          $this->eventMonth = $this->getCalDataMonth();
      }

	  /**
	   * eventManager::init()
	   * 
	   * @return
	   */
	  private function init()
	  {
          $year = (isset($_POST['year']) && $this->checkYear($_POST['year'])) ? intval($_POST['year']) : date("Y");
          $month = (isset($_POST['month']) && $this->checkMonth($_POST['month'])) ? intval($_POST['month']) : date("m");
          $day = (isset($_POST['day']) && $this->checkDay($_POST['day'])) ? intval($_POST['day']) : date("d");
		  $ldim = $this->calcDays($month, $day);
		  
		  if($day > $ldim) {
		  	$day = $ldim;
		  }
		  
          $cdate = getdate(mktime(0, 0, 0, $month, $day, $year));

          $this->pars["year"] = $cdate['year'];
          $this->pars["month"] = $this->toDecimal($cdate['mon']);
          $this->pars["nmonth"] = $cdate['mon'];
          $this->pars["month_full_name"] = $cdate['month'];
          $this->pars["day"] = $day;
          $this->today = getdate();

          $this->prevYear = getdate(mktime(0, 0, 0, $this->pars['month'], $this->pars["day"], $this->pars['year'] - 1));
          $this->nextYear = getdate(mktime(0, 0, 0, $this->pars['month'], $this->pars["day"], $this->pars['year'] + 1));
          $this->prevMonth = getdate(mktime(0, 0, 0, $this->pars['month'] - 1, $this->calcDays($this->pars['month']-1,$this->pars["day"]), $this->pars['year']));
          $this->nextMonth = getdate(mktime(0, 0, 0, $this->pars['month'] + 1, $this->calcDays($this->pars['month']+1,$this->pars["day"]), $this->pars['year']));

          $this->arrWeekDays[0] = array("mini" => Lang::$word->_SU, "short" => Lang::$word->_SUN, "long" => Lang::$word->_SUNDAY);
          $this->arrWeekDays[1] = array("mini" => Lang::$word->_MO, "short" => Lang::$word->_MON, "long" => Lang::$word->_MONDAY);
          $this->arrWeekDays[2] = array("mini" => Lang::$word->_TU, "short" => Lang::$word->_TUE, "long" => Lang::$word->_TUESDAY);
          $this->arrWeekDays[3] = array("mini" => Lang::$word->_WE, "short" => Lang::$word->_WED, "long" => Lang::$word->_WEDNESDAY);
          $this->arrWeekDays[4] = array("mini" => Lang::$word->_TH, "short" => Lang::$word->_THU, "long" => Lang::$word->_THURSDAY);
          $this->arrWeekDays[5] = array("mini" => Lang::$word->_FR, "short" => Lang::$word->_FRI, "long" => Lang::$word->_FRIDAY);
          $this->arrWeekDays[6] = array("mini" => Lang::$word->_SA, "short" => Lang::$word->_SAT, "long" => Lang::$word->_SATURDAY);
		  
		  $this->arrMonths[1] = array("short" => Lang::$word->_JA_, "long" => Lang::$word->_JAN);
		  $this->arrMonths[2] = array("short" => Lang::$word->_FE_, "long" => Lang::$word->_FEB);
		  $this->arrMonths[3] = array("short" => Lang::$word->_MA_, "long" => Lang::$word->_MAR);
		  $this->arrMonths[4] = array("short" => Lang::$word->_AP_, "long" => Lang::$word->_APR);
		  $this->arrMonths[5] = array("short" => Lang::$word->_MY_, "long" => Lang::$word->_MAY);
		  $this->arrMonths[6] = array("short" => Lang::$word->_JU_, "long" => Lang::$word->_JUN);
		  $this->arrMonths[7] = array("short" => Lang::$word->_JU_, "long" => Lang::$word->_JUL);
		  $this->arrMonths[8] = array("short" => Lang::$word->_AU_, "long" => Lang::$word->_AUG);
		  $this->arrMonths[9] = array("short" => Lang::$word->_SE_, "long" => Lang::$word->_SEP);
		  $this->arrMonths[10] = array("short" => Lang::$word->_OC_, "long" => Lang::$word->_OCT);
		  $this->arrMonths[11] = array("short" => Lang::$word->_NO_, "long" => Lang::$word->_NOV);
		  $this->arrMonths[12] = array("short" => Lang::$word->_DE_, "long" => Lang::$word->_DEC);
	  }
	 

	  /**
	   * eventManager::processEvent()
	   * 
	   * @return
	   */
	  public function processEvent()
	  {
		  
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_MOD_EM_TITLE);
		  Filter::checkPost('date_start', Lang::$word->_MOD_EM_DATE_ST);
		  Filter::checkPost('date_end', Lang::$word->_MOD_EM_TIME_ET);
		  Filter::checkPost('contact_person', Lang::$word->_MOD_EM_CONTACT);
		  Filter::checkPost('venue' . Lang::$lang, Lang::$word->_MOD_EM_VENUE);
		  Filter::checkPost('body' . Lang::$lang, Lang::$word->_MOD_EM_BODY);
			  
		  if (empty(Filter::$msgs)) {
			  
			  $data = array(
					'title'.Lang::$lang => sanitize($_POST['title'.Lang::$lang]), 
					'venue'.Lang::$lang => sanitize($_POST['venue'.Lang::$lang]),
					'date_start' => sanitize($_POST['date_start_submit']),
					'date_end' => sanitize($_POST['date_end_submit']),
					'time_start' => sanitize($_POST['time_start_submit']),
					'time_end' => sanitize($_POST['time_end_submit']),
					'contact_person' => sanitize($_POST['contact_person']),
					'user_id' => intval($_POST['user_id']),
					'contact_email' => sanitize($_POST['contact_email']),
					'contact_phone' => sanitize($_POST['contact_phone']),
					'color' => sanitize($_POST['color']),
					'body'.Lang::$lang => Filter::in_url($_POST['body'.Lang::$lang]),
					'active' => intval($_POST['active'])
			  );
			  
			  (Filter::$id) ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::mTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_MOD_EM_UPDATED : Lang::$word->_MOD_EM_ADDED;
			  
			  $dstart = explode("-",$_POST['date_start_submit']);
			  $dend = explode("-",$_POST['date_end_submit']);
			  $days_data = self::createDateRangeArray($dstart[0],$dstart[1],$dstart[2],$dend[0],$dend[1],$dend[2]);
			  
			  $edata['event_id'] = (Filter::$id) ? Filter::$id : $lastid;
			  self::$db->delete(self::dTable, "event_id=" . $edata['event_id']);
			  
			  $query = "INSERT INTO " .self::dTable." (event_id, event_date, color) VALUES ('";
			  $values = array();
	
			  foreach ($days_data as $event) {
				  $values[] = $edata['event_id'] . '\', \'' . $event . '\', \'' . $data['color'];
			  }
	
			  $query .= implode('\'), (\'', $values) . '\')';
			  self::$db->query($query);
			  
			  
			  /*
			  foreach($days_data as $event) {
				  $edata['event_date'] = $event;
				  $edata['color'] = $data['color'];
				  self::$db->insert(self::dTable, $edata);
			  }
*/
			  if (self::$db->affected()) {
				  Security::writeLog($message, "", "no", "module");
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
			  } else {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);

		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
	  
      /**
       * eventManager::renderCalendar()
       * 
	   * @param mixed $type
       * @return
       */
      public function renderCalendar($type = 'large')
      {

		  ($type == 'large') ? $this->drawMonth() : $this->drawMonthSmall();
      }


      /**
       * eventManager::checkEventsMonths()
       * 
       * @param mixed $day
       * @return
       */
      private function checkEventsMonths($day)
      {
          if ($this->eventMonth) {
              foreach ($this->eventMonth as $v) {
                  if ($day == $v->sday) {
                      return true;
                  }
              }

              return false;
          }
      }

      /**
       * eventManager::getEvent()
       * 
       * @return
       */
      public function getEvent($id)
      {
		  
		  $sql = "SELECT * FROM " . self::mTable
		  . "\n WHERE id = " . (int)$id
		  . "\n AND active = 1";
		  $row = self::$db->first($sql);
		  
		  return ($row) ? $row : 0;

      }
	  

      /**
       * eventManager::getAllEvents()
       * 
       * @return
       */
      public function getAllEvents($year, $month, $day)
      {
		  
		  $sql = "SELECT e.*, e.id as event_id, ed.id as eid, DAY(event_date) as sday, title".Lang::$lang." as etitle, DAY(date_end) as eday, ed.color"
		  . "\n FROM " . self::mTable . " as e"
		  . "\n LEFT JOIN " . self::dTable . " as ed ON ed.event_id = e.id" 
		  . "\n WHERE YEAR(event_date) = " . (int)$year
		  . "\n AND MONTH(event_date) = " . (int)$month
		  . "\n AND DAY(event_date) = " . (int)$day
		  . "\n AND active = 1"
		  . "\n ORDER BY time_start ASC";
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;

      }
	  
      /**
       * eventManager::getCalDataMonth()
       * 
       * @return
       */
      private function getCalDataMonth()
      {
		  
		  $sql = "SELECT e.*, e.id as event_id, ed.id as eid, DAY(event_date) as sday, title".Lang::$lang." as etitle, DAY(date_end) as eday, ed.color"
		  . "\n FROM " . self::mTable . " as e"
		  . "\n LEFT JOIN " . self::dTable . " as ed ON ed.event_id = e.id" 
		  . "\n WHERE YEAR(event_date) = " . $this->pars['year']
		  . "\n AND MONTH(event_date) = " . $this->pars['month']
		  . "\n AND active = 1"
		  . "\n ORDER BY time_start ASC";
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;

      }

	  /**
	   * eventManager::createDateRangeArray()
	   * 
	   * @param mixed $fromYear
	   * @param mixed $fromMonth
	   * @param mixed $fromDay
	   * @param mixed $toYear
	   * @param mixed $toMonth
	   * @param mixed $toDay
	   * @return
	   */
	  private static function createDateRangeArray($fromYear, $fromMonth, $fromDay, $toYear, $toMonth, $toDay) {
	  
		  $fromTime = mktime(0,0,0,$fromMonth,$fromDay,$fromYear);
		  $toTime = mktime(0,0,0,$toMonth,$toDay,$toYear);
		  $howManyDays = ceil(($toTime-$fromTime)/60/60/24);
		  $listdays = array();
		  
		  for ($day = 0; $day <= $howManyDays; $day++) {
			  $dateYear = date("Y", mktime(0, 0, 0, $fromMonth, ($fromDay + $day), $fromYear));
			  $dateMonth = date("m", mktime(0, 0, 0, $fromMonth, ($fromDay + $day), $fromYear));
			  $dateDay = date("d", mktime(0, 0, 0, $fromMonth, ($fromDay + $day), $fromYear));
			  $listdays[$day] = $dateYear . "-" . $dateMonth . "-" . $dateDay;
		  }
		  
		  return $listdays;
	  }

	  /**
	   * eventManager::getEvents()
	   * 
	   * @return
	   */
	  public function getEvents()
	  {

		  $counter = countEntries(self::mTable);
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
		  
		  $sql = "SELECT * FROM " . self::mTable
		  . "\n ORDER BY date_start DESC" . $pager->limit;
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }

      /**
       * eventManager::drawMonth()
       * 
       * @return
       */
	  private function drawMonth()
	  {
	
		  $is_day = 0;
		  $first_day = getdate(mktime(0, 0, 0, $this->pars['month'], 1, $this->pars['year']));
		  $last_day = getdate(mktime(0, 0, 0, $this->pars['month'] + 1, 0, $this->pars['year']));

		  echo "<div class=\"calnav clearfix\">";
		  echo "<h3><span class=\"month\">" . $this->arrMonths[$this->pars['nmonth']][$this->monthNameLength] . "</span><span class=\"year\">" . $this->pars['year'] . "</span></h3>";
		  echo "<nav>";
		  echo "<a data-id=\"" . $this->toDecimal($this->prevMonth['mon']) . ":" . $this->prevMonth['year'] . "\" class=\"changedate prev\"><i class=\"icon left arrow\"></i></a>";
		  echo "<a data-id=\"" . $this->toDecimal($this->nextMonth['mon']) . ":" . $this->nextMonth['year'] . "\" class=\"changedate next\"><i class=\"icon right arrow\"></i></a>";
		  echo "</nav>";
		  echo "</div>";
		  
		  echo "<div class=\"calheader clearfix\">";
		  for ($w = $this->weekStartedDay - 1; $w < $this->weekStartedDay + 6; $w++) {
			  echo "<div>" . $this->arrWeekDays[($w % 7)][$this->weekDayNameLength] . "</div>";
		  }
		  echo "</div>";
		  echo "<div class=\"calbody clearfix\">";

		  if ($first_day['wday'] == 0) {
			  $first_day['wday'] = 7;
		  }
		  
		 $max_days = $first_day['wday'] - ($this->weekStartedDay - 1);
		 
		  if ($max_days < 7) {
			  echo "<section class=\"section clearfix\">";
			  for ($j = 1; $j <= $max_days; $j++) {
				  echo "<div class=\"empty\">&nbsp;</div>";
			  }
			  $is_day = 0;
			  for ($k = $max_days + 1; $k <= 7; $k++) {
				  $is_day++;
				  $class = '';
				  $tclass = '';
				  $align = '';
				  if (($is_day == $this->today['mday']) && ($this->today['mon'] == $this->pars["month"])) {
					  $tclass = " today";
					  $display = $is_day;
				  }
				  $res = '';
				  if ($this->checkEventsMonths($is_day)) {
					  $data = '';
					  foreach ($this->eventMonth as $row) {
						  if ($row->sday == $is_day) {
							  $res .= "<div><a data-title=\"" . Filter::dodate("short_date", $row->date_start) . "\" data-id=\"" . $row->event_id . "\" style=\"color:" . $row->color . "\" class=\"loadevent\">" . truncate($row->etitle,15) . "</a></div>";
						  }
					  }
					  $display = $data . $is_day;
					  $class = " content";
				  } else {
					  $display = $is_day;
				  }
				  if($this->weekStartedDay == 2) {
					  if($k == 7) {
						  $n = 0;
					  } else {
						  $n = $k;
					  }

				  } else {
					  $n = $k-1;
				  }

				  $curweek = $this->arrWeekDays[$n][$this->weekDayNameLength];
				  echo "<div class=\"caldata" . $class . $tclass . "\"><span class=\"date\">" . $display . "</span><span class=\"weekday\">" . $curweek . "</span>$res</div>";

				  
			  }
			  echo "</section>";
		  }
	
		  $fullWeeks = floor(($last_day['mday'] - $is_day) / 7);
	
		  for ($i = 0; $i < $fullWeeks; $i++) {
			  echo "<section class=\"section clearfix\">";
			  for ($j = 0; $j < 7; $j++) {
				  $is_day++;
				  $class = '';
				  $tclass = '';
				  $align = '';
				  if (($is_day == $this->today['mday']) && ($this->today['mon'] == $this->pars["month"])) {
					  $tclass = " today";
					  $display = $is_day;
				  }
				  $res = '';
				  if ($this->checkEventsMonths($is_day)) {
					  $data = '';
					  foreach ($this->eventMonth as $row) {
						  if ($row->sday == $is_day) {
							  $res .= "<div><a data-title=\"" . Filter::dodate("short_date", $row->date_start) . "\" data-id=\"" . $row->event_id . "\" style=\"color:" . $row->color . "\" class=\"loadevent\">" . truncate($row->etitle,15) . "</a></div>";
						  }
					  }
					  $display = $data . $is_day;
					  $class = " content";
				  } else {
					  $display = $is_day;
				  }
				  if($this->weekStartedDay == 2) {
					  if($j == 6) {
						  $n = 0;
					  } else {
						  $n = $j+1;
					  }

				  } else {
					  $n = $j;
				  }
				  
				  $curweek = $this->arrWeekDays[($n)][$this->weekDayNameLength];
				  echo "<div class=\"caldata" . $class . $tclass . "\"><span class=\"date\">" . $display . "</span><span class=\"weekday\">" . $curweek . "</span>$res</div>";
			  }
			  echo "</section>";
		  }


		  if ($is_day < $last_day['mday']) {
			  echo "<section class=\"section clearfix\">";
			  for ($i = 0; $i < 7; $i++) {
				  $is_day++;
				  $class = '';
				  $tclass = '';
				  $align = '';
				  if (($is_day == $this->today['mday']) && ($this->today['mon'] == $this->pars["month"])) {
					  $tclass = " today";
					  $display = $is_day;
				  }
				  
				  $res = '';
				  if ($this->checkEventsMonths($is_day)) {
					  $data = '';
					  foreach ($this->eventMonth as $row) {
						  if ($row->sday == $is_day) {
							  $res .= "<div><a data-title=\"" . Filter::dodate("short_date", $row->date_start) . "\" data-id=\"" . $row->event_id . "\" class=\"loadevent\" style=\"color:" . $row->color . "\">" . truncate($row->etitle,15) . "</a></div>";
						  }

					  }
					  $display = $data . $is_day;
					  $class = " content";
				  } else {
					  $display = $is_day;
				  }
				  if($this->weekStartedDay == 2) {
					  if($i == 6) {
						  $n = 0;
					  } else {
						  $n = $i+1;
					  }

				  } else {
					  $n = $i;
				  }
				$curweek = $this->arrWeekDays[$n][$this->weekDayNameLength]; 
				echo ($is_day <= $last_day['mday']) ? "<div class=\"caldata" . $class . $tclass . "\"><span class=\"date\">" . $display . "</span><span class=\"weekday\">$curweek</span>$res</div>" : "<div class=\"empty\">&nbsp;</div>";  
			  }
			  echo "</section>";
		  }

		  echo "</div>";
	
	  }
	  
      /**
       * eventManager::drawMonthTable()
       * 
       * @return
       */
	  private function drawMonthTable()
	  {
		  global $db, $core;
	
		  $is_day = 0;
		  $first_day = getdate(mktime(0, 0, 0, $this->pars['month'], 1, $this->pars['year']));
		  $last_day = getdate(mktime(0, 0, 0, $this->pars['month'] + 1, 0, $this->pars['year']));
	
		  echo "<table class=\"month\">";
		  echo "<thead>";
		  echo "<tr>";
		  echo " <td><a href=\"javascript:void(0);\" id=\"item_" . $this->toDecimal($this->prevMonth['mon']) . ":" . $this->prevMonth['year'] . "\" class=\"changedate prev\"></a></td>";
		  echo "<td colspan=\"5\">" . $this->arrMonths[$this->pars['nmonth']][$this->monthNameLength] . " - " . $this->pars['year'] . "</td>";
		  echo "<td><a href=\"javascript:void(0);\" id=\"item_" . $this->toDecimal($this->nextMonth['mon']) . ":" . $this->nextMonth['year'] . "\" class=\"changedate next\"></a></td>";
		  echo "</tr>";
		  echo "<tr>";
		  for ($i = $this->weekStartedDay - 1; $i < $this->weekStartedDay + 6; $i++) {
			  echo "<th>" . $this->arrWeekDays[($i % 7)][$this->weekDayNameLength] . "</th>";
		  }
		  echo "</tr>";
		  echo "</thead>";
		  echo "<tbody>";
	
		  if ($first_day['wday'] == 0) {
			  $first_day['wday'] = 7;
		  }
		  $max_days = $first_day['wday'] - ($this->weekStartedDay - 1);
		  if ($max_days < 7) {
			  echo "<tr>";
			  for ($i = 1; $i <= $max_days; $i++) {
				  echo "<td class=\"empty\">&nbsp;</td>";
			  }
			  $is_day = 0;
			  for ($i = $max_days + 1; $i <= 7; $i++) {
				  $is_day++;
				  $class = '';
				  $tclass = '';
				  $align = '';
				  if (($is_day == $this->today['mday']) && ($this->today['mon'] == $this->pars["month"])) {
					  $tclass = " today";
					  $display = $is_day;
				  }
				  
				  if ($this->checkEventsMonths($is_day)) {
					  $res = '';
					  $data = '';
					  foreach ($this->eventMonth as $row) {
						  if ($row->sday == $is_day) {
							  $res .= "<small><span style=\"background-color:" . $row->color . "\"></span><a href=\"javascript:void(0);\" class=\"loadevent\" id=\"eventid_" . $row->eid . "\">" . sanitize($row->etitle, 25) . "</a></small>\n";

							  $data .= '<div class="event-wrapper" id="eid_' . $row->eid . '" style="display:none" title="' . $row->{'title' . Lang::$lang} . '">';
							  $data .= '<div class="event-list">';
							  $data .= '<h3 class="event-title"><span>' . Lang::$word->_MOD_EM_TSE . ': ' . $row->stime . '/' . $row->etime . '</span>' . $row->{'title' . Lang::$lang} . '</h3>';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<h6 class="event-venue">' . $row->{'venue' . Lang::$lang} . '</h6>';
							  $data .= "<hr />";
							  $data .= '<div class="event-desc">' . cleanOut(Filter::out_url($row->{'body' . Lang::$lang})) . '</div>';

							  $data .= '<span class="contact-info-toggle">' . Lang::$word->_MOD_EM_CONTACT . '</span>';
							  $data .= '<div class="event-contact">';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<div>' . $row->contact_person . '</div>';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<div>' . $row->contact_email . '</div>';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<div>' . $row->contact_phone . '</div>';
							  $data .= '</div>';
							  $data .= '</div>';
							  $data .= '</div>';
						  }

					  }
					  $display = $data . "<div><span>" . $is_day . "</span>" . $res . "</div>";
					  $class = " events";
					  $align = " valign=\"top\"";
				  } else {
					  $display = $is_day;
				  }
				  echo "<td class=\"caldata" . $class . $tclass . "\"" . $align . ">" . $display . "</td>";
			  }
			  echo "</tr>";
		  }
	
		  $fullWeeks = floor(($last_day['mday'] - $is_day) / 7);
	
		  for ($i = 0; $i < $fullWeeks; $i++) {
			  echo "<tr>";
			  for ($j = 0; $j < 7; $j++) {
				  $is_day++;
				  $class = '';
				  $tclass = '';
				  $align = '';
				  if (($is_day == $this->today['mday']) && ($this->today['mon'] == $this->pars["month"])) {
					  $tclass = " today";
					  $display = $is_day;
				  }
				  
				  if ($this->checkEventsMonths($is_day)) {
					  $res = '';
					  $data = '';
					  foreach ($this->eventMonth as $row) {
						  if ($row->sday == $is_day) {
							  $res .= "<small><span style=\"background-color:" . $row->color . "\"></span><a href=\"javascript:void(0);\" class=\"loadevent\" id=\"eventid_" . $row->eid . "\">" . sanitize($row->etitle, 25) . "</a></small>\n";

							  $data .= '<div class="event-wrapper" id="eid_' . $row->eid . '" style="display:none" title="' . $row->{'title' . Lang::$lang} . '">';
							  $data .= '<div class="event-list">';
							  $data .= '<h3 class="event-title"><span>' . Lang::$word->_MOD_EM_TSE . ': ' . $row->stime . '/' . $row->etime . '</span>' . $row->{'title' . Lang::$lang} . '</h3>';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<h6 class="event-venue">' . $row->{'venue' . Lang::$lang} . '</h6>';
							  $data .= "<hr />";
							  $data .= '<div class="event-desc">' . cleanOut($core->out_url($row->{'body' . Lang::$lang})) . '</div>';

							  $data .= '<span class="contact-info-toggle">' . Lang::$word->_MOD_EM_CONTACT . '</span>';
							  $data .= '<div class="event-contact">';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<div>' . $row->contact_person . '</div>';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<div>' . $row->contact_email . '</div>';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<div>' . $row->contact_phone . '</div>';
							  $data .= '</div>';
							  $data .= '</div>';
							  $data .= '</div>';
						  }

					  }
					  $display = $data . "<div><span>" . $is_day . "</span>" . $res . "</div>";
					  $class = " events";
					  $align = " valign=\"top\"";
				  } else {
					  $display = $is_day;
				  }
				  echo "<td class=\"caldata" . $class . $tclass . "\"" . $align . ">" . $display . "</td>";
			  }
			  echo "</tr>";
		  }
	
		  if ($is_day < $last_day['mday']) {
			  echo "<tr>";
			  for ($i = 0; $i < 7; $i++) {
				  $is_day++;
				  $class = '';
				  $tclass = '';
				  $align = '';
				  if (($is_day == $this->today['mday']) && ($this->today['mon'] == $this->pars["month"])) {
					  $tclass = " today";
					  $display = $is_day;
				  }
				  if ($this->checkEventsMonths($is_day)) {
					  $res = '';
					  $data = '';
					  foreach ($this->eventMonth as $row) {
						  if ($row->sday == $is_day) {
							  $res .= "<small><span style=\"background-color:" . $row->color . "\"></span><a href=\"javascript:void(0);\" class=\"loadevent\" id=\"eventid_" . $row->eid . "\">" . sanitize($row->etitle, 25) . "</a></small>\n";

							  $data .= '<div class="event-wrapper" id="eid_' . $row->eid . '" style="display:none" title="' . $row->{'title' . Lang::$lang} . '">';
							  $data .= '<div class="event-list">';
							  $data .= '<h3 class="event-title"><span>' . Lang::$word->_MOD_EM_TSE . ': ' . $row->stime . '/' . $row->etime . '</span>' . $row->{'title' . Lang::$lang} . '</h3>';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<h6 class="event-venue">' . $row->{'venue' . Lang::$lang} . '</h6>';
							  $data .= "<hr />";
							  $data .= '<div class="event-desc">' . cleanOut($core->out_url($row->{'body' . Lang::$lang})) . '</div>';

							  $data .= '<span class="contact-info-toggle">' . Lang::$word->_MOD_EM_CONTACT . '</span>';
							  $data .= '<div class="event-contact">';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<div>' . $row->contact_person . '</div>';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<div>' . $row->contact_email . '</div>';
							  if ($row->{'venue' . Lang::$lang})
								  $data .= '<div>' . $row->contact_phone . '</div>';
							  $data .= '</div>';
							  $data .= '</div>';
							  $data .= '</div>';
						  }

					  }
					  $display = $data . "<div><span>" . $is_day . "</span>" . $res . "</div>";
					  $class = " events";
					  $align = " valign=\"top\"";
				  } else {
					  $display = $is_day;
				  }
				  
				echo ($is_day <= $last_day['mday']) ? "<td class=\"caldata" . $class . $tclass . "\"" . $align . ">" . $display . "</td>" : "<td class=\"empty\">&nbsp;</td>";  
			  }
			  echo "</tr>";
		  }
		  echo "</tbody>";
		  echo "</table>";
	
	  }

      /**
       * eventManager::DrawMonthSmall()
       * 
       * @return
       */
	  private function drawMonthSmall()
	  {
	
		  $is_day = 0;
		  $first_day = getdate(mktime(0, 0, 0, $this->pars['month'], 1, $this->pars['year']));
		  $last_day = getdate(mktime(0, 0, 0, $this->pars['month'] + 1, 0, $this->pars['year']));
	
		  echo "<table class=\"small-calendar\">";
		  echo "<thead>";
		  echo "<tr>";
		  echo "<td><a data-m=\"" . $this->toDecimal($this->prevMonth['mon']) . "\" data-y=\"" . $this->prevMonth['year'] . "\" class=\"changedate prev\"></a></td>";
		  echo "<td colspan=\"5\"><span class=\"year\">" . $this->pars['year'] . "</span><span class=\"month\">" . $this->arrMonths[$this->pars['nmonth']][$this->monthNameLength] . "</span></td>";
		  echo "<td><a data-m=\"" . $this->toDecimal($this->nextMonth['mon']) . "\" data-y=\"" . $this->nextMonth['year'] . "\" class=\"changedate next\"></a></td>";
		  echo "</tr>";
		  echo "<tr>";
		  for ($i = $this->weekStartedDay - 1; $i < $this->weekStartedDay + 6; $i++) {
			  echo "<th>" . $this->arrWeekDays[($i % 7)][$this->weekDayNameLength] . "</th>";
		  }
		  echo "</tr>";
		  echo "</thead>";
		  echo "<tbody>";
	
		  if ($first_day['wday'] == 0) {
			  $first_day['wday'] = 7;
		  }
		  $max_days = $first_day['wday'] - ($this->weekStartedDay - 1);
		  if ($max_days < 7) {
			  echo "<tr>";
			  for ($i = 1; $i <= $max_days; $i++) {
				  echo "<td class=\"empty\">&nbsp;</td>";
			  }
			  $is_day = 0;
			  for ($i = $max_days + 1; $i <= 7; $i++) {
				  $is_day++;
				  $class = '';
				  $tclass = '';
				  $data = '';
				  if (($is_day == $this->today['mday']) && ($this->today['mon'] == $this->pars["month"])) {
					  $tclass = " today";
					  $display = $is_day;
				  }
				  
				  if ($this->checkEventsMonths($is_day)) {					  
					  $datamonth = $this->arrMonths[$this->pars['nmonth']][$this->monthNameLength];
					  $m = $this->pars["month"];
					  $datayear = $this->pars['year'];
					  $fdate = $datayear . '-' .$m . '-' . $is_day;
					  $display = $data . "<a class=\"view-events\" data-y=\"$datayear\" data-m=\"$m\" data-d=\"$is_day\" data-title=\"" . Filter::doDate("short_date", $fdate) . "\">" . $is_day . "</a>";
					  $class = " events";
				  } else {
					   $display = $is_day;
				  }
				  
				  echo "<td class=\"caldata" . $class . $tclass . "\"><span>" . $display . "</span></td>";
			  }
			  echo "</tr>";
		  }
	
		  $fullWeeks = floor(($last_day['mday'] - $is_day) / 7);
	
		  for ($i = 0; $i < $fullWeeks; $i++) {
			  echo "<tr>";
			  for ($j = 0; $j < 7; $j++) {
				  $is_day++;
				  $class = '';
				  $tclass = '';
				  $data = '';
				  if (($is_day == $this->today['mday']) && ($this->today['mon'] == $this->pars["month"])) {
					  $tclass = " today";
					  $display = $is_day;
				  }

				  if ($this->checkEventsMonths($is_day)) {
					  $datamonth = $this->arrMonths[$this->pars['nmonth']][$this->monthNameLength];
					  $m = $this->pars["month"];
					  $datayear = $this->pars['year'];
					  $fdate = $datayear . '-' .$m . '-' . $is_day;;
					  $display = $data . "<a class=\"view-events\" data-y=\"$datayear\" data-m=\"$m\" data-d=\"$is_day\" data-title=\"" . Filter::doDate("short_date", $fdate) . "\">" . $is_day . "</a>";
					  $class = " events";
				  } else {
					   $display = $is_day;
				  }
				  
				  echo "<td class=\"caldata" . $class . $tclass . "\"><span>" . $display . "</span></td>";
			  }
			  echo "</tr>";
		  }
	
		  if ($is_day < $last_day['mday']) {
			  echo "<tr>";
			  for ($i = 0; $i < 7; $i++) {
				  $is_day++;
				  $class = '';
				  $tclass = '';
				  $align = '';
				  $data = '';
				  
				  if (($is_day == $this->today['mday']) && ($this->today['mon'] == $this->pars["month"])) {
					  $tclass = " today";
					  $display = $is_day;
				  }
				  
				  if ($this->checkEventsMonths($is_day)) {
					  $datamonth = $this->arrMonths[$this->pars['nmonth']][$this->monthNameLength];
					  $m = $this->pars["month"];
					  $datayear = $this->pars['year'];
					  $fdate = $datayear . '-' .$m . '-' . $is_day;
					  $display = $data . "<a class=\"view-events\" data-y=\"$datayear\" data-m=\"$m\" data-d=\"$is_day\" data-title=\"" . Filter::doDate("short_date", $fdate) . "\">" . $is_day . "</a>";
					  $class = " events";
				  } else {
					   $display = $is_day;
				  }
				  echo ($is_day <= $last_day['mday']) ? "<td class=\"caldata" . $class . $tclass . "\"><span>" . $display . "</span></td>" : "<td class=\"empty\">&nbsp;</td>";
	
			  }
			  echo "</tr>";
		  }
		  echo "</tbody>";
		  echo "</table>";
	
	  }

      /**
       * eventManager::getUserList()
       * 
       * @return
       */
      public function getUserList()
      {
		  
		  $sql = "SELECT id, CONCAT(fname,' ',lname) as name FROM users"
		  . "\n WHERE active = 'y' and userlevel = 9 OR userlevel = 8"
		  . "\n ORDER BY userlevel DESC";
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;

      }
	  
	  /**
	   * eventManager::getCalData()
	   *
	   * @return
	   */
	  public function getCalData()
	  {
		  global $core;
		  
		  $caldata = "dateFormat: 'yy-mm-dd',timeFormat: 'hh:mm:ss',";
		  $caldata .= "dayNames: ['"._SUNDAY."', '"._MONDAY."', '"._TUESDAY."', '"._WEDNESDAY."', '"._THURSDAY."', '"._FRIDAY."', '"._SATURDAY."'],";
		  $caldata .= "dayNamesMin: ['"._SU."','"._MO."', '"._TU."', '"._WE."', '"._TH."', '"._FR."', '"._SA."'],";
		  $caldata .= "dayNamesShort: ['"._SUN."', '"._MON."', '"._TUE."', '"._WED."', '"._THU."', '"._FRI."', '"._SAT."'],";
		  $caldata .= "monthNames: ['"._JAN."', '"._FEB."', '"._MAR."', '"._APR."', '"._MAY."', '"._JUN."', '"._JUL."', '"._AUG."', '"._SEP."', '"._OCT."', '"._NOV."', '"._DEC."'],";
		  $caldata .= "monthNamesShort: ['"._JA_."', '"._FE_."', '"._MA_."', '"._AP_."', '"._MY_."', '"._JU_."', '"._JL_."', '"._AU_."', '"._SE_."', '"._OC_."', '"._NO_."', '"._DE_."'],";
		  $caldata .= "prevText: '".Lang::$word->_MOD_EM_PREV."',";
		  $caldata .= "nextText: '".Lang::$word->_MOD_EM_NEXT."',";
		  $caldata .= "timeText: '".Lang::$word->_MOD_EM_TIME."',";
		  $caldata .= "hourText: '".Lang::$word->_MOD_EM_HOUR."',";
		  $caldata .= "minuteText: '".Lang::$word->_MOD_EM_MIN."',";
		  $caldata .= "secondText: '".Lang::$word->_MOD_EM_SEC."',";
		  $caldata .= "firstDay: " . ($core->weekstart - 1) . ",";
		  $caldata .= "hourGrid: 4,";
		  $caldata .= "minuteGrid: 10,";
		  $caldata .= "secondGrid: 10";
		  
		  return $caldata;
	  }

      /**
       * eventManager::setWeekStart()
       * 
       * @return
       */
      private function setWeekStart()
      {
		  return Registry::get("Core")->weekstart;
      }

	/**
	 * eventManager::calcDays()
	 * 
	 * @param string $month
	 * @param string $day
	 * @return
	 */
	  private function calcDays($month, $day)
	  {
		  if ($day < 29) {
			  return $day;
		  } elseif ($day == 29) {
			  return ((int)$month == 2) ? 28 : 29;
		  } elseif ($day == 30) {
			  return ((int)$month != 2) ? 30 : 28;
		  } elseif ($day == 31) {
			  return ((int)$month == 2 ? 28 : ((int)$month == 4 || (int)$month == 6 || (int)$month == 9 || (int)$month == 11 ? 30 : 31));
		  } else {
			  return 30;
		  }
	
	  }
	  
      /**
       * eventManager::toDecimal()
       * 
       * @param mixed $number
       * @return
       */
      public function toDecimal($number)
      {
          return (($number < 10) ? "0" : "") . $number;
      }
	  
      /**
       * eventManager::checkYear()
       * 
       * @param string $year
       * @return
       */
      private function checkYear($year = "")
      {
          return (strlen($year) == 4 or ctype_digit($year)) ? true : false;
      }


      /**
       * eventManager::checkMonth()
       * 
       * @param string $month
       * @return
       */
      private function checkMonth($month = "")
      {
          return ((strlen($month) == 2) or ctype_digit($month) or ($month < 12)) ? true : false;
      }


      /**
       * eventManager::checkDay()
       * 
       * @param string $day
       * @return
       */
      private function checkDay($day = "")
      {
          return ((strlen($day) == 2) or ctype_digit($day) or ($day < 31)) ? true : false;
      }
  }
?>