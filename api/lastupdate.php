<?php

define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);

if(isset($_GET['display']))
{
    $content = file_get_contents(LOCAL_PATH_ROOT . "/html/goekhan/data/lastupdate.txt", true);
    echo $content;
    return true;
}

if(isset($_GET['update']))
{
    updateTime();
    return true;
}

function updateTime(){
    date_default_timezone_set('Europe/Berlin');
    $dt = new DateTime();

    ini_set("display_error","off");
    $fileTemp = fopen(LOCAL_PATH_ROOT . "/html/goekhan/data/lastupdate.txt","w");
    fwrite($fileTemp, $dt->format('d-m-Y H:i'));
    ini_set("display_error","on");

    fclose($fileTemp);
    return true;
}

?>