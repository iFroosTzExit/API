<?php
include_once("../function/Base.php");
include_once("../function/Funcoes.php");
include_once("../function/Tabela.php");
include_once("../function/API.php");
include("../public/index.html");

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$base = new Base();
$base->start();