<?php

namespace view;

class EmptyLineView{
    
    private $model;
                   
    public function __construct(\model\TimeLineModel $model){
        $this->model = $model;
    }

    public function getLine(){
         
        //get time object
        $timeObj = $this->model->getSelectedTimeLine();

        $floatStartTime = $this->remakeTimeToFloat($timeObj->getStartTime());
        $floatStopTime = $this->remakeTimeToFloat($timeObj->getStopTime());

        //Numbers of <div> to loop
        $divOut = $floatStopTime - $floatStartTime;
        //And for half houers 
        //(half houer not in use in this version but it is there)
        $divOut = $divOut * 2;

        $date = $timeObj->getDate();
        $out = '<h2 class="ELVh2">'.$date.'</h2>';

        //Build up rawTimeLine
        $out .= '<table class="ELVtable">
                    <tr>
                        <td>';
                     //set upp times
                     $out .= '<div class="ELVtableDiv1">';

                     $start =  $timeObj->getStartTime();
                     $stop =  $timeObj->getStopTime();

                      if(strlen($start) == 4){ 
                          //true add zero at beginngin
                          $start = "0" . $start;
                      }
                        
                      $nextHouer = $start;
                      //LOOP OUT TIME 
                         for ($x = 1; $x <= $divOut; $x++) {
                             if($x % 2 == 0){
                                  //Even
                                  if($x == $divOut){ 
                                      //last = set stop time
                                      $out .= '<div class="ELVtableDiv2">
                                                   <p class="ELVtableP1">'.$nextHouer.'</p>
                                               </div>';
                                  }else{
                                      $out .= '<div class="ELVtableDiv2">
                                                   <p></p>
                                               </div>';
                                  }
                             }else{
                                 $out .= '<div class="ELVtableDiv2">
                                              <p class="ELVtableP2">'.$nextHouer.'</p>
                                          </div>';
                                 $nextHouer = $this->addOneHouer($nextHouer);
                             }
                         }
                    $out .= '</div>';

                    //set upp raw timeline
                    $out .= '<div class="ELVrawDiv1">';
                    for ($x = 1; $x <= $divOut; $x++) {
                        if($x % 2 == 0){
                            //even
                             if($x == $divOut){
                                 $out .= '<div class="ELVrawDiv2">
                                              <p></p>
                                              <p>|</p>
                                          </div>';
                             }else{
                                 $out .= '<div class="ELVrawDiv3">
                                              <p>|</p>
                                          </div>';
                             }
                        }else{
                            $out .= '<div class="ELVrawDiv4">
                                    </div>';
                        }
                    }
                    $out .= '</div>';
         $out .= '</td>
                </tr>
              </table>';
         $out .= '<div class="ELVrawDiv5">
                  </div>';
            return $out;
    }

    public function addOneHouer($time){
        //ex. in string "07:00"
        //get two first and do to int
         $first = substr($time, -5, 1);
         $secound = substr($time, -4, 1);
         $time = $first . $secound;
         //"07"
         $time = (int)$time;
         //Add 1 houer
         $time = $time + 1;
         //Buld up string
         $time = (string)$time;
         $time .=":00";
         //"08:00"
         if(strlen($time) == 4){ 
            //true add zero at beginngin
            $time = "0" . $time;
         }
         return $time;
    }

    public function remakeTimeToFloat($time){
        //REMOVE : TO . (for half houers)
        $time = str_replace(":", ".", $time);

        //ZERO RULE
        if(strlen($time) == 4){ 
            //true add zero at beginngin
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