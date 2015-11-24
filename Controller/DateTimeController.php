<?php

namespace controller;

require_once("View/DateTimeView.php");
require_once("View/CalendarView.php");
require_once("View/SendStartStopTimeView.php");

/**
 * TimeLineController short summary.
 * First side output. Sows calender and field to set start and stop time.
 * View save session to hold object to TimeLineController
 * TimeLineController description.
 *
 * @version 1.0
 * @author MathiasClaesson
 */   
class DateTimeController
{
    private $timeLineView = null;
    private $model;
    private $navigationView;

    public function __construct(\model\TimeLineModel $model){
        $this->model = $model;
        $this->navigationView = new \view\NavigationView();
    }

    public function doDateTimeSetUp(){

        //SetUp
        $calendarView = new \view\CalendarView();
        $startStopTime = new \view\SendStartStopTimeView($this->model);

        //TimeLine sent?
        if ($this->navigationView->userPressedDoRawTimeLine())
        {
            $newTimeLine = $startStopTime->getTimeLine();
            $startStopTime->doValiadtion($newTimeLine);

            if ($startStopTime->passedValidation())
            {
                $this->model->setSelectedTimeLine($newTimeLine);
                //Add to session in model
                $this->model->saveSelectedSession();
                $startStopTime->redirect();
            }
        }
        
        //If user set a date/time
        if($this->navigationView->userWhantsToSeeCalendar()){
            
            //return: calender och start time and stop time
            

            //First side view
            $this->dateTimeView = new \view\DateTimeView($calendarView, $startStopTime);
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
