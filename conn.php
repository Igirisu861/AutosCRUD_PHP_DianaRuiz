<?php

$db_host = 'localhost';
$db_username = 'Admin';
$db_pass = 'DoomSlayer1993';
$db_database = 'carstore';

$db = new mysqli($db_host,$db_username,$db_pass,$db_database);
mysqli_query($db,"SET NAMES 'utf8");
if($db->connect_error>0){
    die('No es posible conectarse a la DB['.$db->connect_error.']');
}