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
        $events = $this->model->getAllEvent();
        $events = $this->model->sortEventArray($events);
        return $this->generateEventsFormHTML($events);
   }

    //HTML
    //Register form
    private function generateEventsFormHTML() {
        $formOut = "";
        //build form
        if (!empty($events))
        {
            $counter = 1;
            foreach ($events as $event){
                $startTime = $event->getStartTime();
                $stopTime = $event->getStopTime();
                $hidden = "hidden";
                $formOut .= "<form class='listForm' action='' method='post' enctype='multipart/form-data'>
			                    <fieldset>
                                    <div class='row'>
                                        <div class='col-xs-2'>
                                            <p class='listCounter text-right'>$counter.</p> 
                                        </div>
                                        <div class='col-xs-2'>
                                            <label for='".self::$startTime."'><p class='eventTime'>$startTime - $stopTime</p></label>
                                            <input type='".$hidden."' id='".self::$startTime."' name='".self::$startTime."' value='".$startTime."'>
                                        </div>
                                        <div class='col-xs-2'>
                                            <input class='btn-xs btn-danger' type='submit' id='submit' name='".self::$doDeleteEvent."' value='Remove Event'>
                                        </div>
                                    </div>
                                </fieldset>
			                </form> ";
                $counter++;
            }

		return $formOut;
        }
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
}