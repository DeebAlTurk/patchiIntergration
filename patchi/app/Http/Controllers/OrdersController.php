<?php

namespace App\Http\Controllers;

use App\Mail\OrderAdded;
use App\Mail\OrderUpdated;
use App\Models\City;
use App\Models\orderCategory;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
                "policy_number"=>'required|string|min:1',
                "receiver_name" => 'required|string|min:1',
                "phone_number" => ['required','string','min:1','regex:/^(?:\+966|00966|0)(5\d(?:\s?\d){7})$/'],
                "city_id" => 'required|int|exists:cities,id',
                "address" => 'required|string',
                "comment" => 'string',
                "preferred_delivery_date" => 'required|date|after:tomorrow',
            ]
        );
        $data = \Arr::add($data, 'user_id', \Auth::user()->id);
        $data = \Arr::add($data, 'status', 'Open');
        $data = \Arr::add($data, 'order_category_id', \Auth::user()->order_category_id);
        $data = \Arr::add($data, 'supervisor', 'unassigned');


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
     * @param \App\Models\Orders $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $order)
    {
        $cites=City::all();
        return view('orders.edit',['order' => $order,'cities' => $cites]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Orders $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orders $order)
    {
        if ($order->status==='Invalid'&&$request->user()->id===$order->user_id){
            $data = $request->validate(
                [
                    "policy_number"=>'string|min:1',
                    "receiver_name" => 'string|min:1',
                    "phone_number" => ['string','min:1','regex:/^(?:\+966|00966|0)(5\d(?:\s?\d){7})$/'],
                    "city_id" => 'exists:cities,id',
                    "address" => 'string',
                    "comment" => 'string',
                    "preferred_delivery_date" => 'date',
                ]
            );
            $order->update($data);
            if ($order->wasChanged()){
                $order->update(['status'=>'Open']);
                \Mail::to($order->city->primary_email)->cc($order->city->getCCEmails())->send(new OrderUpdated(route('voyager.orders.show', $order)));
            }
        }
        return redirect()->route('dashboard');

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
