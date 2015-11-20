<?php

namespace view;

require_once("model/TimeLine.php");

class SendStartStopTimeView{

    /**
	 * These names are used in $_POST
	 * @var string
	 */              
                
	private static $messageId = "SendStartStopTimeView::Message";
	private static $date = "SendStartStopTimeView::Date";
	private static $startTime = "SendStartStopTimeView::StartTime";
	private static $stopTime = "SendStartStopTimeView::StopTime";
    private static $doRegistration = "SendStartStopTimeView::Register";
   
    public $message = "";
    private $passedValidation = false;
    private $model;

    public function __construct(\model\TimeLineModel $model){
        $this->model = $model;
    }
     /**
	 * @return boolean true if user did try to make timeline
	 */
	public function userPressedMakeTimeLine() {
		if(isset($_POST[self::$doRegistration])){
		    return TRUE;
		} 
	    return FALSE;
	}

    public function getStartStopTime(){
        //set message to empty evry time
        $message = "";
        $this->doValiadtion();

        //if passed validation - redirect and catch post in some other view
        if($this->passedValidation == true){
            $query = "TimeLine";
            //save start stop times in session before redirect
            $this->model->saveSession($this->getTimeLine());
            $this->redirect($query);
        }
        
        return $this->generateRegisterFormHTML($this->message);
    }

    private function redirect($query){
        $actual_link = "http://" . $_SERVER['HTTP_HOST'];
		header("Location: $actual_link"."?".$query);
    }

    public function getTimeLine(){
        return new \model\TimeLine(
                        $this->getStartTime(),
                        $this->getStopTime(),
                        $this->getRequestDate());
    }

     //HTML
    //Register form
    private function generateRegisterFormHTML($message) {
		return "<form class='text-center' action='' method='post' enctype='multipart/form-data'>
					<legend>Register a new TimeLine - Write start time and stop time</legend>
                    <p style='color:red;' id='".self::$messageId."'>$message</p>
                    <div class='row'>
                        <div class='col-xs-4'>
                            <label for='".self::$date."'>Date</label>
					        <input type='text' class='form-control input-sm' id='".self::$date."' name='".self::$date."' value='".$this->getRequestDate()."' readonly>
                        </div>
                        <div class='col-xs-4'>
                            <label for='".self::$startTime."'>Start Time</label>
					        <input type='text' class='form-control input-sm' id='".self::$startTime."' name='".self::$startTime."' value>
                        </div>
                        <div class='col-xs-4'>
					        <label for='".self::$stopTime."'>Stop Time</label>
					        <input type='text'class='form-control input-sm'  id='".self::$stopTime."' name='".self::$stopTime."' value>
                        </div>
                     </div> 
                <div class='buttom'>
                    <input class='btn-sm btn-primary' type='submit' id='submit' name='".self::$doRegistration."' value='Make TimeLine'>
                </div>
			</form>
		";
    }

    public function passedValidation($passed){
        $this->passedValidation = true;
    }

    public function doValiadtion(){
         if($this->userPressedMakeTimeLine()){
             if(empty($_POST[self::$date])){
                 $this->message = "You have to set a date first";
             }else{
                
                 $this->sameDayValidation();
                 $this->timeOutOfBounds();
                 $this->startTimeValidation();
                 $this->stopTimeValidation();
             }
             if(empty($this->message)){
                 $this->passedValidation(true);
             }
        }
    }

    private function sameDayValidation(){
                $start = $this->getStartTime();
                $stop = $this->getStopTime();
                $intStartTime = $this->getIntTimeForValidation($start);
                $intStopTime = $this->getIntTimeForValidation($stop);
                if($intStartTime <= 0 || $intStartTime == $intStopTime){
                    //fail
                    $this->message= "Start time not right";
                }
                if($intStopTime > 23 || $intStopTime == $intStartTime){
                    //fail
                    $this->message = "Stopp time not right";
                }
    }

    //If intime is out of bounds
    private function timeOutOfBounds(){
                if(strtotime($this->getStartTime()) < strtotime($this->getStartTime()) ||
                        strtotime($this->getStopTime()) > strtotime($this->getStopTime())){
                    $this->message = "Event time is set out of timeline";
                }

                if(strtotime($this->getStartTime()) >= strtotime($this->getStopTime())){
                    $this->message = "Stop time is wrong";
                }
    }

    private function getIntTimeForValidation($time){
                if(strlen($time) == 4){ 
                    //true add zero at beginngin
                    $time = "0" . $time;
                 }
                $first = substr($time, -5, 1);
                $secound = substr($time, -4, 1);
                $time = $first . $secound;
                $intTime = (int)$time;
                return $intTime;
    }

    private function startTimeValidation(){
                if(empty($_POST[self::$startTime])){
                    $this->message = "Start time is missing";
                }else{
                    //Valedering time
                    if($this->timeValidation($_POST[self::$startTime])){
                        $this->message = "Start time is wrong. Only hours like: 7:00, 08:00, 08:30, 7:00, 15:00 18:00, 18:30";
                    }
                }
    }

    private function stopTimeValidation(){
                if(empty($_POST[self::$stopTime])){
                    if(!empty($this->message)){
                        $this->message .= "<br/>";
                    }
                     $this->message .= "Stop time is missing";
                }else{
                    //Valedering time
                    if(!empty($this->message)){
                        $this->message .= "<br/>";
                    }
                     if($this->timeValidation($_POST[self::$stopTime])){
                         $this->message .= "Stop time is wrong. Only hours like: 7:00, 08:00, 08:30, 7:00, 15:00 18:00, 18:30";
                    }
                }
    }

    //Houer only
    private function timeValidation($time){
        $t = preg_match('#^(1?[0-9]|2[0-3]):[0][0]$#', $time);
        if($t == 0){
            return TRUE;
        }
        return FALSE;
    }

    //get date from calender klick
    private function getRequestDate() {
		if (isset($_GET['id'])){
            $date = strip_tags($_GET['id']);
            $date .= ' ';
            $date .= strip_tags($_GET['month']);
            $date .= ' ';
            $date .= strip_tags($_GET['year']);
            return $date;
        }
		return "";
	}

    private function getStartTime() {
		if (isset($_POST[self::$startTime]))
			return trim($_POST[self::$startTime]);
		return "";
	}

    private function getStopTime() {
		if (isset($_POST[self::$stopTime]))
			return trim($_POST[self::$stopTime]);
		return "";
	}

}