<?php

namespace App\Geometry;

interface Geometry
{
    public function shape(Shape $shape);
    public function sumSurface();
    public function sumDiameter();
    public function sumCircumference();

}