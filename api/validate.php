<?php

require_once('csv.php');
require_once('updater.php');
require_once('log.php');


if(isset($_POST['update']))
{
    $data = explode(';',$_POST['update']);
    $updater = new Updater();
    $csv = new CSV();
    $log = new Log();
    $log->setSyntax('[Validate][Update] ');


    for ($i=0; $i < sizeof($data)-1; $i++) { 
        $newVersion = $updater->getOneVersion($data[$i]);
        if($newVersion == false){ 
            echo "[Validate] Kein Chip Link in 'link.ini' gefunden zu ID " . $data[$i];
            $log->addLog("Kein Chip Link in 'link.ini' gefunden zu ID " . $data[$i]);
        } else {
            echo "[Validate] Version " . $newVersion . " erkannt für " . $data[$i] . "\r\n";
            $log->addLog("Version " . $newVersion . " erkannt für " . $data[$i]);
            if($csv->updateVersionCSV($data[$i],$newVersion)){
                echo "[Validate] Aktualisierung von " . $data[$i] . " auf die Version " . $newVersion . " erfolgreich!" . "\r\n";
                $log->addLog("Aktualisierung von " . $data[$i] . " auf die Version " . $newVersion . " erfolgreich!");
            } else {
                echo "[Validate] Aktualisierung von " . $data[$i] . " fehlgeschlagen!" . "\r\n";
                $log->addLog("Aktualisierung von " . $data[$i] . " fehlgeschlagen!");
            }
        }

    }
    return true;
}

// focus
// Wenn Feld angeklickt wurde und danach woanders hingklickt wird erscheint Funktion Focusout

if(isset($_POST['focus']))
{
    $log = new Log();
    $log->setSyntax('[Validate][Focus] ');

    $data = explode(';',$_POST['focus']);
    // $data[0] = Text length
    // $data[1] = Input from textfield
    // $data[2] = id from element (field-kg-1)

    if(sizeof($data) == 3){
        $text = substr($data[1], strlen($data[1])-$data[0],$data[0]); 
        $identifier = explode('-',$data[2])[1]; // Identifier (pn = Programm Name)
        $id = explode('-',$data[2])[2]; // ID (CSV Row)
        print_r($data);
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
    $log->addLog("[Validate] Fehler bei Datenverarbeitung (Trimmer wurde verwendet)");
    return false;
}

if(isset($_POST['remove'])){
    $data = explode(';',$_POST['remove']);
    $csv = new CSV();
    $log = new Log();
    $log->setSyntax('[Validate][Remove] ');

    for ($i=0; $i < sizeof($data)-1; $i++) { 
        if($csv->removeProgrammCSV($data[$i])){
            echo "[Validate] " . $data[$i] . " wurde erfolgreich entfernt!" . "\r\n";
            $log->addLog("" . $data[$i] . " wurde erfolgreich entfernt!");
        } else {
            echo "[Validate] " . $data[$i] . " konnte nicht entfernt werden!" . "\r\n";
            $log->addLog("" . $data[$i] . " konnte nicht entfernt werden!");
        }
    }
    return true;
}

?>