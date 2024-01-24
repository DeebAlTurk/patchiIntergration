<?php

namespace App\Orchid\Resources;

use App\Models\Orders;
use App\Models\orderStatus;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class OrdersStatusResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = orderStatus::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Relation::make('orders_id')
                ->fromModel(Orders::class, 'id')
                ->title('Order')->required(),
            Select::make('order.status')->options([
                'Open' => 'Open',
                'Under process' => 'Under process',
                'Shipped' => 'Shipped',
                'Delivered' => 'Delivered',
                'Invalid' => 'Invalid',
            ])->title('Select a Status')->required(),
            Input::make('order.supervisor')->required()
                ->placeholder('Please enter the supervisor of the current status')
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('order_id')->render(function (orderStatus $status) {
                return $status->orders->id;
            }),
            TD::make('status'),
            TD::make('supervisor'),



            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [

            Sight::make('id', 'ID'),
            Sight::make('order_id', 'Order Id')->render(function (orderStatus $status) {
                return $status->orders->id;
            }),
            Sight::make('status', 'Status'),
            Sight::make('supervisor', 'Supervisor')

        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }
}
