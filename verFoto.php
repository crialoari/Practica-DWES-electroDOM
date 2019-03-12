<?php
include("BBDD.php");
$codigo=$_REQUEST['n'];
$tipo_foto=BBDD::getExt($codigo);
    header("Content-type: $tipo_foto");
    echo BBDD::getFoto($codigo);
?>


