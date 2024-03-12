<?php

/*
API Log created 12.03.2024
by Mertero
*/

class Log
{

    private $logPath = LOCAL_PATH_ROOT . "/html/goekhan/log.txt";
    private $syntax = "[Log] ";

    public function checkLogExist() {
        if(file_exists($this->logPath))
        {
            return true;
        }
        touch($this->logPath);
        $this->addLog("Log Datei wurde erstellt.");
        return true;
    }

    public function addLog($input){
        $handle = fopen($this->logPath,'a');
        if(fwrite($handle,$this->getSyntax() . $input . "\r\n")){
            fclose($handle);
            return true;
        }
        return false;
    }

    private function getSyntax(){
        $dt = new DateTime();
        return $this->syntax . $dt->format('d-m-Y H:i:s') . " >> ";
    }
    
    public function setSyntax($syntax){
        $this->syntax = $syntax;
    }
}


?>