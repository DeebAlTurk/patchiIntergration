<?php

namespace App\Orchid\Resources;

use App\Models\City;
use App\Models\District;
use App\Orchid\Filters\DistrictFilter;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class DistrictResource extends Resource
{


    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\District::class;


    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('name')
                ->title('Name')
                ->placeholder('Name of the District')
                ->required()
                ->popover('Please Enter the Name of teh District'),
            Select::make('city_id')->fromModel(City::class,'name')->title('City')->placeholder('Please Select the City of the District')
                ->required()
                ->popover('Please Select the City of the District'),
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
            TD::make('city_id','City')->render(function (District $district){
                return $district->city->name;
            }),
            TD::make('name','Name'),

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
            Sight::make('id'),
            Sight::make('name','Name'),
            Sight::make('city_id','City')->render(function (District $district){
                return $district->city->name;
            }),
            Sight::make('created_at', 'Created At')->render(function (District $district) {
                return $district->created_at->format('M-d-Y H:i:s');
            }),
            Sight::make('updated_at', 'Updated At')->render(function (District $district) {
                return $district->updated_at->format('M-d-Y H:i:s');
            }),

        ];
    }
    public function rules(Model $model): array
    {
        return [
            'name'=>'required|string',
            'city_id'=>'required|exists:cities,id'
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
            DistrictFilter::class
        ];
    }
}
