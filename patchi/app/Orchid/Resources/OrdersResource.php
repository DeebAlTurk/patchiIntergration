<?php

namespace App\Orchid\Resources;

use App\Models\DeliveryProviders;
use App\Models\District;
use App\Models\User;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\TD;

class OrdersResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Orders::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
                Relation::make('user_id')
                    ->fromModel(User::class, 'email')
                    ->title('Submitted By')->required()
                    ->placeholder('Please Enter that submitted the order'),
                Input::make('policy_number')->title('Policy Number')
                    ->required()->placeholder('please enter the policy number'),
                Input::make('receiver_name')->title("Receiver's Name")
                    ->required()->placeholder("please enter the Receiver's Name"),
                Input::make('phone_number')->title("Receiver's Phone Number")
                    ->required()->placeholder("please enter the Receiver's Phone number"),
                Relation::make('district_id')
                    ->fromModel(District::class, 'name')
                    ->title('District')->required()
                    ->placeholder('Please Enter the District'),
                Relation::make('delivery_providers_id')
                    ->fromModel(DeliveryProviders::class, 'name')
                    ->title('Delivery Provider')->required()
                    ->placeholder('Please Enter the Delivery Provider'),
                DateTimer::make('preferred_delivery_date')
            ->required()->title('Preferred Date of Delivery')->min(now()->addDay())->enableTime(),
                TextArea::make('address')->title("Receiver's address")
                    ->required()->placeholder("please enter the Receiver's address")->max(255),
                TextArea::make('comment')->title("Comment")
                    ->placeholder("please enter a comment")->max(255),
                Select::make('status')->options([
                    'Open'=>'Open',
                    'Under process'=>'Under process',
                    'Shipped'=>'Shipped',
                    'Delivered'=>'Delivered',
                    'Invalid'=>'Invalid',
                ])->title('Select a Status')->required(),



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
        return [];
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
