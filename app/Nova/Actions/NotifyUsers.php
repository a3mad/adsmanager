<?php

namespace App\Nova\Actions;

use App\Models\NotificationError;
use App\Models\User;
use App\Notifications\ManualNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class NotifyUsers extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $errors = [];
            $users = User::whereNotNull('fcm_token')->get();
            foreach ($users as $user) {
                try {
                    /*if($model->notificationType->id=='5')
                    {
                        //outdoorLocation
                        $user->notify(new ManualNotification($model->notificationType->name,$fields->program->id,$fields->outdoorLocation->id));
                    }else*/
                        $user->notify(new ManualNotification($model->notificationType->name,$fields->program->id, $fields->outdoorLocation->id));
                    //$user->notify(new ManualNotification($model->notificationType->name,$fields->program->id));
                } catch (\Exception $e) {
                    report($e);
                    $errors[] = ['notifiable_id'=>$model->id,'notifiable_type'=>'App\Models\MobileNotification','user_id'=>$user->id,'message'=>$e->getMessage(),'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                    NotificationError::insert($errors);
                }
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        //dd($request->all());
        //if($request->notificationType->id=='5')
            //return [ BelongsTo::make('OutdoorLocation')->withoutTrashed()];
        //else
            return [
                BelongsTo::make('Program')->withoutTrashed(),
                BelongsTo::make('OutdoorLocation')->withoutTrashed(),
            ];
    }
}
