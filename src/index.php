<?php
require_once dirname(__FILE__) . '/models/GameRunner.php';
require_once dirname(__FILE__) . '/models/EmptyWorld.php';
require_once dirname(__FILE__) . '/models/ExampleWorld.php';

const ESC = "\033";
const ANSI_RED = ESC . "[31m";
const ANSI_CLOSE = ESC . "[0m";

$gameWorld = new ExampleWorld();

$gameRunner = new GameRunner($gameWorld);

$totalTicks = 20;
$tickIntervalInMs = 1500;

$totalTicksEnv = getenv('TOTAL_TICKS');
if ($totalTicksEnv) {
    $totalTicks = filter_var($totalTicksEnv, FILTER_VALIDATE_INT);
}

$tickIntervalInMsEnv = getenv('TICK_INTERVAL_IN_MS');
if ($tickIntervalInMsEnv) {
    $tickIntervalInMs = filter_var($tickIntervalInMsEnv, FILTER_VALIDATE_INT);
}

$gameRunner->SetTotalTicks($totalTicks);
$gameRunner->SetTickInterval($tickIntervalInMs);
$gameRunner->Run();