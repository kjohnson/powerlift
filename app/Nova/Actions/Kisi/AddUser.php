<?php

namespace App\Nova\Actions\Kisi;

use App\Models\Member;
use App\Services\Kisi\Exceptions\GroupRoleAssignmentNotCreatedException;
use App\Services\Kisi\Exceptions\MemberNotFoundException;
use App\Services\Kisi\Facades\Kisi;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class AddUser extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Add User to Kisi';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        /** @var Member $model */
        $model = $models->first();

        try {
            $member = Kisi::members()->getByEmail($model->email);
        } catch (MemberNotFoundException $e) {
            $member = Kisi::members()->create($model->fullName(), $model->email);
        }

        try {
            Kisi::groupRoleAssignments()->createForMember($member);
        } catch (GroupRoleAssignmentNotCreatedException $e) {
            return Action::danger('Error: ' . $e->getMessage());
        }

        return Action::message('User added to Kisi.');
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
