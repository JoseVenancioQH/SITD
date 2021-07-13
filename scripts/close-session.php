<?php
	include("include/dbcon.php");
    require "clases/class.dbsession.php";
    $session = new dbsession();
    $session->stop();
	header("Location: ../login.php?action=bye");
?>
