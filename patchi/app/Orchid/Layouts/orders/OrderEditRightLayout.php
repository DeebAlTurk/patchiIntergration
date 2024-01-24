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
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class OrderEditRightLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            DateTimer::make('order.preferred_delivery_date')
                ->required()->title('Preferred Date of Delivery')->min(now()->addDay())->enableTime(),
            TextArea::make('order.address')->title("Receiver's address")
                ->required()->placeholder("please enter the Receiver's address")->max(255),
            TextArea::make('order.comment')->title("Comment")
                ->placeholder("please enter a comment")->max(255),
            Select::make('order.status')->options([
                'Open'=>'Open',
                'Under process'=>'Under process',
                'Shipped'=>'Shipped',
                'Delivered'=>'Delivered',
                'Invalid'=>'Invalid',
            ])->title('Select a Status')->required(),
            Input::make('order.supervisor')->required()
            ->placeholder('Please enter the supervisor of the current status')->title('Supervisor'),
            Upload::make('proof_of_delivery')];
    }
}
