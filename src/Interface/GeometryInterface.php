<?php

namespace App\Interface;

interface GeometryInterface
{
    public function shape(ShapeInterface $shape): string;
    public function sumSurface(): int|float;
    public function sumDiameter(): int|float;
    public function sumCircumference(): int|float;
}
