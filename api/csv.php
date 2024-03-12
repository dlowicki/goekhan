<?php

// API zum laden der CSV Datei passend für die index.php
require("lastupdate.php");

//define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
// Schon aus lastupdate.php

class CSV
{
    private $path = LOCAL_PATH_ROOT . "/html/goekhan/data/data.csv";
    private $pathINI = LOCAL_PATH_ROOT . "/html/goekhan/data/link.ini";
    private $content = array();

    public function loadCSV() {
        $this->content = array();
        if (($handle = fopen($this->path, "r")) !== FALSE) {
            $count = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $this->content[$count] = $data;
                $count++;
            }
            fclose($handle);
            return true;
        }
        return false;
    }

    // editCSV
    public function updateVersionCSV($id, $version) {
        if (($handle = fopen($this->path, "r")) !== FALSE) {
            $count = 0; $temp = array(); $content = array();
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {               
                $csvData = explode(';',$data[0]);

                if($csvData[0] == $id)
                {
                    $temp[0] = $csvData[0]; // ID
                    $temp[1] = $csvData[1]; // Name
                    $temp[2] = $version; // Version Internet
                    $temp[3] = $csvData[3]; // Version Datenbank
                    $temp[4] = $csvData[4]; // Entpack Methode
                    $temp[5] = $csvData[5]; // Tooltip
                    $temp[6] = $csvData[6]; // Kategorie
                    $temp[7] = $csvData[7]; // Bemerkung
                    $temp[8] = $csvData[8]; // Löschgrund
                    $strTemp = implode(';',$temp);
                    array_push($content,$strTemp);
                } else {
                    $temp[0] = $csvData[0]; // ID
                    $temp[1] = $csvData[1]; // Name
                    $temp[2] = $csvData[2]; // Version Internet
                    $temp[3] = $csvData[3]; // Version Datenbank
                    $temp[4] = $csvData[4]; // Entpack Methode
                    $temp[5] = $csvData[5]; // Tooltip
                    $temp[6] = $csvData[6]; // Kategorie
                    $temp[7] = $csvData[7]; // Bemerkung
                    $temp[8] = $csvData[8]; // Löschgrund
                    $strTemp = implode(';',$temp);
                    array_push($content,$strTemp);
                }
            }
            fclose($handle);

            $file = fopen($this->path, 'w');
            for ($i=0; $i < sizeof($content); $i++) {
                $ar = array(); array_push($ar,$content[$i]);
                fputcsv($file, $ar, ";");
            }
            if(fclose($file))
            {
                updateTime();
                return true;
            }
        }
        return false;
    }

    // remove Programm from CSV
    public function removeProgrammCSV($id){
        if (($handle = fopen($this->path, "r")) !== FALSE) {
            $count = 0; $temp = array(); $content = array();
            $r = 1;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {               
                $csvData = explode(';',$data[0]);
                if($csvData[0] != $id)
                {
                    $temp[0] = $r; // ID
                    $temp[1] = $csvData[1]; // Name
                    $temp[2] = $csvData[2]; // Version Internet
                    $temp[3] = $csvData[3]; // Version Datenbank
                    $temp[4] = $csvData[4]; // Entpack Methode
                    $temp[5] = $csvData[5]; // Tooltip
                    $temp[6] = $csvData[6]; // Kategorie
                    $temp[7] = $csvData[7]; // Bemerkung
                    $temp[8] = $csvData[8]; // Löschgrund
                    $strTemp = implode(';',$temp);
                    array_push($content,$strTemp);
                    $r++;
                }
            }
            fclose($handle);

            $file = fopen($this->path, 'w');
            for ($i=0; $i < sizeof($content); $i++) {
                $ar = array(); array_push($ar,$content[$i]);
                fputcsv($file, $ar, ";");
            }
            if(fclose($file))
            {
                $this->removeProgrammLink($id);
                return true;
            }
        }
        return false;
    }

    // Parameter = Splitt from ID of element
    // Identifier (pn = Programm Name)
    // ID = (CSV Row)
    public function updateInputCSV($identifier, $id, $text) {
        if (($handle = fopen($this->path, "r")) !== FALSE) {
            $count = 0; $temp = array(); $content = array();

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {               
                $csvData = explode(';',$data[0]);

                if($csvData[0] == $id)
                {
                    echo $id . " - " . $identifier . " - " . $text;
                    $temp[0] = $csvData[0]; // ID
                    if($identifier == 'pn') { $temp[1] = $text; } else { $temp[1] = $csvData[1]; }
                    if($identifier == 'vi') { $temp[2] = $text; } else { $temp[2] = $csvData[2]; }
                    if($identifier == 'vd') { $temp[3] = $text; } else { $temp[3] = $csvData[3]; }
                    if($identifier == 'ht') { $temp[4] = $text; } else { $temp[4] = $csvData[4]; }
                    if($identifier == 'tt') { $temp[5] = $text; } else { $temp[5] = $csvData[5]; }
                    if($identifier == 'kg') { $temp[6] = $text; } else { $temp[6] = $csvData[6]; }
                    if($identifier == 'bg') { $temp[7] = $text; } else { $temp[7] = $csvData[7]; }
                    if($identifier == 'dl') { $temp[8] = $text; } else { $temp[8] = $csvData[8]; }
                    $strTemp = implode(';',$temp);
                    array_push($content,$strTemp);
                } else {
                    $temp[0] = $csvData[0]; // ID
                    $temp[1] = $csvData[1]; // Name
                    $temp[2] = $csvData[2]; // Version Internet
                    $temp[3] = $csvData[3]; // Version Datenbank
                    $temp[4] = $csvData[4]; // Entpack Methode
                    $temp[5] = $csvData[5]; // Tooltip
                    $temp[6] = $csvData[6]; // Kategorie
                    $temp[7] = $csvData[7]; // Bemerkung
                    $temp[8] = $csvData[8]; // Löschgrund
                    $strTemp = implode(';',$temp);
                    array_push($content,$strTemp);
                }
            }

            $file = fopen($this->path, 'w');
            for ($i=0; $i < sizeof($content); $i++) {
                $ar = array(); array_push($ar,$content[$i]);
                fputcsv($file, $ar, ";");
            }
            if(fclose($file))
            {
                updateTime(); // Funktion aus lastupdate.php
                return true;
            }
        }
        return false;
    }

    private function removeProgrammLink($id) {
        $data = parse_ini_file($pathINI, false);
        $input = "";
        foreach ($data as $key => $value) { if($key != $id){ $input = $input . "$key=$value"; } }
        $handle = fopen('../data/link.ini','w');
        fwrite($handle, $input);
        fclose($handle);
    }


    public function getContent(){ return $this->content; }

    
}




?>