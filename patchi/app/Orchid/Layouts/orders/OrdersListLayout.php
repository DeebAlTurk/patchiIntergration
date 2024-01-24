<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\orders;

use App\Models\DeliveryProviders;
use App\Models\District;
use App\Models\orderCategory;
use App\Models\Orders;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class OrdersListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'orders';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('user_id', 'User')
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Orders $order) {
                    return $order->user->name;
                }),
            TD::make('policy_number', __('Policy Number'))
                ->sort()
                ->filter(Input::make()),
            TD::make('receiver_name', __("Receiver's name"))
                ->sort()
                ->filter(Input::make()),
            TD::make('order_category_id', __("Order Category"))
                ->sort()
                ->filter(Relation::make()->fromModel(orderCategory::class, 'title'))
                ->render(function (Orders $order) {
                    return $order->order_category->title;
                }),
            TD::make('phone_number', __("Receiver's Phone number"))
                ->sort()
                ->filter(Input::make()),
            TD::make('address', __("Receiver's Address"))
                ->sort()
                ->filter(Input::make()),
            TD::make('comment', 'Comment')
                ->sort()
                ->filter(Input::make()),
            TD::make('city', 'City')
                ->sort()
                ->render(function (Orders $order) {
                    return $order->district->city->name;
                }),
            TD::make('district_id', 'District')
                ->sort()
                ->filter(Relation::make()->fromModel(District::class, 'name'))->render(function (Orders $order) {
                    return $order->district->name;
                }),
            TD::make('delivery_providers_id', 'Delivery Provider')
                ->sort()
                ->filter(Relation::make()->fromModel(DeliveryProviders::class, 'title'))->render(function (Orders $order) {
                    return $order->delivery_providers->title;
                })
                ->render(function (Orders $order) {
                    return $order->delivery_providers->title;
                }),
            TD::make('preferred_delivery_date', 'Preferred Delivery Date')
                ->sort()
                ->filter(
                    DateTimer::make('open')->enableTime())
                ->render(function (Orders $order) {
                    return $order->preferred_delivery_date->format('d-m-Y H:i:s');
                }),
            TD::make('status', 'Status')
                ->sort()
                ->filter(Select::make()->options([
                    'Open'=>'Open',
                    'Under process'=>'Under process',
                    'Shipped'=>'Shipped',
                    'Delivered'=>'Delivered',
                    'Invalid'=>'Invalid',
                ])),
            TD::make('supervisor', 'Supervisor')
                ->sort()
                ->filter(Input::make()),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Orders $order) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.orders.edit', $order->id)
                            ->icon('pencil'),
                    ])),
        ];
    }
}
