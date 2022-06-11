<?php

namespace App\Geometry;

use App\Interface\GeometryInterface;
use App\Interface\ShapeInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class Calculator implements GeometryInterface
{
    public array $shapes;

    /**
    * @param ShapeInterface[] $shapes
    */
    public function __construct(array $shapes = [])
    {
        $this->shapes = $shapes;
    }

    public function shape(ShapeInterface $shape): string
    {
        return substr($shape::class, strrpos($shape::class, '\\')+1);
    }
    
    /**
    * Sum all shapes surface areas
    */
    public function sumSurface(): float|int
    {
        $area = [];
        foreach ($this->shapes as $shape) {
            if ($shape instanceof ShapeInterface) {
                if (method_exists($shape, 'surface')) {
                    $area[] = $shape->surface();
                }
                continue;
            }
            throw new Exception('Invalid shape exception', 1);
        }
        return array_sum($area);
    }
    
    /**
    * Sum all shapes diameters
    */
    public function sumDiameter(): float|int
    {
        $diameter = [];
        foreach ($this->shapes as $shape) {
            if ($shape instanceof ShapeInterface) {
                if (method_exists($shape, 'surface')) {
                    $diameter[] = $shape->diameter();
                }
                continue;
            }
            throw new Exception('Invalid shape exception', 1);
        }
        return array_sum($diameter);
    }
    
    /**
    * Sum all shapes circumference
    */
    public function sumCircumference(): float|int
    {
        $circumference = [];
        foreach ($this->shapes as $shape) {
            if ($shape instanceof ShapeInterface) {
                if (method_exists($shape, 'surface')) {
                    $circumference[] = $shape->circumference();
                }
                continue;
            }
            throw new Exception('Invalid shape exception', 1);
        }
        return array_sum($circumference);
    }
}
