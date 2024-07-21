<?php

require_once dirname(__FILE__) . '/../abstractions/ICell.php';

class LiveCell implements ICell
{
    public function WillBeAlive($neighbours_count): bool
    {
        // underpopulation or overpopulation => dies
        if ($neighbours_count < 2 || $neighbours_count > 3) {
            return false;
        }

        // survives to next generation
        return true;
    }

    public function Render(): string
    {
        return "■";
    }
}