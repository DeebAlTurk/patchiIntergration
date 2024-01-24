<?php

namespace App\Orchid\Filters;

use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class DistrictFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'District Filter';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['name','city_id'];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        if ($this->request->has(['city_id','name'])){
            return $builder->where('name', $this->request->get('name'))
                ->Where('city_id', $this->request->get('city_id'));
        }else{
            return $builder->where('name', $this->request->get('name'))
                ->orWhere('city_id', $this->request->get('city_id'));

        }
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Input::make('name')
                ->type('text')
                ->value($this->request->get('name'))
                ->placeholder('Search...')
                ->title('City Name'),
            Select::make('city_id')->fromModel(City::class,'name')
        ];
    }
}
