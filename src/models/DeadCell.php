<?php

require_once dirname(__FILE__) . '/../abstractions/ICell.php';

class DeadCell implements ICell
{
    public function WillBeAlive($neighbours_count): bool
    {
        // reproduction
        if ($neighbours_count === 3) {
            return true;
        }

        // "remains" dead
        return false;
    }

    public function Render(): string
    {
        return "□";
    }
}