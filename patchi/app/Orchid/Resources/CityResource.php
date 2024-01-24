<?php

namespace App\Orchid\Resources;

use App\Models\City;
use App\Orchid\Filters\CityFilter;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class CityResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\City::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('name')->title('Name')
                ->placeholder('Please enter the name of the city')->required(),
            Input::make('primary_email')->title('Primary Email')
                ->placeholder('Please enter the primary Email')->required()
                ->help('Primary Email is the email the Order will be sent to'),
            Input::make('cc_emails')->title('CC Emails')
                ->placeholder('user@mail.com;user2@mail.com')->required()
                ->help('These emails will be CCed on the order email'),
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
            TD::make('name', 'Name'),
            TD::make('primary_email', 'Primary Email'),
            TD::make('cc_emails', 'CC Emails'),
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
            Sight::make('name', 'Name'),
            Sight::make('primary_email', 'Primary Email'),
            Sight::make('cc_emails', 'CC Emails'),
            Sight::make('created_at', 'Created At')->render(function (City $city) {
                return $city->created_at->format('M-d-Y H:i:s');
            }),
            Sight::make('updated_at', 'Updated At')->render(function (City $city) {
                return $city->updated_at->format('M-d-Y H:i:s');
            }),


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
            CityFilter::class,
            new DefaultSorted('id', 'desc'),
        ];
    }


    /**
     * Get the validation rules that apply to save/update.
     *
     * @return array
     */
    public function rules(\Illuminate\Database\Eloquent\Model $m): array
    {
        return [
            'name' => 'required|unique:cities,name|string',
            'primary_email'=>'required|email',
            'cc_emails'=>'required'
            ];
    }
}
