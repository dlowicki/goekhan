<?php

require_once('csv.php');
require_once('updater.php');

if(isset($_POST['update']))
{
    $data = explode(';',$_POST['update']);
    $updater = new Updater();
    $csv = new CSV();


    for ($i=0; $i < sizeof($data)-1; $i++) { 
        $newVersion = $updater->getOneVersion($data[$i]);
        echo "[Validate] Version " . $newVersion . " erkannt für " . $data[$i] . "\r\n";
        if($csv->updateVersionCSV($data[$i],$newVersion)){
            echo "[Validate] Aktualisierung von " . $data[$i] . " auf die Version " . $newVersion . " erfolgreich!" . "\r\n";;
        } else {
            echo "[Validate] Aktualisierung von " . $data[$i] . " fehlgeschlagen!" . "\r\n";;
        }
    }
    return true;
}

// focus
// Wenn Feld angeklickt wurde und danach woanders hingklickt wird erscheint Funktion Focusout

if(isset($_POST['focus']))
{
    $data = explode(';',$_POST['focus']);

    if(sizeof($data) == 3){
        $text = substr($data[1], strlen($data[1])-$data[0],$data[0]);
        $identifier = explode('-',$data[2])[1]; // Identifier (pn = Programm Name)
        $id = explode('-',$data[2])[2]; // ID (CSV Row)

        $csv = new CSV();
        $updater = new Updater();

        if($csv->updateInputCSV($identifier,$id,$text))
        {
            echo "[Validate] " . $identifier . " wurde aktualisiert zu " . $text . "\r\n";
            return true;
        } else {
            echo "[Validate] " . $identifier . " konnte nicht zu " . $text . " aktualisiert werden! \r\n";
            return false;
        }
    }

    echo "[Validate] Fehler bei Datenverarbeitung (Trimmer wurde verwendet) \r\n";
    return false;
}

if(isset($_POST['remove'])){
    $data = explode(';',$_POST['remove']);
    $csv = new CSV();

    for ($i=0; $i < sizeof($data)-1; $i++) { 
        if($csv->removeProgrammCSV($data[$i])){
            echo "[Validate] " . $data[$i] . " wurde erfolgreich entfernt!" . "\r\n";;
        } else {
            echo "[Validate] " . $data[$i] . " konnte nicht entfernt werden!" . "\r\n";;
        }
    }
    return true;
}

?>