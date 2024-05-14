<?php
$db = fopen("database.json", "r-") or die("Error file didn't open");
rewind($db);
$jsonObj = json_decode(fread($db, filesize("database.json")));
foreach ($jsonObj as $userData) {
  return $userData->gpu;
  return $userData->cpu;
  return $userData->emulator;
  return $userData->location;
  return $userData->benchmark_info;
  return $userData->user_notes;
}
?>