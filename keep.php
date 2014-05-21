<?php

if (isset($_POST['presentation_info']) ){

	$temp = split("`",  $_POST['presentation_info']);

	$title = $temp[0];
	$slideNumber = $temp[1];

	if( isset($_POST['selectPage']) ) 	$slideNumber = $_POST['selectPage'];
	if( isset($_POST['slideBack']) ) 	$slideNumber = $temp[1] -1;
	if( isset($_POST['slideForward']) ) $slideNumber = $temp[1] +1;

	$cookie_name = str_replace(" ", "_" , "wiki_presentation_$title");
	setcookie($cookie_name, trim($slideNumber));

	header("Location: " . $_SERVER['REQUEST_URI']);
}

