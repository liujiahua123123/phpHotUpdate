<?php
require_once 'HotUpdater.php';

$h = new HotUpdater(__DIR__ . "/test/TestConfig.php");
$h->replaceConstant("ACONST",["a" => "c", "1" => 2]);

$h->replaceGlobalVariable("aVer",["c" => "d", "1" => 2]);

$h->save();


