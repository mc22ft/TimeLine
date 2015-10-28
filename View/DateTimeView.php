<?php
    
namespace view;

class DateTimeView{
    
    private $calendar;
    private $time;

    public function __construct(CalendarView $cal, SendStartStopTimeView $time){
        $this->calendar = $cal;
        $this->time = $time;
    }

    //Calls in index(view) Handle first page output
    public function getHTML(){
        
        $calenderHTML = $this->calendar->getCalendar();
        $startStopTime = $this->time->getStartStopTime();

        return "<div>
                    <h2>Set your date and time</h2>
                    <div>
                        $calenderHTML
                    </div>
                    <div>
                        $startStopTime
                    </div>
                </div>";
    }
}

