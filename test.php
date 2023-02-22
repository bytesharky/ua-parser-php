<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
  <title>UserAgent</title>
  <style>
    pre {
      display: block;
      font-family: -moz-fixed;
      white-space: pre-wrap;
      margin: 1em 0;
    }
  </style>
 </head>
 <body>

<?php
require_once('UAParser.php');

$uap = new frogotfish\UAParser\UAParser();

$uadata = $uap->getResult();


echo("<pre>");
echo("\nVersion: ".$uap->version);
echo("\n");
echo("\nUserAgent: ".$uadata->ua);
echo("\n");
echo("\nOS: ".$uadata->os->toString());
echo("\nCPU: ".$uadata->cpu->toString('undefined'));
echo("\nDevice: ".$uadata->device->toString('undefined'));
echo("\nBrowser: ".$uadata->browser->toString());
echo("\n");
echo("\nEdge: ".($uadata->browser->is("Edge")? 'true' : 'false'));
echo("\nMobile: ".($uadata->device->is("Mobile")? 'true' : 'false'));
echo("\niOS: ".($uadata->os->is("iOS")? 'true' : 'false'));
echo("\nsmarttv: ".($uadata->device->is("smarttv")? 'true' : 'false'));
echo("\nSamsung: ".($uadata->device->is("Samsung")? 'true' : 'false'));
?>
  
 </body>
</html>


