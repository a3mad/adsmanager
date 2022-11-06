<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class MobileNotification extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = '4. Administration';
    public static $priority = 2;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\MobileNotification::class;

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->notificationType->name;
    }


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'notification_type_id','created_at'
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
            BelongsTo::make('Notification Type')->withoutTrashed(),
            //N.T this relation doesn't exist in the db only exists for nova/actions
            BelongsTo::make('Program')->withoutTrashed()
                ->canSee(function ($request) {
                    return false;
                }),
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
        return [
            (new Actions\NotifyUsers)->showInline()
                ->confirmText('Are you sure you want to notify all users about these updates?')
                ->confirmButtonText('Notify All')
                ->cancelButtonText("cancel"),
        ];
    }
}
