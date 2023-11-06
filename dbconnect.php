<?php
    $servername = "202.28.34.197";
    $username    = "web65_64011212101";
    $password   = "64011212101@csmsu";
    $dbname     = "web65_64011212101";

    $dbconn= new mysqli($servername,$username,$password,$dbname);
    if($dbconn->connect_error){
        die("connection Error : " + $dbconn->connect_error);
    }
?>