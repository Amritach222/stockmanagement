<?php

namespace App\Listeners;

use App\Models\Activity;
use App\Models\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Request;

class ActivityLogListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $type = $event->type;
        $model = $event->model;
        if (auth()->user()) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = $event->id;
        }
        if ($type == 'Add') {
            $activity = Activity::where('name', 'has created ' . $model)->first();
            if ($activity === null) {
                $activity = new Activity([
                    'name' => 'has created ' . $model
                ]);
            }
        } elseif ($type == 'Edit') {
            $activity = Activity::where('name', 'has updated ' . $model)->first();
            if ($activity === null) {
                $activity = new Activity([
                    'name' => 'has updated ' . $model
                ]);
            }
        } elseif ($type == 'Delete') {
            $activity = Activity::where('name', 'has deleted ' . $model)->first();
            if ($activity === null) {
                $activity = new Activity([
                    'name' => 'has deleted ' . $model
                ]);
            }
        } elseif ($type == 'Login') {
            $activity = Activity::where('name', 'has logged in')->first();
            if ($activity === null) {
                $activity = new Activity([
                    'name' => 'has logged in'
                ]);
            }
        } elseif ($type == 'Register') {
            $activity = Activity::where('name', 'has register new account')->first();
            if ($activity === null) {
                $activity = new Activity([
                    'name' => 'has register new account'
                ]);
            }
        } elseif ($type == "Reset Password") {
            $activity = Activity::where('name', 'has reset their password')->first();
            if ($activity === null) {
                $activity = new Activity([
                    'name' => 'has reset their password'
                ]);
            }
        } elseif ($type == "Forgot Password") {
            $activity = Activity::where('name', 'is changing their password')->first();
            if ($activity === null) {
                $activity = new Activity([
                    'name' => 'is changing their password'
                ]);
            }
        }elseif($type == 'Logout'){
            $activity = Activity::where('name', 'has logged out from the system')->first();
            if ($activity === null) {
                $activity = new Activity([
                    'name' => 'has logged out from the system'
                ]);
            }
        } else {
            $activity = Activity::where('name', 'has changed ' . $model)->first();
            if ($activity === null) {
                $activity = new Activity([
                    'name' => 'has changed ' . $model
                ]);
            }
        }

        $activity->save();

        $log = new Log([
            'user_id' => $user_id,
            'activity_id' => $activity->id,
            'ip' => Request::ip(),
        ]);
        $log->save();
        if ($event->id != null) {
            $log->model_id = $event->id;
            $log->save();
        }
    }
}
