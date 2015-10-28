<?php

namespace model;

class SessionHandeler {
    
    private $sessionTimeLine;
    
    public function __construct($sessionTimeLine) {
		$this->sessionLine = $sessionTimeLine;
		//Make sure we have a session
		assert(isset($_SESSION));
	}

    //Set start/stop line object in session
	public function saveSession($newTimeLine) {
		$_SESSION[$this->sessionTimeLine] = $newTimeLine;
	}

    public function saveSelectedSession($selectedTimeLine) {
		$_SESSION[$this->sessionTimeLine] = $selectedTimeLine;
	}

    public function getSession(){
        return $_SESSION[$this->sessionTimeLine];
    }
    //Set
    //Delete session
    public function delete() {
		unset($_SESSION[$this->sessionTimeLine]);
	}
}