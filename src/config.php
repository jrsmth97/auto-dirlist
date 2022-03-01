<?php

define('DIRSEARCH_PATH',"dirsearch/dirsearch.py");
define('DIRSEARCH_DIR',"dirsearch");

define('EXCLUDE_STATUS_SCAN',"429,400,401,404,406,403,500,302,301,307,502,503,520");

define('TELEGRAM_CHAT_ID', 12345);
define('TELEGRAM_API_KEY', "xxxAPIKEY");

define('REPO_URL', "https://raw.githubusercontent.com/arkadiyt/bounty-targets-data/master/data/");

define('JSON_FILE', array(
    'bugcrowd'    => "bugcrowd_data.json",
    'federacy'    => "federacy_data.json",
    'hackenproof' => "hackenproof_data.json",
    'hackerone'   => "hackerone_data.json", 
    'intigrity'   => "intigriti_data.json", 
    'yeswehack'   => "yeswehack_data.json", 
));

define('TXT_FILE', array(
    'domains'    => "domains.txt",
    'wildcards'  => "wildcards.txt",
));
