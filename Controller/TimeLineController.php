<?php

namespace controller;

require_once("view/TimeLineView.php");
require_once("view/EmptyLineView.php");
require_once("view/SendEventView.php");
require_once("view/TimeLineEventView.php");

/**
 * TimeLineController short summary.
 * Presents timeline with input time limmits
 * Hanadle in events
 * TimeLineController description.
 *
 * @version 1.0
 * @author MathiasClaesson
 */   

class TimeLineController{
    
    private $navigationView;
    private $model;
    private $answer;
    //private $listEvents;

    public function __construct(\model\TimeLineModel $model){
        $this->model = $model;
        $this->navigationView = new \view\NavigationView();
        
    }

    public function doTimeLineSetUp(){
        
        //in TimeLine
        if($this->navigationView->userWhantsToSeeTimeLine()){
                
           
                //Begin set up model
                //Save to line to model
                $lineObj = $this->model->getSession();
                $this->model->setSelectedTimeLine($lineObj);
                
                //SetUp view
                $lineView = new \view\EmptyLineView($this->model);
                $sendEvent = new \view\SendEventView($this->model);
                $listEvents = new \view\ListEvents($this->model);

                //Remove 1 event from TimeLine obj
                if($listEvents->userPressedDeleteEvent()){
                    $idTime = $listEvents->getStartTime();
                    $this->model->removeEvent($idTime);
                }

                //Remove all events from TimeLine obj
                if($sendEvent->userPressedClearEvent()){
                    $this->model->removeAllEvents();
                }

                if($sendEvent->userPressedNewTimeLine()){
                    //redirect to first page
                }
                if($sendEvent->userPressedSendEvent()){

                    $newEvent = $sendEvent->getNewEvent();

                    $sendEvent->doValiadtion($newEvent);

                    if ($sendEvent->getPassedValidation())
                    {
                       //var_dump($newEvent);
                    	$this->model->addEvent($newEvent);
                    }
                    
                   //Get event from view
                    //$newEvent = $sendEvent->getNewEvent();
                    
                     //var_dump($newEvent);
                    //save it to model?
                    
                    //$this->model->addEvent($newEvent);
                    //Add to session in model
                    $this->model->saveSelectedSession();
                    
                }

                //Build up output
                $TimeLineEventView = new \view\TimeLineEventView($this->model);
                
                //Output
                $this->timeLineView = new \view\TimeLineView($lineView, $TimeLineEventView, $sendEvent, $listEvents);
        
        }
    }


    public function getView(){
        if ($this->timeLineView != null) {
			return  $this->timeLineView;
		} else {
            //returns first page
			return $this->dateTimeView;
		}
    }
    
}
