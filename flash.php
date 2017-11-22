<?php
if ( isset($_SESSION['error']) ) {
    $flash = '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    $flash = '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}