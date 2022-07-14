<?php

// API zum laden der CSV Datei passend für die index.php

class CSV
{
    private $path = "data/data.csv";
    private $content = array();

    public function loadCSV() {
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

    // safeCSV


    public function getContent(){
        return $this->content;
    }

    
}

$csv = new CSV();
$csv->loadCSV();


?>