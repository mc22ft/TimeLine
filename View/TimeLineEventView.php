<?php
    
namespace view;

class TimeLineEventView{
    
    private $model;
                   
    public function __construct(\model\TimeLineModel $model){
        $this->model = $model;
    }

    public function getTimeLineEventLine(){
        //get time object
        $timeObj = $this->model->getSelectedTimeLine();

        $floatStartTime = $this->remakeTimeToFloat($timeObj->getStartTime());
        $floatStopTime = $this->remakeTimeToFloat($timeObj->getStopTime());
        
        //Numbers of <div> to loop
        $divOut = $floatStopTime - $floatStartTime;
        //And for half houers
        $divOut = $divOut * 2;
        
        //Build up rawTimeLine
        $out = '<table class="TLVtable">
                    <tr>
                        <td>';
                    //set upp times
                    $start =  $timeObj->getStartTime();
                    $stop =  $timeObj->getStopTime();
                    $events = $this->model->getAllEvent();

                    if (empty($events))
                    {
                        $out .= '<div class="TLVtableDiv1">';
                    }else
                    {
                        $out .= '<div class="TLVtableDiv2">';
                    }
                     //var_dump($events);
                     //sort obj array for print out right
                    $events = $this->model->sortEventArray($events);

                     //Array starts at zero
                     $indexCount = 0;
                     $x = 1;
                      //LOOP OUT ID ON DIV 
                         for ($x = 1; $x <= $divOut; $x++) {
                             //for id
                             $floatStartTime += 0.5;
                             $printEmpty = true;
                             //First time events is empty?
                             if(!count($events) == 0){
                                //Here is events set
                                if(isset($events[$indexCount])){
                                    //get first event
                                    $event = $events[$indexCount];
                                    //get array width id
                                    $eventArr = $event->getDivIdArray();
                                    //Looking for fist hit false empty div
                                    if($floatStartTime == $eventArr[0]){
                                        //Spinn at divId in event object
                                        //Last element for design
                                        $lastDiv = end($eventArr);
                                        $arrCount = count($eventArr);
                                        
                                        foreach ($eventArr as $divId){
                                            //first div out if hit
                                            if($floatStartTime == $divId){
                                                //$start = $event->getStartTime();
                                                //$stop = $event->getStopTime();
                                                
                                                $start = $this->addZeroOnTime($event->getStartTime());
                                                $stop = $this->addZeroOnTime($event->getStopTime());
                                                $color = $event->getEventColor();
                                                

                                                if ($arrCount == 1){
                                                	$out .= '<div class="TLVtableDiv30 TLVtableDiv'.$color.'">
                                                                <p class="TLVtableP1">'.$start.'</p>
                                                                <p class="TLVtableP2">'.$stop.'</p>
                                                             </div>';
                                                }else{
                                                    $out .= '<div class="TLVtableDiv3 TLVtableDiv'.$color.'">
                                                                <p class="TLVtableP1">'.$start.'</p>
                                                                <p class="TLVtableP2">'.$stop.'</p>
                                                             </div>';
                                                }
                                                

                                                
                                            }else{
                                                //Last div
                                                if ($lastDiv == $divId)
                                                {
                                                	$out .= '<div class="TLVtableDiv4 TLVtableDiv'.$color.'">
                                                             </div>';
                                                }else
                                                {
                                                    $out .= '<div class="TLVtableDiv5 TLVtableDiv'.$color.'">
                                                             </div>';
                                                }
                                               $floatStartTime += 0.5;
                                               $x++;
                                            } 
                                        }
                                        $indexCount++; //for next event obj
                                        $printEmpty = false; //for empty div
                                    }
                                }
                             }
                             
                             //Print out empty div
                             if($printEmpty){
                                 $out .= '<div class="TLVtableDiv6">
                                              <p></p>
                                          </div>';
                             }
                         }
                    $out .= '</div>';
                    return $out;
    }

    public function remakeTimeToFloat($time){
        //REMOVE : TO . 
        $time = str_replace(":", ".", $time);
        //ZERO RULE
        $time = $this->addZeroOnTime($time);
       
        //Check for half houer must be float
        if(substr($time, -2, 1) == 3){
            //remove "03" and get first end secound character
            $first = substr($time, -5, 1);
            $secound = substr($time, -4, 1);
            $time = $first . $secound;
            //add on end
            $time = $time . ".5";
        }
        //Make string to float
         $time = (float)$time;
        return $time;
    }

    public function addZeroOnTime($time) {
		//ZERO RULE
        if(strlen($time) == 4){ 
            //true add zero at beginngin
            $time = "0" . $time;
        }
        return $time;
	}
}