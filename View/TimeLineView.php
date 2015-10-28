<?php

namespace view;

class TimeLineView{
    
    private $line;
    private $timeLineEvent;
    private $event;
    private $message;

    public function __construct(EmptyLineView $line, TimeLineEventView $timeLineEvent, SendEventView $event, $message){
        $this->line = $line;
        $this->timeLineEvent = $timeLineEvent;
        $this->event = $event;
        $this->message = $message;
    }

    //Calls in index(view) Presents event view
    public function getHTML(){
        
        $lineHTML = $this->line->getLine();
        $timeLineEventHTML = $this->timeLineEvent->getTimeLineEventLine();
        $eventFormHTML = $this->event->getEvent($this->message);

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

                </div>";
    }
}
