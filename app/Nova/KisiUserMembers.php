<?php

namespace App\Nova;

use App\Nova\Actions\Kisi as Kisi;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class KisiUserMembers extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Member>
     */
    public static $model = \App\Models\Member::class;

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
            Text::make(__('First Name'), 'first_name')
                ->sortable()
                ->readonly(),
            Text::make(__('Last Name'), 'last_name')
                ->sortable()
                ->readonly(),
            Email::make(__('Email'), 'email')
                ->readonly(),
            Boolean::make('Door Access', function() {

                if(!$this->email) return false;

                $members = Http::withHeaders([
                    'Authorization' => 'KISI-LOGIN ' . env('KISI_API_KEY'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->get('https://api.kisi.io/members', [
                    'query' => $this->email,
                    'limit' => 1,
                ])->json();

                return $members[0]['access_enabled'] ?? false;
            })->onlyOnDetail(),
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
            Kisi\AddUser::make()->sole(),
            Kisi\ToggleAccess::make()->sole(),
            Kisi\RemoveUser::make()->sole(),
        ];
    }

    /**
     * READ ONLY RESOURCE
     */
    public static function authorizeToCreate(Request $request) {throw new AuthorizationException();}
    public static function authorizedToCreate(Request $request) {return false;}
    public function authorizeToUpdate(Request $request) {return false;}
    public function authorizedToUpdate(Request $request) {return false;}
    public function authorizeToReplicate(Request $request) {return false;}
    public function authorizedToReplicate(Request $request) {return false;}
    public function authorizeToDelete(Request $request) {return false;}
    public function authorizedToDelete(Request $request) {return false;}


}
