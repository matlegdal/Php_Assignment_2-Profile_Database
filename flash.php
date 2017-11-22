<?php
if ( isset($_SESSION['error']) ) {
    $message = '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    $message = '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}