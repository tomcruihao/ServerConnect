<?php

// Get JSON from file
$json = file_get_contents('./test.json');

//Decode JSON
$json_data = json_decode($json, true);

//Print data
print_r($json_data);

?>