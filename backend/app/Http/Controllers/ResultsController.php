<?php
namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;

class ResultsController extends Controller
{
    public function index()
    {
        $patient = JWTAuth::parseToken()->authenticate();

        if (!$patient) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $orders = $patient->orders->map(function ($order) {
            return [
                'orderId' => (string) $order->external_order_id,
                'results' => $order->results->map(fn($r) => [
                    'name'      => $r->name,
                    'value'     => $r->value,
                    'reference' => $r->reference,
                ]),
            ];
        });

        return response()->json([
            'patient' => [
                'id'        => $patient->id,
                'name'      => $patient->name,
                'surname'   => $patient->surname,
                'sex'       => $patient->sex,
                'birthDate' => $patient->birth_date,
            ],
            'orders' => $orders,
        ]);
    }
}