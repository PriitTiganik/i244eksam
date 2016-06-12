<?php
require_once("functions.php");
alusta_sessioon();

ini_set("display_errors", 1);

$mode="";

if(isset($_GET["mode"])){
    $mode=$_GET["mode"];
} else {
    $mode="index";
}

switch($mode) {
    case "comments":
        upload_comment();
        kuva_comments();
        break;
    case "index":
        kuva_insert();
        break;

}
