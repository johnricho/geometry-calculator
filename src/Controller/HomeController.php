<?php

namespace App\Controller;

use App\Geometry\Circle;
use App\Geometry\Result;
use App\Geometry\Triangle;
use App\Geometry\Calculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\ServiceSubscriberTrait;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    use ServiceSubscriberTrait;

    #[Route('/', name: 'welcome')]
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => 'success',
            'author' => 'John Ojebode (Johnricho)',
            'message' => 'Welcome to my Horus Music Application shape restful api!'
        ]);
    }

    #[Route('/shape', name: 'shape_calculator')]
    public function calculator(Request $request): JsonResponse
    {
        try {
            if ((!$request->query->has('radius') || !$request->query->has('a') ||
                !$request->query->has('b') || !$request->query->has('c'))) {
                return $this->json([
                    'status' => 'success',
                    'message' => 'Shape data required',
                ]);
            }

            $shapes = [
                new Circle($request->query->get('radius')),
                new Triangle($request->query->get('a'), $request->query->get('b'), $request->query->get('c'))
            ];
            $calculator = new Calculator($shapes);
            $result = new Result($calculator);

            return $this->json([
                'status' => 'success',
                'message' => 'All shapes calculated',
                'data' => $result->shapes()
            ]);
        } catch (Exception $e) {
            return $this->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
