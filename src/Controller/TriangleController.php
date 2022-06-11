<?php

namespace App\Controller;

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

class TriangleController extends AbstractController
{
    
    #[Route('/triangle', name: 'triangle')]
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => 'success',
            'message' => 'All parameters are required'
        ],200);
    }

    #[Route('/triangle/{a}/{b}/{c}', name: 'calculate_triangle', methods: 'GET')]
    public function triangle(Request $request, float $a, float $b, float $c, SerializerInterface $serializer): JsonResponse
    {
        try{
            $shapes = [new Triangle($a, $b, $c)];
            $calculate = new Calculator($shapes);
            $calculate_result = new Result($calculate);
            $triangle = $calculate_result->shape();
            // dd($triangle);
            return $this->json([
                'status' => 'success',
                'message' => 'Shape calculated',
                'data' => $triangle
            ],200);
        }catch(Exception $e){
            return $this->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ],400);
        }
    }

    #[Route('/triangle/{a}/{b}/{c}/serialized', name: 'calculate_triangle', methods: 'GET')]
    public function serialized(Request $request, float $a, float $b, float $c, SerializerInterface $serializer): Response
    {
        try{
            $shapes = [new Triangle($a, $b, $c)];
            $calculate = new Calculator($shapes);
            $calculate_result = new Result($calculate);
            $triangle = $calculate_result->shape();
            $serialized = $serializer->serialize($triangle, 'json');
            return new Response($serialized, 200, ['Content-Type' => 'application/json']);
        }catch(Exception $e){
            return new Response(json_encode([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]), 400, ['Content-Type' => 'application/json']);
        }
    }
}