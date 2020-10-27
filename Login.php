<?php

$user     = $_REQUEST["n"];
$password = $_REQUEST["x"];

$resultado = "";

$con = mysqli_connect("localhost",$user,$password,"Dante");
if(!$con){
    die("no se puede conectar:".mysqli_connect($con));
}
$resultado ="conexion Exitosa";



echo $resultado;
?> 