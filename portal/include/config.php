<?php

$json = file_get_contents(__DIR__ . "/config.json");

return json_decode($json, TRUE);

?>