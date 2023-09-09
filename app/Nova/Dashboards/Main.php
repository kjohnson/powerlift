<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\DailyCheckins;
use App\Nova\Metrics\UpcomingSessions;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the displayable name of the dashboard.
     *
     * @return string
     */
    public function name()
    {
        return 'Dashboard';
    }

    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new DailyCheckins,
            new UpcomingSessions,
        ];
    }
}
