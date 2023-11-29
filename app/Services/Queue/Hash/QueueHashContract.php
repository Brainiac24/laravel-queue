<?php

namespace App\Services\Queue\Hash;

interface QueueHashContract
{
    public function make($timestamp, array $payload);
    public function check($hash, $timestamp, array $payload);
}