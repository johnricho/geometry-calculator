<?php

namespace App\Controller;

use App\Geometry\Circle;
use App\Geometry\Result;
use App\Geometry\Triangle;
use App\Geometry\Calculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'welcome')]
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => 'success',
            'author' => 'John Ojebode (Johnricho)',
            'message' => 'Welcome to my Horus Music Application shape restful api!'
        ],200);
    }

    #[Route('/shape', name: 'shape_calculator')]
    public function calculator(Request $request, SerializerInterface $serializer): JsonResponse
    {
        try{
            $shapes = [new Circle(2.0),new Triangle(3.0, 4.0, 5.0)];
            $calculator = new Calculator($shapes);
            $result = new Result($calculator);
            return $this->json([
                'status' => 'success',
                'message' => 'All shapes calculated',
                'data' => $result->shapes($calculator)
            ],200);
        }catch(Exception $e){
            return $this->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ],400);
        }
    }
}
