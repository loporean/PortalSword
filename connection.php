<?php
session_start();
	$dbhost = "localhost";
	$dbuser = "";
	$dbpass = "";
	$dbname = "";
	$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	if(!$con)
	{
		die("failed to connect!");
	}

