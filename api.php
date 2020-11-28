<?php
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
  echo "Grafos y Lenguajes Formales - Trabajo 3";
} elseif ($method == 'POST') {
  $input = json_decode(file_get_contents('php://input'), true);
  $logfile = fopen("log.txt", "a") or die("Unable to open file!");
  $newline = $input["newlog"]."\n";
  fwrite($logfile, $newline);
  fclose($logfile);
  echo $newline;
}