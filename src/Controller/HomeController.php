<?php

namespace App\Controller;

use App\Geometry\Circle;
use App\Geometry\Result;
use App\Geometry\Triangle;
use App\Geometry\Calculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    #[Route('/', name: 'welcome')]
    public function index()
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
            if ((!$request->query->has('radius') && !$request->query->has('a') &&
                !$request->query->has('b') && !$request->query->has('c')) ||
                (!$request->request->has('a') && !$request->request->has('b') && !$request->request->has('c')
            )) {
                return $this->json([
                    'status' => 'success',
                    'message' => 'Shape data required',
                ]);
            }

            $shapes = [
                new Circle($request->radius),
                new Triangle($request->a, $request->b, $request->c)
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
