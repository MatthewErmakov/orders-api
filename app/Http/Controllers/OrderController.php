<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\Orders\CreateOrder;
use App\Http\Requests\Orders\UpdateOrder;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy', 'index', 'show']);
    }

    public function index(ApiRequest $request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 10;

        $orders = auth()->user()?->orders()?->skip(($page - 1) * $perPage)->take($perPage)->get();

        return response()->json($orders);
    }

    public function show(Order $order)
    {
        if ($order->user_id === auth()->id()) {
            return response()->json($order);
        }

        return response()->json([
            'error' => [
                'message' => 'Order not found'
            ]
        ], 404);
    }

    public function store(CreateOrder $request)
    {
        return response()->json(
            auth()->user()->orders()->create([
                'product_name' => $request->product_name,
                'amount' => $request->amount,
                'status' => $request->status,
            ]),
            201
        );
    }

    public function update(UpdateOrder $request, Order $order)
    {
        if ( auth()->user()->orders()->find($order->id) ) {
            $data = $request->only(['product_name', 'amount', 'status']);

            if (!empty($data)) {
                if ($order->update($data)) {
                    $order->touch(); // update "updated_at"
                    $order->notify(new OrderStatusUpdated());

                    return response()->json($order->only(['id', 'user_id', 'product_name', 'amount', 'status', 'created_at', 'updated_at' ]));
                }
            } else {
                return response()->json([
                    'error' => [
                        'message' => 'Invalid order data. Please try again.'
                    ]
                ], 400);
            }
        }

        return response()->json([
            'error' => [
                'message' => 'You\'re not allowed to change data of this order.'
            ]
        ], 405);
    }

    public function destroy(Order $order)
    {
        if ( auth()->user()->orders()->find($order->id) ) {
            $order->delete();

            return response()->json('', 204);
        }

        return response()->json([
            'error' => [
                'message' => 'You\'re not allowed to delete this order.'
            ]
        ], 405);
    }
}
