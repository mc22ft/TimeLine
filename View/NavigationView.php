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
    private static $doDeleteEvent = "ListEvents::Delete";
    private static $doEvent = "SendEventView::Event";
    private static $doClearEvents = "SendEventView::ClearEvent";
    private static $doNewTimeLine = "SendEventView::NewTimeLine";
    private static $doRegistration = "SendStartStopTimeView::Register";

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

    //bool
    public function userPressedSendEvent() {
		if(isset($_POST[self::$doEvent]) == true){
		    return TRUE;
		} 
	    return FALSE;
	}
    //bool
    public function userPressedClearEvent() {
		if(isset($_POST[self::$doClearEvents]) == true){
		    return TRUE;
		} 
	    return FALSE;
	}
    //bool
    public function userPressedNewTimeLine() {
		if(isset($_POST[self::$doNewTimeLine]) == true){
		    return TRUE;
		} 
	    return FALSE;
	}
    //bool
    public function userPressedDeleteEvent() {
		if(isset($_POST[self::$doDeleteEvent]) == true){
		    return TRUE;
		} 
	    return FALSE;
	}
    //bool
    public function userPressedDoRawTimeLine() {
		if(isset($_POST[self::$doRegistration]) == true){
		    return TRUE;
		} 
	    return FALSE;
	}
}
