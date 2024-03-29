<?php

//define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);

class Updater
{
    private $linkpath = LOCAL_PATH_ROOT . "/html/goekhan/data/link.ini";
    private $version = array();

    function getAllVersions() {
        $ini_array = parse_ini_file($this->linkpath);
        foreach ($ini_array as $key => $value) {
            $source = file_get_contents($value);
    
            $doc = new DOMDocument;
            @$doc->loadHTML($source);
        
            $xpath = new DOMXPath($doc);
            $classname = "dl-version";
            $elements = $xpath->query("//*[contains(@class, '$classname')]");
            $version = "";
        
            foreach ($elements as $e) { $version = $e->ownerDocument->saveXML($e); }
            $tmp = explode(">", $version);
            $tmp2 = explode("<", $tmp[1]);
            $tmp3 = explode("Version ", $tmp2[0]);
            array_push($this->version,$tmp3[1]);
        }
        return $this->version;
    }

    function getOneVersion($id) {
        $ini_array = parse_ini_file($this->linkpath);
        if(array_key_exists($id,$ini_array))
        {
            $source = file_get_contents($ini_array[$id]);
            $doc = new DOMDocument;
            @$doc->loadHTML($source);
            
            $xpath = new DOMXPath($doc);
            $classname = "dl-version";
            $elements = $xpath->query("//*[contains(@class, '$classname')]");
            $version = "";
            
            foreach ($elements as $e) { $version = $e->ownerDocument->saveXML($e); }
            $tmp = explode(">", $version);
            $tmp2 = explode("<", $tmp[1]);
            $tmp3 = explode("Version", $tmp2[0]);
            return trim($tmp3[1]);
        }
        return false;
    }

}


?>