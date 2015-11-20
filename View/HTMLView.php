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
          <link href='Css/bootstrap.min.css' rel='stylesheet'>
          <title>Event Maker</title>
        </head>
            <body>
                <div class='container'>
                    <h1 class='text-center'>Time Line Event Maker</h1>
                    <div>
                        $body
                    </div>
                </div>
            </body>
      </html>";
	}

}
