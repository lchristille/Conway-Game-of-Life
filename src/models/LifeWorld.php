<?php

require_once dirname(__FILE__) . '/../abstractions/IGameWorld.php';
require_once dirname(__FILE__) . '/DeadCell.php';
require_once dirname(__FILE__) . '/LiveCell.php';

class LifeWorld implements IGameWorld
{
    private array $state;
    private int $height = 6;
    private int $width = 6;

    public function __construct(?array $state = null)
    {
        if ($state === null) {
            for ($h = 0; $h < $this->height; $h++) {
                for ($w = 0; $w < $this->width; $w++) {
                    $random = random_int(0, 1);
                    if ($random == 0) {
                        $this->state[$h][$w] = new DeadCell();
                    } else {
                        $this->state[$h][$w] = new LiveCell();
                    }
                }
            }
        } else {
            $this->state = $state;
        }
    }

    public function OnTick(): void
    {
        $new_state = $this->GetNextState();
        $this->state = $new_state;
    }

    public function GetNextState(): array
    {
        $next_state = [[]];
        for ($h = 0; $h < $this->height; $h++) {
            for ($w = 0; $w < $this->width; $w++) {
                $previous_state_cells_neighbour = $this->CountNeighbours($h, $w);
                if ($this->state[$h][$w]->WillBeAlive($previous_state_cells_neighbour)) {
                    $next_state[$h][$w] = new LiveCell();
                } else {
                    $next_state[$h][$w] = new DeadCell();
                }
            }
        }
        return $next_state;
    }

    public function CountNeighbours(int $x, int $y): int
    {
        $result = 0;

        for ($count_x = $x - 1; $count_x <= $x + 1; $count_x++) {
            for ($count_y = $y - 1; $count_y <= $y + 1; $count_y++) {
                if ($count_x > 0 && $count_y > 0 && $count_x < $this->width && $count_y < $this->height) {
                    if ($count_x != $x && $count_y != $y) {
                        $result += $this->state[$count_y][$count_x] ? 1 : 0;
                    }
                }
            }
        }

        return $result;
    }

    public
    function OnBeforeRender(bool $is_first_tick, bool $is_last_tick): void
    {
        if (!$is_first_tick) {
            // Move caret back to start position (move back of "height" lines and
            // position at the line start)
            printf(str_repeat("\033[F", $this->height));
        }
    }

    public
    function OnRender(): void
    {
        foreach ($this->state as $x) {
            foreach ($x as $y) {
                echo ANSI_RED . $y->Render() . ANSI_CLOSE;
            }
            echo PHP_EOL;
        }
    }

    public
    function OnAfterRender(bool $is_first_tick, bool $is_last_tick)
    {
    }

}