<?php

interface ICell
{
    public function WillBeAlive($neighbours_count): bool;

    public function Render(): string;
}