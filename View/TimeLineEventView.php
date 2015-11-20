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
                        border-collapse: separate !important;">
                    <tr>
                        <td>';
                    //set upp times
                    
                    
                    $start =  $timeObj->getStartTime();
                    $stop =  $timeObj->getStopTime();
                    $events = $this->model->getAllEvent();

                    if (empty($events))
                    {
                        $out .= '<div style="
                                    width: 96%;
                                    margin:auto;
                                    display: table;
                                    table-layout: fixed;
                                    margin-bottom: 89px;
                                    ">';
                    }else
                    {
                        $out .= '<div style="
                                    width: 96%;
                                    margin:auto;
                                    display: table;
                                    table-layout: fixed;
                                    margin-bottom: 33px;
                                    ">';
                    }
                    
                    
                     
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

                                        //Last element for design
                                        $lastDiv = end($eventArr);


                                        foreach ($eventArr as $divId){
                                            //first div out if hit
                                            if($floatStartTime == $divId){
                                                $start = $event->getStartTime();
                                                $stop = $event->getStopTime();
                                                $out .= '<div class="" style="

                                                    background-color: #5bc0de;
                                                    display: table-cell;
                                                    border-radius: 6px 0px 0px 6px;
                                                    -moz-border-radius: 6px 0px 0px 6px;
                                                    -webkit-border-radius: 6px 0px 0px 6px;
                                                    border: 1px solid #555;
                                                    border-right: 0;
                                                    "><p  style="
                                                        color: #333;
                                                        text-align: center;
                                                        margin-top: 10px;
                                                    ">'.$start.'</p><p  style="
                                                        color: #333;
                                                        text-align: center;
                                                        
                                                    ">'.$stop.'</p></div>';
                                            }else{
                                                //Last div
                                                if ($lastDiv == $divId)
                                                {
                                                	$out .= '<div class="" style="
                                                    background-color: #5bc0de;
                                                    display: table-cell;
                                                    border-radius: 0px 6px 6px 0px;
                                                    -moz-border-radius: 0px 6px 6px 0px;
                                                    -webkit-border-radius: 0px 6px 6px 0px;
                                                    border: 1px solid #555;
                                                    border-left: 0;
                                                    "></div>';
                                                }else
                                                {
                                                    $out .= '<div class="" style="
                                                    background-color: #5bc0de;
                                                    display: table-cell;
                                                    border: 1px solid #555;
                                                    border-left: 0;
                                                    border-right: 0;
                                                    "></div>';
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