<?php

require_once dirname(__FILE__) . '/../abstractions/IGameWorld.php';
require_once dirname(__FILE__) . '/DeadCell.php';
require_once dirname(__FILE__) . '/LiveCell.php';

class EmptyWorld implements IGameWorld
{
    protected array $state = [[]];
    private int $height = 0;
    private int $width = 0;

    public function __construct(?array $state = null, ?int $height = null, ?int $width = null)
    {
        $this->height = $height ?? 6;
        $this->width = $width ?? 6;
        if ($state === null) {
            for ($h = 0; $h < $this->height; $h++) {
                for ($w = 0; $w < $this->width; $w++) {
                    $this->state[$h][$w] = new DeadCell();
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

    public function CountNeighbours(int $y, int $x): int
    {
        $result = 0;

        for ($count_y = $y - 1; $count_y <= $y + 1; $count_y++) {
            if ($count_y > 0 && $count_y < $this->height) {
                for ($count_x = $x - 1; $count_x <= $x + 1; $count_x++) {
                    if ($count_x > 0 && $count_x < $this->width) {
                        if ($count_x == $x && $count_y == $y) {
                            continue;
                        }
                        $result += $this->state[$count_y][$count_x] instanceof LiveCell ? 1 : 0;
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