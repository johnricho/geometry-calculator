<?php

namespace App\Geometry;

use App\Interface\ShapeInterface;

class Circle implements ShapeInterface
{

    private float $radius;

    /**
     * @param float $radius
     */
    public function __construct(float $radius)
    {
        $this->setRadius($radius);
    }
    
    /**
     * Calculate surface area of a circle
     */
    public function surface(): float
    {
        return pi() * pow($this->radius, 2);
        ;
    }

    /**
     * Calculate diameter of a circle
     */
    public function diameter(): float
    {
        return 2 * $this->radius;
    }
    
    /**
     * Calculate circumference of a circle
     */
    public function circumference(): float
    {
        return 2 * pi() * $this->radius;
    }
    
    public function getRadius(): float
    {
        return $this->radius;
    }

    public function setRadius(float $radius): self
    {
        $this->radius = $radius;
        return $this;
    }
}
