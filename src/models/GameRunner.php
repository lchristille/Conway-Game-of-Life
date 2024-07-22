<?php

require_once dirname(__FILE__) . '/../abstractions/IGameWorld.php';

class GameRunner
{
    private int $remainingTicks = 10;
    private int $totalTicks = 10;
    private int $tickIntervalInMs = 1000;
    private bool $running = false;
    private IGameWorld $gameWorld;

    public function __construct(?IGameWorld $game_loop = null)
    {
        $this->gameWorld = $game_loop ?? new EmptyGameWorld();
    }

    /**
     * @throws Exception
     */
    public function SetTotalTicks(int $ticks): void
    {
        if (!$this->running) {
            $this->totalTicks = $ticks;
            $this->remainingTicks = $this->totalTicks;
        } else {
            throw new Exception("Total Ticks cannot be changed while the game is running.");
        }
    }

    public function SetTickInterval(int $tickIntervalInMs): void
    {
        $this->tickIntervalInMs = $tickIntervalInMs;
    }

    public function Run(): void
    {
        $this->running = true;
        while ($this->remainingTicks > 0) {
            // prepare for next tick
            $is_first_tick = $this->remainingTicks == $this->totalTicks;
            $is_last_tick = $this->remainingTicks == 1;

            if (!$is_first_tick) {
                $this->gameWorld->OnTick();
            }


            $this->gameWorld->OnBeforeRender($is_first_tick, $is_last_tick);

            // tick
            $this->gameWorld->OnRender();

            // actions to be executed after tick
            $this->remainingTicks--;
            usleep($this->tickIntervalInMs * 1000);

            $this->gameWorld->OnAfterRender($is_first_tick, $is_last_tick);

            if ($is_last_tick) {
                echo "Run Completed!" . PHP_EOL . "Total ticks were " . $this->totalTicks . PHP_EOL . "The time between ticks was " . $this->tickIntervalInMs . "ms." . PHP_EOL;
            }
        }

        $this->running = false;
    }
}