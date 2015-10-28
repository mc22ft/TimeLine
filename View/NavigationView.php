<?php

namespace view;

/**
 * NavigationView short summary.
 *
 * NavigationView description.
 *
 * @version 1.0
 * @author MathiasClaesson
 */
class NavigationView
{

    private static $TimeLine = "TimeLine";
    private static $id = "id";

    //Url empty
    public function inCalendar(){
        if (empty($_GET) || isset($_GET[self::$id])) {
            return true;
        }
        return false;
    }

    public function inTimeLine(){
        if (isset($_GET[self::$TimeLine])) {
            return true;
        }
        return false;
    }
    
    public function userWhantsToSeeCalendar(){
        if (isset($_GET[self::$TimeLine]) == false) {
			return true;
		}
		return false;
    }

    public function userWhantsToSeeTimeLine(){
        if (isset($_GET[self::$TimeLine]) == true) {
			return true;
		}
		return false;
    }
}
