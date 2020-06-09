<?php

function escape($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function dd($data){
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
	die;
}