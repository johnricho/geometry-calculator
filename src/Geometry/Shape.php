<?php

namespace App\Geometry;

interface Shape
{

    public function surface();
    public function diameter();
    public function circumference();

}