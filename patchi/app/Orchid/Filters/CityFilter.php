<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class CityFilter extends Filter
{

    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'City Filter';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['name', 'primary_email'];
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
        if ($this->request->has(['name','primary_email'])){
            return $builder->where('name', $this->request->get('name'))
                ->Where('primary_email', $this->request->get('primary_email'));
        }else{
            return $builder->where('name', $this->request->get('name'))
                ->orWhere('primary_email', $this->request->get('primary_email'));

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
            Input::make('primary_email')
                ->type('email')
                ->value($this->request->get('primary_email'))
                ->placeholder('Search...')
                ->title('Primary Email')

        ];
    }
}
