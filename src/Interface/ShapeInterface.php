<?php

namespace App\Interface;

interface ShapeInterface
{
    public function surface(): int|float;
    public function diameter(): int|float;
    public function circumference(): int|float;
}
