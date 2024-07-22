<?php
require_once dirname(__FILE__) . '/models/GameRunner.php';
require_once dirname(__FILE__) . '/models/EmptyWorld.php';
require_once dirname(__FILE__) . '/models/ExampleWorld.php';

const ESC = "\033";
const ANSI_RED = ESC . "[31m";
const ANSI_CLOSE = ESC . "[0m";

$game_loop = new ExampleWorld();

$game_runner = new GameRunner($game_loop);

$game_runner->SetTotalTicks(40000);
$game_runner->SetTickInterval(100);
$game_runner->Run();