<?php
require_once dirname(__FILE__) . '/models/GameRunner.php';
require_once dirname(__FILE__) . '/models/LifeWorld.php';

const ESC = "\033";
const ANSI_RED = ESC . "[31m";
const ANSI_CLOSE = ESC . "[0m";

$game_loop = new LifeWorld();

$game_runner = new GameRunner($game_loop);

$game_runner->SetTotalTicks(20);
$game_runner->Run();