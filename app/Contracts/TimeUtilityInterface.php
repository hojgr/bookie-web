<?php


namespace BookieGG\Contracts;


interface TimeUtilityInterface {
	public function formatTimestamp($string_time);
	public function formatTimestampFromNow($string_format);
}