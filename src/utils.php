<?php

require_once 'src/config.php';
require_once 'src/fetch.php';

class utils {

    public function __construct() {
        $this->fetch            = new fetch();
        $this->TELEGRAM_API_KEY = TELEGRAM_API_KEY;
        $this->TELEGRAM_CHAT_ID = TELEGRAM_CHAT_ID;
    }

    public function filterArrayDomains(Array $arrayDomains) : Array {
        echo "FILTERING DOMAINS...".PHP_EOL;
    
        $newDomains = array();
        foreach($arrayDomains as $domain) {
            $statusCode = $this->fetch::httpCode("https://$domain");
    
            echo "$domain || STATUSCODE $statusCode";
            if ($statusCode == 200) array_push($newDomains, $domain);
        }
    
        return $newDomains;
    }
    
    public function filterDomain(String $domain) : bool {
        echo "CHECKING $domain...".PHP_EOL;
    
        $statusCode = $this->fetch::httpCode("https://$domain");
        echo "$domain || STATUSCODE $statusCode".PHP_EOL;
    
        if ($statusCode != 200) return false;
    
        return true;
    }
    
    public function appendScanned($domain) {
        file_put_contents('data/scanned.txt', PHP_EOL.$domain, FILE_APPEND);
    }
    
    public function saveResult($result, $domain, $timestampFile) {
        file_put_contents("data/results/$domain$timestampFile.txt", $result);
    }
    
    public function sendMessage($scanResultsData) {    
        $this->TELEGRAM_URL = "https://api.telegram.org/bot$this->TELEGRAM_API_KEY/sendMessage";
        $DATA         = array(
            "chat_id" => $this->TELEGRAM_CHAT_ID,
            "text"    => $scanResultsData,
        );
    
        $this->fetch::post($this->TELEGRAM_URL, $DATA);
    }
    
}