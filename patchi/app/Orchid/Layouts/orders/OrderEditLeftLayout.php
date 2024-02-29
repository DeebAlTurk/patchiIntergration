<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\orders;

use App\Models\DeliveryProviders;
use App\Models\District;
use App\Models\orderCategory;
use App\Models\User;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class OrderEditLeftLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Relation::make('order.user_id')
                ->fromModel(User::class, 'email')
                ->title('Submitted By')->required()
                ->placeholder('Please Enter that submitted the order'),
            Input::make('order.policy_number')->title('Policy Number')
                ->required()->placeholder('please enter the policy number'),
            Input::make('order.receiver_name')->title("Receiver's Name")
                ->required()->placeholder("please enter the Receiver's Name"),
            Input::make('order.phone_number')->title("Receiver's Phone Number")
                ->required()->placeholder("966xxxxxxxx"),
            Select::make('order.district_id')
                ->fromModel(District::class, 'name')
                ->title('District')->required()
                ->placeholder('Please Enter the District'),
            Relation::make('order.delivery_providers_id')
                ->fromModel(DeliveryProviders::class, 'title')
                ->title('Delivery Provider')->required()
                ->placeholder('Please Enter the Delivery Provider'),
            CheckBox::make('order.sms_code_confirmation')
                ->sendTrueOrFalse()->disabled()->title('SMS Confirmation'),
            Input::make('sms_code')
                ->maxlength(6)
                ->title('SMS Confirmation Code'),
        ];
    }
}
