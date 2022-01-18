<?php

namespace Inc\Helpers;

class DateHelper
{
    public static function getYear($date) {
        $date = explode('-', $date);
        $month_day = $date[2];
        $month_name = date("F", mktime(0, 0, 0, $date[1], 10));
        $year = $date[0];
        $formated_date = array(
            "full_date" =>"$month_name $month_day, $year",
            "year" => $year,
        );

        return $formated_date;
    }

    public static function convertTrackMsDurationToMinutes($track_duration_ms) {
        $milliseconds = $track_duration_ms;
        $time = $milliseconds / 1000;
        $days = floor($time / (24*60*60));
        $hours = floor(($time - ($days*24*60*60)) / (60*60));
        $minutes = floor(($time - ($days*24*60*60)-($hours*60*60)) / 60);
        $seconds = ($time - ($days*24*60*60) - ($hours*60*60) - ($minutes*60)) % 60;
        return sprintf('%02d', $hours).':'.sprintf('%02d', $minutes).':'.sprintf('%02d', $seconds);

    }
    public static function convertTrackMsDurationToMinute($track_duration_ms) {
        $milliseconds = $track_duration_ms;
        $time = $milliseconds / 1000;
        $days = floor($time / (24*60*60));
        $hours = floor(($time - ($days*24*60*60)) / (60*60));
        $minutes = floor(($time - ($days*24*60*60)-($hours*60*60)) / 60);
        $seconds = ($time - ($days*24*60*60) - ($hours*60*60) - ($minutes*60)) % 60;
        return sprintf('%02d', $minutes).'.'.sprintf('%02d', $seconds).' min';

    }

    public static function convertTrackMsDurationToSecond($track_duration_ms) {
       return floor($track_duration_ms / 1000);
    }
}