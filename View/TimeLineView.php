<?php

namespace view;

class TimeLineView{
    
    private $line;
    private $timeLineEvent;
    private $event;
    //private $message;
    private $listEvents;

    public function __construct(EmptyLineView $line, TimeLineEventView $timeLineEvent, SendEventView $event, ListEvents $istEvents){
        $this->line = $line;
        $this->timeLineEvent = $timeLineEvent;
        $this->event = $event;
        $this->listEvents = $istEvents;
    }

    //Calls in index(view) Presents event view
    public function getHTML(){
        
        $lineHTML = $this->line->getLine();
        $timeLineEventHTML = $this->timeLineEvent->getTimeLineEventLine();
        $eventFormHTML = $this->event->getEvent();
        $listEventsFormHTML = $this->listEvents->getListEvents();

        return "<div>
                    <h2>Set up events</h2>
                    <div>
                        $lineHTML
                    </div>

                    <div>
                        $timeLineEventHTML
                    </div>

                    <div>
                        $eventFormHTML
                    </div>

                    <div>
                        $listEventsFormHTML
                    </div>

                </div>";
    }
}
