<?php

namespace model;

require_once("Model/SessionUser.php");

class SessionHandeler {
    
    private $sessionTimeLine;
    private $idSession;
    private $sessObj;
    
    public function __construct($sessionTimeLine, $idSession) {
		$this->sessionLine = $sessionTimeLine;
        $this->idSession = $idSession;
        $this->sessObj = new \model\SessionUser($_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		//Make sure we have a session
		assert(isset($_SESSION));
	}

    //Set start/stop line object in session
	public function saveSession($newTimeLine) {
		$_SESSION[$this->sessionTimeLine] = $newTimeLine;
        $_SESSION[$this->idSession] = $this->sessObj;
	}

    public function getSession(){
        return $_SESSION[$this->sessionTimeLine];
    }
    //Set
    //Delete session
    public function delete() {
		unset($_SESSION[$this->sessionTimeLine]);
	}

    //Compare this user, if ip number and browser is the same
    public function isSessionSet() {
        if (isset($_SESSION[$this->idSession]) && isset($this->sessObj)) {
            if($_SESSION[$this->idSession]->getIp() === $this->sessObj->getIp() &&
                    $_SESSION[$this->idSession]->getBrowser() === $this->sessObj->getBrowser()){
                return TRUE;
            }
		}
        return FALSE;
	}
}