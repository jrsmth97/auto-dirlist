<?php

date_default_timezone_set('Asia/Jakarta');

require_once 'src/config.php';
require_once 'src/fetch.php';
require_once 'src/utils.php';

$fetch        = new fetch();
$utils        = new utils();

$domainSource = REPO_URL.TXT_FILE['domains'];
$dirsearch    = DIRSEARCH_PATH;
$rawDomains   = $fetch::get($domainSource);

$scanned      = preg_split('/[\r\n]/', file_get_contents('data/scanned.txt'));
$arrayDomains = preg_split('/[\r\n]/', $rawDomains);

$statusExclude = EXCLUDE_STATUS_SCAN;

for($i = 0; $i < sizeof($arrayDomains); $i++) {
    $isScanned = in_array($arrayDomains[$i], $scanned);
    if ($isScanned) continue;
    
    $utils->appendScanned($arrayDomains[$i]);
    $activeDomain = $utils->filterDomain($arrayDomains[$i]);

    if (!$activeDomain) continue;
    
    echo ($i+1)."/".sizeof($arrayDomains)." DOMAINS".PHP_EOL;

    $execTime  = date("y-m-d_H-i-s");
    $execDate  = date('y-m-d');

    echo "[$execTime] SCANNING ".$arrayDomains[$i]."...".PHP_EOL;
    exec("python $dirsearch -u ". $arrayDomains[$i] . " --exclude-status $statusExclude");
    
    $filenameSearch  = glob("dirsearch/reports/".$arrayDomains[$i]."_$execDate*")[0] ?? null;
    
    $dirsearchResult = "";
    if ($filenameSearch) {
        $dirsearchResult = file_get_contents($filenameSearch) ?? "";
    }
    
    if($filenameSearch && $dirsearchResult != "") {
        echo "[$execTime] ".$arrayDomains[$i]." SCANNED SUCCESSFULLY SAVING RESULTS...".PHP_EOL;
        $utils->saveResult($dirsearchResult, $arrayDomains[$i], $execTime);
        echo "[$execTime] DOMAIN '".$arrayDomains[$i]."' RESULTS SAVED".PHP_EOL;
        $utils->sendMessage($dirsearchResult);
        echo "[$execTime] TELEGRAM NOTIFICATION SENT".PHP_EOL;
    } else {
        echo "[$execTime] ".$arrayDomains[$i]." SCANNED SUCCESSFULLY WITH NO RESULTS".PHP_EOL;
    }

}
