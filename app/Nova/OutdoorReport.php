<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class OutdoorReport extends Resource
{
    public static $group = '1. Outdoors';
    public static $priority = 2;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\OutdoorReport::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'report_date';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','reported_at',
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
            BelongsTo::make('OutdoorLocation')->withoutTrashed()
                ->sortable(),
            Date::make('Report Date'),
            Text::make('Frame Status')
                ->rules('required', 'max:255'),
            Text::make('Paint Status')
                ->rules('required', 'max:255'),
            Text::make('Print Status')
                ->rules('required', 'max:255'),
            Text::make('Light Status')
                ->rules('required', 'max:255'),
            Text::make('Note'),
            Image::make('Morning Image')->disk('public')
                ->creationRules('required'),
            Image::make('Night Image')->disk('public')
                ->creationRules('required'),
            File::make('Report File')->disk('public')
                ->creationRules('required','file','mimes:pdf,ppt,pptx,doc,docx,xls,xlsx'),
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
