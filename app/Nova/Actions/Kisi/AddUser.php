<?php

namespace App\Nova\Actions\Kisi;

use App\Models\Member;
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

        $request = Http::withHeaders([
            'Authorization' => 'KISI-LOGIN ' . env('KISI_API_KEY'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);

        $response = $request->get('https://api.kisi.io/members', [
            'query' => $model->email,
            'limit' => 1,
        ])->json();

        if(isset($response[0])) {
            $member = $response[0];
        } else {
            $member = $request->post("https://api.kisi.io/members", [
                'member' => [
                    'name' => $model->fullName(),
                    'email' => $model->email,
                ]
            ]);
        }

        $response = $request->post("https://api.kisi.io/role_assignments", [
            'role_assignment' => [
                'user_id' => $member['user']['id'],
                'role_id' => env('KISI_ROLE_ID'),
                'group_id' => env('KISI_GROUP_ID'),
            ]
        ]);

        return $response->successful()
            ? Action::message('User added to Kisi.')
            : Action::danger('Error: ' . $response['error']);
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
