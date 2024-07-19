<?php

require_once dirname(__FILE__) . '/../abstractions/IGameWorld.php';

class LifeWorld implements IGameWorld
{
    private array $cells;
    private int $height = 25;
    private int $width = 50;

    public function __construct()
    {
        for ($h = 0; $h < $this->height; $h++) {
            for ($w = 0; $w < $this->width; $w++) {
                $this->cells[$h][$w] = false;
            }
        }
    }

    public function CountNeighbours(int $x, int $y): int
    {
        $result = 0;
        for ($current_x = $x - 1; $current_x <= $x + 1; $current_x++) {
            for ($current_y = $y - 1; $current_y <= $y + 1; $current_y++) {
                if ($current_x != $x && $current_y != $y) {
                    $result += $this->cells[$current_x][$current_y] ? 1 : 0;
                }
            }
        }
        return $result;
    }

    public function OnTick(): void
    {
        foreach ($this->cells as &$x) {
            foreach ($x as &$y) {
                $y = !$y;
            }
        }
    }

    public function OnBeforeRender(bool $is_first_tick, bool $is_last_tick): void
    {
        if (!$is_first_tick) {
            // Move caret back to start position
            printf(str_repeat("\033[F", $this->height));
        }
    }

    public function OnRender(): void
    {
        foreach ($this->cells as $x) {
            foreach ($x as $y) {
                if ($y) {
                    echo ANSI_RED . "■" . ANSI_CLOSE;
                } else {
                    echo ANSI_RED . "□" . ANSI_CLOSE;
                }
            }
            echo PHP_EOL;
        }
    }

    public function OnAfterRender(bool $is_first_tick, bool $is_last_tick)
    {
    }

}