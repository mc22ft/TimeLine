<?php

namespace view;

require_once("View/ListEvents.php");

class SendEventView{

    private static $messageId = "SendEventView::Message";
	private static $startTime = "SendEventView::StartTime";
	private static $stopTime = "SendEventView::StopTime";
    private static $text = "SendEventView::Text";
    private static $doEvent = "SendEventView::Event";
    private static $doClearEvents = "SendEventView::ClearEvent";
    private static $doNewTimeLine = "SendEventView::NewTimeLine";
    
    private $message;
    private $passedValidation = false;
    private $model;
    private $event;
    private $timeValidation;

    public function __construct(\model\TimeLineModel $model){
        $this->model = $model;
        $this->timeValidation = new \view\ListEvents($this->model);
        $_SESSION["message"] = "";
    }

    public function getEvent(){
        $this->message = $_SESSION["message"];

        //clear events
        if($this->userPressedClearEvent()){
            $this->message = "All events is removed from timeline";
        }
      
        return $this->generateEventFormHTML($this->message);
    }

    public function doValiadtion($event){

         if($this->userPressedSendEvent()){
             $this->isEventSetRight($event);
             $this->startTimeValidation($event);
             $this->stopTimeValidation($event);
             $_SESSION["message"] = $this->message;

             if(empty($this->message)){
                 $this->passedValidation = true;
             }
        }
    }

    public function getPassedValidation(){
        return $this->passedValidation;
    }

    public function getNewEvent(){
        return new \model\Event(
                        $this->getStartTime(),
                        $this->getStopTime(),
                        $this->getEventText());
    }

     //HTML
    //Register form
    private function generateEventFormHTML($message) {
		return "<form class='eventForm' action='' method='post' enctype='multipart/form-data'>
					<legend>Register a new Event - Write start time and stop time</legend>
                    <p style='color:red;' id='".self::$messageId."'>$message</p>
                    <div class='row'>
                        <div class='col-xs-2'>
					        <input type='text' class='form-control input-sm' id='".self::$startTime."' name='".self::$startTime."' placeholder='Start Time' value >
                        </div>
					    <div class='col-xs-2'>
					        <input type='text' class='form-control input-sm' id='".self::$stopTime."' name='".self::$stopTime."'  placeholder='Stop Time' value>
                        </div>

                        <div class='col-xs-2'>
					        <input type='text' class='form-control input-sm' id='".self::$text."' name='".self::$text."'  placeholder='Event Text' value>
                        </div>

                        <div class='col-xs-6'>
                            <input type='submit' class='btn-sm btn-primary' id='submit' name='".self::$doEvent."' value='Set Event'>
                            <input type='submit' class='btn-sm btn-warning' id='submit1' name='".self::$doClearEvents."' value='Clear Events'>
                            <input type='submit' class='btn-sm btn-danger' id='submit1' name='".self::$doNewTimeLine."' value='Start Over'>
                         </div>
                    </div>
			    </form>";
    }

    public function isEventSetRight($inEvent){
        $this->doTimeToDivIds($inEvent);
        //get highest and lowerst divid
        $timeLine = $this->model->getSelectedTimeLine();
        $events = $timeLine->getEventArray();
        $idInArray = $inEvent->getDivIdArray();
        //spinn on evry event
        foreach($events as $event){
            $modelDivIdArray = $event->getDivIdArray();
            //Spinn on event array
            foreach($modelDivIdArray as $value){
                //spinn on input array
                foreach($idInArray as $divInId){
                    //match?
                    if (in_array($divInId, $modelDivIdArray)) {
                        $this->message = "Event is alredy set on this time";
                    }
                }
            }
        }
        
        //If intime is out of bounds
        if(strtotime($inEvent->getStartTime()) < strtotime($timeLine->getStartTime()) ||
                strtotime($inEvent->getStopTime()) > strtotime($timeLine->getStopTime())){
            $this->message = "Event time is set out of timeline";
        }

        if(strtotime($inEvent->getStartTime()) >= strtotime($inEvent->getStopTime())){
            $this->message = "Stop time is wrong";
        }
    }

    //For print out on view
    public function doTimeToDivIds($event){
        $start = $this->addZero($event->getStartTime());
        $stop = $this->addZero($event->getStopTime());
        $nrEvents = $stop - $start;
        $nrEvents = $nrEvents * 2;
        //Set id ex 07 = id 7.5
        $id = $start;
        for ($x = 1; $x <= $nrEvents; $x++) {
            $id += 0.5; 
            //$start contains int start + 0.5
            //For halv houer 
            //Add to array
            $event->setDivIdToArray($id);
        }
        $this->event = $event;
    }

    //To the biginning if time = 07:00 = 07:00
    public function addZero($time){
        //ZERO RULE
        if(strlen($time) == 4){ 
            //true add zero at beginngin
            $time = "0" . $time;
        }
        //Check for half houer must be float
        if(substr($time, -2, 1) == 3){
            //remove "03" and get first end secound character
            $first = substr($time, -5, 1);
            $secound = substr($time, -4, 1);
            $time = $first . $secound;
            //add on end
            $time = $time . ".5";
        }
        //to float
        $time = (float)$time;
        //var_dump($time);
        return $time;
    }

    private function startTimeValidation($event){
        if(empty($event->getStartTime())){
            $this->message = "Start time is missing";
        }else{
            //Valedering time
            if($this->timeValidation($event->getStartTime())){
                $this->message = "Start time is wrong. Only hours like: 7:00, 08:00, 08:30, 7:00, 15:00 18:00, 18:30";
            }
        }
    }

    private function stopTimeValidation($event){
        if(empty($event->getStopTime())){
            if(!empty($this->message)){
                $this->message .= "<br/>";
            }
                $this->message .= "Stop time is missing";
        }else{
            //Valedering time
            if(!empty($this->message)){
                $this->message .= "<br/>";
            }
                if($this->timeValidation($event->getStopTime())){
                    $this->message .= "Stop time is wrong. Only hours like: 7:00, 08:00, 08:30, 7:00, 15:00 18:00, 18:30";
            }
        }
    }

    //For Houer and not half houers any more...
    private function timeValidation($time){
        $t = preg_match('#^(1?[0-9]|2[0-3]):([0][0]|[3][0])$#', $time);
        //$t = preg_match('#^(1?[0-9]|2[0-3]):([0][0]|[0][0])$#', $time);
        if($t == 0){
            return TRUE;
        }
        return FALSE;
    }

    //bool
    public function userPressedSendEvent() {
		if(isset($_POST[self::$doEvent])){
		    return TRUE;
		} 
	    return FALSE;
	}
    //bool
    public function userPressedClearEvent() {
		if(isset($_POST[self::$doClearEvents])){
		    return TRUE;
		} 
	    return FALSE;
	}
    //bool / redirect
    public function userPressedNewTimeLine() {
		if(isset($_POST[self::$doNewTimeLine])){
            $this->model->unsetSession();
            $actual_link = "http://" . $_SERVER['HTTP_HOST'];
		    header("Location: $actual_link");
		    return TRUE;
		} 
	    return FALSE;
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

    private function getEventText() {
		if (isset($_POST[self::$text]))
			return trim($_POST[self::$text]);
		return "";
	}
}