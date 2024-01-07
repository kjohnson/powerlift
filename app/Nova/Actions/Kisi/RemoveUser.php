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

class RemoveUser extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Remove User from Kisi';

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

        if(!isset($response[0])) {
            return Action::danger('User not found ' . $model->email);
        }

        $member = $response[0];

        $response = $request->delete("https://api.kisi.io/members/{$member['id']}");

        return $response->successful()
            ? Action::message('User removed from Kisi.')
            : Action::danger('Something went wrong.');
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
