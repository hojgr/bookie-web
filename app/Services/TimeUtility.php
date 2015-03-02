<?php


namespace BookieGG\Services;


use BookieGG\Contracts\TimeUtilityInterface;

class TimeUtility implements TimeUtilityInterface {

	public function formatTimestamp($string_time)
	{
		$timestamp = strtotime($string_time);
		$today_midnight = strtotime('today midnight');
		$tomorrow_midnight = strtotime('tomorrow midnight');

		$today = false;
		$tomorrow = false;
		if($timestamp > $today_midnight AND $timestamp < $today_midnight + (24*60*60)) {
			$today = true;
		} else if($timestamp > $tomorrow_midnight AND $timestamp < $tomorrow_midnight + (24*60*60)) {
			$tomorrow = true;
		}

		$time = date('H:i', $timestamp);
		$date = date('n/j/Y', $timestamp);

		if($today) {
			return 'today at ' . $time;
		} else if($tomorrow) {
			return 'tomorrow at ' . $time;
		} else {
			return $date . " - " . $time;
		}
	}

	public function formatTimestampFromNow($string_format)
	{
		$timestamp = strtotime($string_format);
		$future = true;

		$time_diff = $timestamp - time();
		if($time_diff == 0)
			return 'now';

		if($time_diff < 0) {
			$future = false;
			$time_diff *= -1;
		}

		$days = (int)($time_diff / (24 * 3600));
		$time_diff -= $days * (24*3600);

		$hours = (int)($time_diff / 3600);
		$time_diff -= $hours * 3600;

		$minutes = (int)($time_diff / 60);

		$out = "";

		if($days > 0) {
			$out .= $this->formatOut($days, "day");
		}

		if($hours > 0) {
			$out .= $this->formatOut($hours, "hour");
		}

		if($minutes > 0 && $days == 0) {
			$out .= $this->formatOut($minutes, "minute");
		}

		return $out . " " . ($future ? "from now" : "ago");
	}

	public function formatOut($amt, $str) {
		return " " . $amt . " " . $str . ($amt > 1 ? "s" : "");
	}
}