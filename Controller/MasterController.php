<?php

namespace controller;

require_once("Controller/DateTimeController.php");
require_once("Controller/TimeLineController.php");
require_once("View/NavigationView.php");
require_once("Model/TimeLineModel.php");
require_once("Model/SessionHandeler.php");

/**
 * MasterController short summary.
 *
 * MasterController description.
 *
 * @version 1.0
 * @author MathiasClaesson
 */
class MasterController
{
    private $navigationView;
    private $model;

    public function __construct(){  
        $session = new \model\SessionHandeler("ObjSessionHolder", "IdSession");
        $this->model = new \model\TimeLineModel($session);
        $this->navigationView = new \view\NavigationView();
    }
 
    //Starts app
    public function handleInput(){
        
        //Go to set time and date?
        if ($this->navigationView->inCalendar()){
        	
            //Create timeline controller
            $doDateTime = new \controller\DateTimeController($this->model); 

            //Render set up
			$doDateTime->doDateTimeSetUp();

			//Generate output
			$this->view = $doDateTime->getView();
        }

        //Go to TimeLine?
        if ($this->navigationView->inTimeLine()){
        	
            //Create timeline controller
            $doTimeLine = new \controller\TimeLineController($this->model); 

            //Render set up
			$doTimeLine->doTimeLineSetUp();

			//Generate output
			$this->view = $doTimeLine->getView();
        }
    }

    //return view to output
    public function generateOutput() {
		return $this->view;
	}
}
