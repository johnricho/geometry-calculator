<?php

namespace App\Geometry;


use App\Entity\Shape;
use App\Geometry\Calculator;
use Symfony\Component\Config\Definition\Exception\Exception;

class Result
{
    protected $shape;
    protected $calculator;

    /**
     * @param Calculator $calculator
     */
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function shape()
    {
        $shape = $this->calculator->shapes[0];
        $type = $this->calculator->shape($shape);
        $parameters = $this->getParameters($shape,'array');
        if (!$this->calculator instanceof Calculator) {
            throw new Exception('Calculator invalid exception '. gettype($this->calculator) , 1);
        }
        $current = new Shape();
        $current->setType(strtolower($type));
        $current->setSurface(round($shape->surface(),2));
        $current->setDiameter(round($shape->diameter(),2));
        $current->setCircumference(round($shape->circumference(),2));
        foreach ($parameters as $parameter => $value ) {
            $current->{strtolower($parameter)} = $value;
        }
        return $current;
    }
    
    /**
     * Output the calculated result in toArray
     */
    public function shapes(): array
    {    
        $data = [];
        if (!$this->calculator instanceof Calculator) {
            throw new Exception('Calculator invalid exception '. gettype($this->calculator) , 1);
        }
        foreach($this->calculator->shapes as $shape){
            $parameters = $this->getParameters($shape);
            $current = [
                'type' => $this->calculator->shape($shape),
                'surface' => round($shape->surface(),2),
                'diameter' => round($shape->diameter(),2),
                'circumference' => round($shape->circumference(),2),
            ];
            $shape_data = array_merge($parameters, $current);
            $data = array_push($parameters, $shape_data);
        }
        return $data;
    }
    
    /**
     * Get parameters from class constructor
     */
    public function getParameters($object)
    {
        $parameters = [];
        $class = new \ReflectionClass($object);
        $method = $class->getMethod( "__construct" );
        $params = $method->getParameters();
        foreach ($params as $parameter) {
            $parameters[$parameter->getName()] = $object->{$parameter->getName()};
        }
        return $parameters;
    }

    /**
     * Output the calculated result in json format
     */
    public function toJson()
    {
        return json_encode($this->shapes());
    }
}