<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use App\Models\orderCategory;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),
            Input::make('user.username')
                ->type('text')
                ->required()
                ->title(__('Username'))
                ->placeholder(__('Username')),
            Relation::make('user.order_category_id')
                ->fromModel(orderCategory::class, 'title')
                ->title('Order Category'),
        ];
    }
}
