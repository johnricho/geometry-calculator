<?php

namespace App\Controller;

use App\Geometry\Result;
use App\Geometry\Circle;
use App\Geometry\Calculator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CircleController extends AbstractController
{
    use ServiceSubscriberTrait;

    #[Route('/circle', name: 'circle')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Route not defined'
        ], 404);
    }

    #[Route('/circle/{radius}', name: 'calculate_circle', methods: 'GET')]
    public function circle(float $radius): JsonResponse
    {
        try {
            $shapes = [new Circle($radius)];
            $calculate = new Calculator($shapes);
            $calculate_result = new Result($calculate);
            $circle = $calculate_result->shape();

            return $this->json([
                'status' => 'success',
                'message' => 'ShapeInterface calculated',
                'data' => $circle
            ]);
        } catch (Exception $e) {
            return $this->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    #[Route('/circle/{radius}/serialized', name: 'serialized_circle', methods: 'GET')]
    public function serialized(SerializerInterface $serializer, float $radius): Response
    {
        try {
            $shapes = [new Circle($radius)];
            $calculate = new Calculator($shapes);
            $calculate_result = new Result($calculate);
            $circle = $calculate_result->shape();
            $serialized = $serializer->serialize($circle, 'json');
            return new Response($serialized, 200, ['Content-Type' => 'application/json']);
        } catch (Exception $e) {
            return $this->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
