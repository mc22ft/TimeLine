<?php
    
namespace model;

require_once("Model/Event.php");

//Handle TimeLine and Events and make sure that they work together
//Handle session (get set)
class TimeLineModel {
    
    private $timeLine;
    private $sessionHandeler;
    
    public function __construct(\model\SessionHandeler $sessionHandeler){
        $this->sessionHandeler = $sessionHandeler;
    }

    public function setSelectedTimeLine(TimeLine $timeLine){
        $this->timeLine = $timeLine;
    }

    public function getSelectedTimeLine(){
        return $this->timeLine;
    }

    //set event to array
    public function addEvent(Event $event){
        $this->timeLine->setEventArray($event);
    }

    //get event array
    public function getAllEvent(){
        return $this->timeLine->getEventArray();
    }

    public function removeAllEvents(){
       $this->timeLine->removeAllEvents();
    }

    public function removeEvent($idEvent){
        $events = $this->timeLine->getEventArray();
       
        $indexCount = 0;
        foreach ($events as $event)
        {   
        	if ($event->getStartTime() == $idEvent)
            {
                //Removes event 
                unset($events[$indexCount]);
                $events = array_values($events);
                $this->timeLine->updateEventArray($events);
            }
            $indexCount++;
        }
    }

    public function sortEventArray($events){
        //sort obj array for print out right
        usort($events, function ($item1, $item2) {
             $ts1 = strtotime($item1->getStartTime());
             $ts2 = strtotime($item2->getStartTime());
              if ($ts1 == $ts2) {
                  return 0;
              }
              return ($ts1 < $ts2) ? -1 : 1;
           });
        return $events;
    }

    //Redirect
    public function restartApp() {
        $this->unsetSession();
        $actual_link = "http://" . $_SERVER['HTTP_HOST'];
        header("Location: $actual_link");
	}

    //Session
    //Set
    public function saveSession($obj) {
		$this->sessionHandeler->saveSession($obj);
	}
    //save
    public function saveSelectedSession() {
		$this->sessionHandeler->saveSelectedSession($this->timeLine);
	}
    //get
    public function getSession() {
		return $this->sessionHandeler->getSession();
	}
    //Set
    //Delete session
    public function unsetSession() {
		$this->sessionHandeler->delete();
	}
    //get
    public function isSessionSet() {
		return $this->sessionHandeler->isSessionSet();
	}
}
