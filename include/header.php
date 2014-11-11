<?php
ob_start();

//include_once("include/class_db.php");
include_once("include/class_template.php");
include_once("include/functions.php");

###############################################################################
#
# create database object and connect 
#
//$db = new db();
//$db->connect("user", "pass", "host", "db");

$template = new template("templates/main.html");
?>
