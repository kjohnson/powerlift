<?php

namespace App\Providers;

use App\Nova\Checkin;
use App\Nova\FitnessClass;
use App\Nova\FitnessClassRegistration;
use App\Nova\FitnessClassSession;
use App\Nova\Member;
use App\Nova\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Dashboards\Main;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Wdelfuego\NovaCalendar\NovaCalendar;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::make('Dashboard', [
                    MenuItem::dashboard(\App\Nova\Dashboards\Main::class)->name('Overview')
                ])->icon('collection'),
                MenuSection::make('Schedule', [
                    MenuItem::link(__('Calendar'), NovaCalendar::pathToCalendar('fitness-classes')),
                    MenuItem::resource(FitnessClass::class)->name('Classes'),
                    MenuItem::resource(FitnessClassSession::class)->name('Sessions'),
                    MenuItem::resource(FitnessClassRegistration::class)->name('Registrations'),
                ])->icon('calendar')->collapsable(),
                MenuSection::make('Membership', [
                    MenuItem::resource(Member::class),
                    MenuItem::resource(Checkin::class),
                ])->icon('identification')->collapsable(),
                MenuSection::resource(User::class)->icon('user'),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new NovaCalendar('fitness-classes')
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
