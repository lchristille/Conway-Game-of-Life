<?php

interface IGameWorld
{
    public function OnTick();

    public function OnBeforeRender(bool $is_first_tick, bool $is_last_tick);

    public function OnRender();

    public function OnAfterRender(bool $is_first_tick, bool $is_last_tick);
}