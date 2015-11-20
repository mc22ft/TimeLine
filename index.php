<?php

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//INCLUDE THE FILES NEEDED...

require_once("Controller/MasterController.php");
require_once("View/HTMLView.php");

session_start();

//phpinfo();
$mc = new \controller\MasterController();

//Start app in Mastercontroller
$mc->handleInput();

//Get right view
$view = $mc->generateOutput();

//Create HTML
$htmlView = new \view\HTMLView();

//Add HTML view 
echo $htmlView->getHTMLPage($view->getHTML());
