<?php

namespace view;

class ListEvents {
    

    private static $startTime = "ListEvents::StartTime";
	private static $stopTime = "ListEvents::StopTime";
    private static $doDeleteEvent = "ListEvents::Delete";


    //private $message;
    private $model;

    public function __construct(\model\TimeLineModel $model){
        $this->model = $model;
    }

    public function getListEvents(){
        
        //var_dump($_POST);

        //$trere = $this->getStartTime();

        //var_dump($trere);
        //var_dump($this->userPressedDeleteEvent());
        
        return $this->generateEventsFormHTML();
   }

    //HTML
    //Register form
    private function generateEventsFormHTML() {

        //build form
        
        $events = $this->model->getAllEvent();

       
        $formOut = "<form action='' method='post' enctype='multipart/form-data'>
				<fieldset>
					<legend>Evens overView - Click to remove event</legend>";
                    
                foreach ($events as $event){
                    $startTime = $event->getStartTime();
                    $stopTime = $event->getStopTime();
                    $hidden = "hidden";

                    $formOut .= "<label for='".self::$startTime."'>$startTime - $stopTime</label>
                                <input type='".$hidden."' id='".self::$startTime."' name='".self::$startTime."' value='".$startTime."'>
                                <input type='submit' id='submit' name='".self::$doDeleteEvent."' value='Remove Event'>
                                <br>";
                }

	    $formOut .=	"</fieldset>
			</form>";
		
		return $formOut;
    }

    //Get start time for delete ID
    public function getStartTime() {
		if (isset($_POST[self::$startTime]))
			return trim($_POST[self::$startTime]);
		return "";
	}
    //bool
    public function userPressedDeleteEvent() {
		if(isset($_POST[self::$doDeleteEvent])){
		    return TRUE;
		} 
	    return FALSE;
	}



    //--------- old class validation code REMOVE!!!


    ////return error message
    //public function doValidationEvent(Event $event){
    //    $this->message = "";
    //    $this->startTimeValidation($event);
    //    $this->stopTimeValidation($event);
    //    $this->isEventSetRight($event);
    //    return $this->message;
    //}

    //public function isEventSetRight($inEvent){
    //    $this->doTimeToDivIds($inEvent);
    //    //get highest and lowerst divid
    //    $timeLine = $this->model->getSelectedTimeLine();
    //    $events = $timeLine->getEventArray();
    //    $idInArray = $inEvent->getDivIdArray();

    //    //spinn on evry event
    //    foreach($events as $event){
            
    //        $modelDivIdArray = $event->getDivIdArray();

    //        //Spinn on event array
    //        foreach($modelDivIdArray as $value){
                
    //            //spinn on input array
    //            foreach($idInArray as $divInId){
                    
    //                //match?
    //                if (in_array($divInId, $modelDivIdArray)) {
    //                    $this->message = "Event is alredy set on this time";
    //                }
    //            }
    //        }
    //    }
        
    //    //If intime is out of bounds
    //    if(strtotime($inEvent->getStartTime()) < strtotime($timeLine->getStartTime()) ||
    //            strtotime($inEvent->getStopTime()) > strtotime($timeLine->getStopTime())){
    //        $this->message = "Event time is set out of timeline";
    //    }

    //    if(strtotime($inEvent->getStartTime()) >= strtotime($inEvent->getStopTime())){
    //        $this->message = "Stop time is wrong";
    //    }
    //}

    ////For print out on view
    //public function doTimeToDivIds($event){
    //    $start = $this->addZero($event->getStartTime());
    //    $stop = $this->addZero($event->getStopTime());
    //    $nrEvents = $stop - $start;
    //    $nrEvents = $nrEvents * 2;

    //    //Set id ex 07 = id 7.5
    //    $id = $start;
    //    $divIdArray = array();
    //    for ($x = 1; $x <= $nrEvents; $x++) {
    //        $id += 0.5; 
    //        //$start contains int start + 0.5
    //        //For halv houer 
    //        //Add to array
    //        $event->setDivIdToArray($id);
    //    }

    //}

    ////To the biginning if time = 07:00 = 07:00
    //public function addZero($time){
    //    //ZERO RULE
    //    if(strlen($time) == 4){ 
    //        //true add zero at beginngin
    //        $time = "0" . $time;
    //    }

    //    //get only 2 first characters
    //    $first = substr($time, -5, 1);
    //    $secound = substr($time, -4, 1);
    //    $time = $first . $secound;
    //    //to float
    //    $time = (float)$time;
    //    return $time;
    //}

    //private function startTimeValidation($event){
    //            if(empty($event->getStartTime())){
    //                $this->message = "Start time is missing";
    //            }else{
    //                //Valedering time
    //                if($this->timeValidation($event->getStartTime())){
    //                    $this->message = "Start time is wrong. Only hours like: 7:00, 08:00, 7:00, 15:00 18:00";
    //                }
    //            }
    //}

    //private function stopTimeValidation($event){
    //            if(empty($event->getStopTime())){
    //                if(!empty($this->message)){
    //                    $this->message .= "<br/>";
    //                }
    //                 $this->message .= "Stop time is missing";
    //            }else{
    //                //Valedering time
    //                if(!empty($this->message)){
    //                    $this->message .= "<br/>";
    //                }
    //                 if($this->timeValidation($event->getStopTime())){
    //                    $this->message .= "Stop time is wrong. Only hours like: 7:00, 8:00, 15:00 18:00";
    //                }
    //            }
    //}

    ////For Houer and not half houers any more...
    //private function timeValidation($time){
    //    $t = preg_match('#^(1?[0-9]|2[0-3]):([0][0]|[0][0])$#', $time);
    //    if($t == 0){
    //        return TRUE;
    //    }
    //    return FALSE;
    //}
}