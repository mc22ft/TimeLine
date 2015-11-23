<?php

namespace model;

class Event{
    
    private $startTime;
    private $stopTime;
    private $text;
    private $color;
    //Holds <div> id on event view
    private $divIdArray = array();
   
    public function __construct($start, $stop, $text, $color){
        $this->startTime = $start;
        $this->stopTime = $stop;
        $this->text = $text;
        $this->color = $color;
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
    public function getEventColor(){
        return $this->color;
    }
}