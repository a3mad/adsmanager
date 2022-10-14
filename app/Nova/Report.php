<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;

class Report extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = '2. Indoors';
    public static $priority = 1;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Report::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Channel')->withoutTrashed(),
            Date::make('Air Date'),
            Text::make('Air Time')->withMeta(['extraAttributes' => [
                'placeholder' => 'Example 21:20:57']
            ])->rules('date_format:H:i:s'),
            BelongsTo::make('Location')->withoutTrashed(),
            BelongsTo::make('Program')->withoutTrashed(),
            Text::make('Grid Item'),
            BelongsTo::make('Campaign')->withoutTrashed(),
            BelongsTo::make('Client')->withoutTrashed(),
            BelongsTo::make('Sponsor Type')->withoutTrashed(),
            BelongsTo::make('Rerun')->withoutTrashed(),
            Number::make('Duration')->min(1)->max(1000),
            BelongsTo::make('Program Break')->withoutTrashed(),
            BelongsTo::make('Sponsor')->withoutTrashed(),
            Text::make('Match'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
