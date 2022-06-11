<?php

namespace App\Geometry;

use App\Interface\ShapeInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class Triangle implements ShapeInterface
{

    private float $a;
    private float $b;
    private float $c;

    /**
     * @param float $a, $b, $c
     */
    public function __construct(float $a, float $b, float $c)
    {
        $this->setA($a);
        $this->setB($b);
        $this->setC($c);
    }

    /**
     * Calculate surface area of a triangle
     */
    public function surface(): float
    {
        if (($this->a < 0 || $this->b < 0 || $this->c < 0) ||
        ($this->a + $this->b <= $this->c) || ($this->a + $this->c <= $this->b) ||
        ($this->b + $this->c <= $this->a)) {
            throw new Exception("Error processing request", 1);
        }
        $s = ($this->a + $this->b + $this->c) / 2;
        return sqrt($s * ($s - $this->a) * ($s - $this->b) * ($s - $this->c));
    }

    /**
     * Calculate diameter of a triangle
     */
    public function diameter(): float
    {
        return ($this->b * $this->a) / 2;
    }
    
    /**
     * Calculate circumference of a triangle
     */
    public function circumference(): float
    {
        return($this->a * $this->a * (pi() / 3));
    }

    public function getA(): float
    {
        return $this->a;
    }

    public function setA(float $a): self
    {
        $this->a = $a;
        return $this;
    }

    public function getB(): float
    {
        return $this->b;
    }

    public function setB(float $b): self
    {
        $this->b = $b;
        return $this;
    }

    public function getC(): float
    {
        return $this->c;
    }

    public function setC(float $c): self
    {
        $this->c = $c;
        return $this;
    }
}
