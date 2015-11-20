<?php

namespace model;

class Event{
    
    private $startTime;
    private $stopTime;
    private $text;
    //Holds <div> id on event view
    private $divIdArray = array();
   
    public function __construct($start, $stop, $text){
        $this->startTime = $start;
        $this->stopTime = $stop;
        $this->text = $text;
    }

    public function setDivIdToArray($divId){
         $this->divIdArray[] = $divId;
    }

    public function getDivIdArray(){
        return $this->divIdArray;
    }
    public function getStartTime(){
        return $this->startTime;
    }
    public function getStopTime(){
        return $this->stopTime;
    }
    public function getEventText(){
        return $this->text;
    }
}