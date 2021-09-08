<?php

function addLogEvent($file, $event)
{
    $time = date("D, d M Y H:i:s");
    $time = "[".$time."] ";
 
    $event = $time.$event."\n";
 
    file_put_contents($file, $event, FILE_APPEND);
}
?>
