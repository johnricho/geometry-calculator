<?php

namespace App\Geometry;

use App\Entity\Shape;
use ReflectionException;

use Symfony\Component\Config\Definition\Exception\Exception;

class Result
{
    protected Calculator $calculator;

    /**
     * @param Calculator $calculator
     */
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function object()
    {
        $shape = $this->calculator->shapes[0];
        $type = $this->calculator->shape($shape);
        $parameters = $this->getParameters($shape);
        if (!$this->calculator instanceof Calculator) {
            throw new Exception('Calculator invalid exception '. gettype($this->calculator), 1);
        }
        $current = new Shape();
        $current->setType(strtolower($type));
        $current->setSurface(round($shape->surface(), 2));
        $current->setDiameter(round($shape->diameter(), 2));
        $current->setCircumference(round($shape->circumference(), 2));
        foreach ($parameters as $parameter => $value) {
            $current->{strtolower($parameter)} = $value;
        }
        return $current;
    }
    
    /**
     * Output the calculated result in toArray
     */
    public function shape(): array
    {
        if (!$this->calculator instanceof Calculator) {
            throw new Exception('Calculator invalid exception '. gettype($this->calculator), 1);
        }
        $shape = $this->calculator->shapes[0];
        $parameters = $this->getParameters($shape);
        $current = [
            'type' => strtolower($this->calculator->shape($shape)),
            'surface' => round($shape->surface(), 2),
            'diameter' => round($shape->diameter(), 2),
            'circumference' => round($shape->circumference(), 2),
        ];
        $shape_data = array_merge($parameters, $current);
        array_push($parameters, $shape_data);
        return $shape_data;
    }
    
    /**
     * Output the calculated result in toArray
     */
    public function shapes(): array
    {
        $types = [];
        $params = [];
        if (!$this->calculator instanceof Calculator) {
            throw new Exception('Calculator invalid exception', 1);
        }
        foreach ($this->calculator->shapes as $shape) {
            $parameters = $this->getParameters($shape);
            foreach ($parameters as $parameter => $value) {
                $params[$parameter] = $value;
            }
            array_push($types, strtolower($this->calculator->shape($shape)));
        }
        $data = [
            'type' => $types,
            'surface' => round($this->calculator->sumSurface(), 2),
            'diameter' => round($this->calculator->sumDiameter(), 2),
            'circumference' => round($this->calculator->sumCircumference(), 2),
        ];
        $shape = array_merge($params, $data);
        return $shape;
    }

    /**
     * Get parameters from class constructor
     * @throws ReflectionException
     */
    public function getParameters($object): array
    {
        $parameters = [];
        $class = new \ReflectionClass($object);
        $method = $class->getMethod("__construct");
        $params = $method->getParameters();
        foreach ($params as $parameter) {
            $parameters[$parameter->getName()] = $object->{'get'.ucfirst($parameter->getName())}();
        }
        return $parameters;
    }
}
