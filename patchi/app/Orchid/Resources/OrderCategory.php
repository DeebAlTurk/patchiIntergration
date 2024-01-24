<?php

namespace App\Orchid\Resources;

use App\Orchid\Filters\OrderCategoryFilter;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class OrderCategory extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\orderCategory::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('title')->title('title')
            ->required()->placeholder('Please Enter the Category Title'),
            TextArea::make('description')->title('Description')
            ->maxlength(255)->required()->placeholder('Please enter an description')
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
            TD::make('title','Title'),
            TD::make('description','Description'),

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
            Sight::make('title','Title'),
            Sight::make('description','Description')
        ];
    }

    public function rules(Model $model): array
    {
        return [
          'title'=>'required|string',
            'description'=>'required|string|max:255'
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            new DefaultSorted('id', 'desc'),
            OrderCategoryFilter::class
        ];
    }
}
