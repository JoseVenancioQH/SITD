<?php
    $mySQLHost = "localhost";
    $mySQLUsername = "root";
    $mySQLPassword = "";
    $mySQLDatabase = "sitdbcs";
    $link = mysql_connect($mySQLHost, $mySQLUsername, $mySQLPassword);
    if(!$link){die ("Could not connect to database!");}
    $db = mysql_select_db($mySQLDatabase, $link);
    if(!$db){die ("Could not select database!");}
?>