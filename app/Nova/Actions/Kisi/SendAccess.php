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

class SendAccess extends Action
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
        /** @var Member $model */
        $model = $models->first();

        $request = Http::withHeaders([
            'Authorization' => 'KISI-LOGIN ' . env('KISI_API_KEY'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);

        $request->post('https://api.kisi.io/organizations/find', [
            'user' => [
                'email' => $model->email,
            ]
        ])->json();

        Action::message('Access email sent.');
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
