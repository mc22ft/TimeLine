<?php

namespace view;

/**
 * HTMLView short summary.
 *
 * HTMLView description.
 *
 * @version 1.0
 * @author MathiasClaesson
 */
class HTMLView
{
    /**
     * @return String HTML
     */
	public function getHTMLPage($body) {
        $this->charset = "utf-8";
        
		return "
            <!DOCTYPE html>
       <html>
         <head>
          <meta charset=\"" . $this->charset . "\">
          <link rel='stylesheet' href='Css/main.css' type='text/css'>
          <title>Event Maker</title>
        </head>
        <body>
        <h1>Time Line Event Maker</h1>
         <div>
            $body
         </div>
        </body>
      </html>";
	}

}
