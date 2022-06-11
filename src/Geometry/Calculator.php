<?php

namespace App\Geometry;

use Symfony\Component\Config\Definition\Exception\Exception;

class Calculator implements Geometry
{
    public $shapes;

    /**
    * @param Shape[] $shapes
    */
    public function __construct($shapes = [])
    {
        $this->shapes = $shapes;
    }

    public function shape(Shape $shape){
        return substr($shape::class, strrpos($shape::class, '\\')+1);
    }
    
    /**
    * Sum all shapes surface areas
    */
    public function sumSurface(){
        $area = [];
        foreach ($this->shapes as $shape) {
            if ($shape instanceof Shape) {
                if(method_exists($shape, 'surface')){
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
    public function sumDiameter(){
        $diameter = [];
        foreach ($this->shapes as $shape) {
            if ($shape instanceof Shape) {
                if(method_exists($shape, 'surface')){
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
    public function sumCircumference()
    {
        $circumeference = [];
        foreach ($this->shapes as $shape) {
            if ($shape instanceof Shape) {
                if(method_exists($shape, 'surface')){
                    $circumeference[] = $shape->circumference();
                }
                continue;
            }
            throw new Exception('Invalid shape exception', 1);
        }
        return array_sum($circumeference);
    }
}


