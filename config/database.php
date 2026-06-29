<?php

$host="localhost";
$user="root";
$password="";
$db="image_manager";

$conn=new mysqli($host,$user,$password,$db);

if($conn->connect_error){

    die("Database Connection Failed");

}