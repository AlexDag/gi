<?php
ob_start();
session_start();
$timeout = 60*60; // Number of seconds until it times out.

// Check if the timeout field exists.
if(isset($_SESSION['timeout'])) {
    $duration = time() - (int)$_SESSION['timeout'];
    if($duration > $timeout) {
        // Destroy the session and restart it.
        session_destroy();
        //session_start();
        header('Location: index.php');
    }
}

// Update the timout field with the current time.
$_SESSION['timeout'] = time();


echo "
<div data-theme=\"a\" data-role=\"header\" data-position=\"fixed\" >
 <a style='margin-left:  20px;' data-role=\"button\" data-rel=\"back\" data-iconpos=\"notext\" data-icon=\"back\" data-theme=\"a\" data-inline=\"true\" class=\"ui-btn-left\">Back</a>
	 <p>".$_SESSION['usuario'].

				"<a href=\"logout.php\">logout</a>
                </p>

</div>
<div class=\"ui-grid-a ui-responsive header2\">
<div data-role=\"panel\" id=\"nuevo_panel\" data-display=\"overlay\">
   <ul id=\"nuevopanelUL\" data-role=\"listview\" data-theme=\"d\" data-icon=\"false\">

            <li data-icon=\"home\" ><a href=\"\" rel=\"external\">T1</a></li>
            <li data-icon=\"plus\" ><a href=\"\" rel=\"external\">T2</a></li>
            <li data-icon=\"plus\"><a href=\"\" rel=\"external\" >T3</a></li>
   </ul>
	
</div><!-- /panel -->

</div>
";


?>
