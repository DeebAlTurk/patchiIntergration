<?php

namespace App\Http\Controllers;

use App\Mail\OrderAdded;
use App\Models\City;
use App\Models\orderCategory;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        if (\Auth::user()->hasRole('user')) {
            $cities = City::all();
            $categories = orderCategory::all();
            return view('orders.create',
                [
                    'cities' => $cities,
                    'categories' => $categories
                ]);

        } else {
            return view('dashboard');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
//                "policy_number"=>'',
                "receiver_name" => 'required|string|min:1',
                "order_category_id" => 'required|exists:order_categories,id|int',
                "phone_number" => 'required|string|min:5',
                "city_id" => 'required|int|exists:cities,id',
                "address" => 'required|string',
                "comment" => 'string',
            ]
        );
        $data = \Arr::add($data, 'policy_number', \Str::random(7));
        $data = \Arr::add($data, 'user_id', \Auth::user()->id);
        $city = City::find($data['city_id']);
        $order = Orders::create($data);
        $order->orderStatuses()->create(
            [
                'order_id'=>$order->id,
                'status'=>"Open",
                'supervisor'=>'unassigned'
            ]
        );
        \Mail::to($city->primary_email)->cc($city->getCCEmails())->send(new OrderAdded(route('voyager.orders.show', $order)));
        return redirect()->route('dashboard');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Orders $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Orders $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Orders $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Orders $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
