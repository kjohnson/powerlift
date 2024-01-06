<?php

namespace App\Providers;

use App\Nova\Checkin;
use App\Nova\FitnessClass;
use App\Nova\FitnessClassRegistration;
use App\Nova\FitnessClassSession;
use App\Nova\Member;
use App\Nova\MembershipPlan;
use App\Nova\MemberLead;
use App\Nova\Transaction;
use App\Nova\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Dashboards\Main;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Powerlift\ArbSubscriptions\ArbSubscriptions;
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

        Nova::withoutNotificationCenter();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(\App\Nova\Dashboards\Main::class)->icon('collection'),
                MenuSection::resource(Member::class)->icon('identification'),
                MenuSection::make('Schedule', [
                    MenuItem::link(__('Calendar'), NovaCalendar::pathToCalendar('fitness-classes')),
                    MenuItem::resource(FitnessClass::class)->name('Classes'),
                ])->icon('calendar'),
                MenuSection::make('Accounting', [
                    MenuItem::resource(Transaction::class),
                ])->icon('cash')->collapsedByDefault(),
                MenuSection::make('Marketing', [
                    MenuItem::resource(MemberLead::class),
                ])->icon('speakerphone')->collapsedByDefault(),
                MenuSection::make('Settings', [
                    MenuItem::resource(User::class),
                    MenuItem::resource(MembershipPlan::class)->name('Memberships'),
                ])->icon('cog')->collapsedByDefault(),
//                (new ArbSubscriptions)->menu($request),
            ];
        });

        Nova::footer(function () {
            return Blade::render('
                <div class="mt-8 leading-normal text-xs text-gray-500 space-y-1">
                    <p class="text-center">PowerLift by <a class="link-default" href="https://cycleandhammer.com">Cycle & Hammer</a></p>
                    <p class="text-center">Software that does the heavy lifting.</p>
                </div>
            ');
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
            new NovaCalendar('fitness-classes'),
            new ArbSubscriptions(),
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
