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
                    $user->notify(new ManualNotification($model->notificationType->name));
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
        return [];
    }
}
