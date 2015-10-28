<?php
    
namespace view;

class SendEventView{

    private static $messageId = "SendEventView::Message";
	private static $startTime = "SendEventView::StartTime";
	private static $stopTime = "SendEventView::StopTime";
    private static $doEvent = "SendEventView::Event";
    private static $doClearEvents = "SendEventView::ClearEvent";
    private static $doNewTimeLine = "SendEventView::NewTimeLine";
    
    private $message;
    private $passedValidation = false;
    private $model;

    public function __construct(\model\TimeLineModel $model){
        $this->model = $model;
    }

    public function getEvent($mesage){
        $this->message = $mesage;
        
        //clear events
        if($this->userPressedClearEvent()){
            if(!empty($this->model->getAllEvent())){
                $this->message = "All events is removed from timeline";
            }
        }
      
        return $this->generateEventFormHTML($this->message);
    }

    public function doValiadtion(){
         if($this->userPressedSendEvent()){
             $this->startTimeValidation();
             $this->stopTimeValidation();
             if(empty($this->message)){
                 $this->passedValidation(true);
             }
        }
    }

    public function passedValidation($passed){
        $this->passedValidation = true;
    }

    public function getNewEvent(){
        return new \model\Event(
                        $this->getStartTime(),
                        $this->getStopTime());
    }

     //HTML
    //Register form
    private function generateEventFormHTML($message) {
		return "<form action='' method='post' enctype='multipart/form-data'>
				<fieldset>
					<legend>Register a new Event - Write start time and stop time</legend>
                    <p style='color:red;' id='".self::$messageId."'>$message</p>
                    <label for='".self::$startTime."'>Start Time :</label>
					<input type='text' id='".self::$startTime."' name='".self::$startTime."' value>
                    <br>
					<label for='".self::$stopTime."'>Stop Time :</label>
					<input type='text' id='".self::$stopTime."' name='".self::$stopTime."' value>
                    <br>
					<input type='submit' id='submit' name='".self::$doEvent."' value='Set Event'>
                    <br>
                    <input type='submit' id='submit1' name='".self::$doClearEvents."' value='Clear Events'>
                    <br>
                    <input type='submit' id='submit1' name='".self::$doNewTimeLine."' value='Start over'>
                    <br>
				</fieldset>
			</form>
		";
    }

    //almost same as in timeValidationModel
    private function startTimeValidation(){
                if(empty($this->getStartTime())){
                    $this->message = "Start time is missing";
                }else{
                    //Valedering time
                    if($this->timeValidation($this->getStartTime())){
                        $this->message = "Start time is wrong. Only hours like: 7:00, 08:00, 7:00, 15:00 18:00";
                    }
                }
    }

    //almost same as in timeValidationModel
    private function stopTimeValidation(){
                if(empty($this->getStopTime())){
                    if(!empty($this->message)){
                        $this->message .= "<br/>";
                    }
                     $this->message .= "Stop time is missing";
                }else{
                    //Valedering time
                    if(!empty($this->message)){
                        $this->message .= "<br/>";
                    }
                     if($this->timeValidation($this->getStopTime())){
                        $this->message .= "Stop time is wrong. Only hours like: 7:00, 8:00, 15:00 18:30";
                    }
                }
    }

    //Houer and not half houers any more
    private function timeValidation($time){
        $t = preg_match('#^(1?[0-9]|2[0-3]):([0][0]|[0][0])$#', $time);
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
}