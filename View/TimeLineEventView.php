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
        $out = '<table style="width:100%; border-spacing: 0;
                        border-collapse: collapse;">
                    <tr>
                        <td>';
                    //set upp times
                    $out .= '<div style="
                                    width: 96%;
                                    margin:auto;
                                    display: table;
                                    table-layout: fixed;
                                    margin-bottom: 100px;
                                    ">';

                     $start =  $timeObj->getStartTime();
                     $stop =  $timeObj->getStopTime();

                     $events = $this->model->getAllEvent();
                     //var_dump($events);
                     //sort obj array for print out right
                     usort($events, function ($item1, $item2) {
                          $ts1 = strtotime($item1->getStartTime());
                          $ts2 = strtotime($item2->getStartTime());
                           if ($ts1 == $ts2) {
                               return 0;
                           }
                           return ($ts1 < $ts2) ? -1 : 1;
                        });
                   
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
                                    //var_dump($event->getDivIdArray());
                                    
                                    //Looking for fist hit false empty div
                                    if($floatStartTime == $eventArr[0]){
                                        //Spinn at divId in event object
                                        foreach ($eventArr as $divId){
                                            //first div out if hit
                                            if($floatStartTime == $divId){
                                                $start = $event->getStartTime();
                                                $out .= '<div class="" style="
                                                    color: black;
                                                    background-color: red;
                                                    display: table-cell;
                                                    "><p  style="
                                                        color: black;
                                                        text-align: center;
                                                    ">'.$start.'</p></div>';
                                            }else{
                                                $out .= '<div class="" style="
                                                    background-color: red;
                                                    display: table-cell;
                                                    "></div>';
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
                                 $out .= '<div class="empty" style="
                                            display: table-cell;
                                            "><p></p></div>';
                             }
                         }
                    $out .= '</div>';
                    return $out;
    }

    public function remakeTimeToFloat($time){
        //REMOVE : TO . 
        $time = str_replace(":", ".", $time);

        //ZERO RULE
        if(strlen($time) == 4){ //true add zero at beginngin
            $time = "0" . $time;
        }
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
}