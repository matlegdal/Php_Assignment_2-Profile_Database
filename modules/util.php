<?php
function flash() {
	if ( isset($_SESSION['error']) ) {
	    $flash = '<div class="alert alert-danger">'.$_SESSION['error']."</div>\n";
	    unset($_SESSION['error']);
	    return $flash;
	}
	if ( isset($_SESSION['success']) ) {
	    $flash = '<div class="alert alert-success">'.$_SESSION['success']."</div>\n";
	    unset($_SESSION['success']);
	    return $flash;
	}
}