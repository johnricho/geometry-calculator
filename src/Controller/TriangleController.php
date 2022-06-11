<?php

namespace App\Controller;

use App\Geometry\Result;
use App\Geometry\Triangle;
use App\Geometry\Calculator;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TriangleController extends AbstractController
{

    #[Route('/triangle', name: 'triangle')]
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => 'failed',
            'message' => 'All parameters are required'
        ], 400);
    }


    #[Route('/triangle/{a}', name: 'angle_a')]
    public function angle_a(): JsonResponse
    {
        return $this->json([
            'status' => 'failed',
            'message' => '3 parameters expected for triangle'
        ], 400);
    }


    #[Route('/triangle/{a}/{b}', name: 'angle_b')]
    public function angle_b(): JsonResponse
    {
        return $this->json([
            'status' => 'success',
            'message' => '3 parameters expected for triangle'
        ], 400);
    }

    #[Route('/triangle/{a}/{b}/{c}', name: 'calculate_triangle', methods: 'GET')]
    public function triangle(float $a, float $b, float $c): JsonResponse
    {
        try {
            $shapes = [new Triangle($a, $b, $c)];
            $calculate = new Calculator($shapes);
            $calculate_result = new Result($calculate);
            $triangle = $calculate_result->shape();
            
            return $this->json([
                'status' => 'success',
                'message' => 'Shape calculated',
                'data' => $triangle
            ]);
        } catch (Exception $e) {
            return $this->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
