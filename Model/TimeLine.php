<?php

namespace model;

class TimeLine{

    private $startTime;
    private $stopTime;
    private $date;
    private $eventArray;

    public function __construct($start, $stop, $date){
        $this->startTime = $start;
        $this->stopTime = $stop;
        $this->date = $date;
        $this->eventArray = array();
    }
                    
    public function getStartTime(){
        return $this->startTime;
    }

    public function getStopTime(){
        return $this->stopTime;
    }

    public function getDate(){
        return $this->date;
    }

    public function setEventArray(Event $event){
        $this->eventArray[] = $event;
    }

    public function getEventArray(){
        return $this->eventArray;
    }

    public function removeAllEvents(){
        unset($this->eventArray);
        $this->eventArray = array();
    }
}