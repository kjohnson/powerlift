<?php

namespace App\Nova\Metrics;

use App\Models\FitnessClassSession;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;

class UpcomingSessions extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->mapSessionsToMetricTableRows(
            FitnessClassSession::upcoming()->orderBy('start_time')->get()
        );
    }

    protected function mapSessionsToMetricTableRows(Collection $sessions): Collection
    {
        return $sessions->map(function($session) {
            return MetricTableRow::make()
                ->icon('clock')
                ->iconClass('text-green-500')
                ->title($session->fitnessClass->name)
                ->subtitle($session->start_time->format('g:i A'))
                ->actions(function () use ($session) {
                    return [
                        MenuItem::link('View Class', 'resources/fitness-classes/' . $session->fitnessClass->id),
                        MenuItem::link('View Session', 'resources/fitness-class-sessions/' . $session->id),
                    ];
                })
            ;
        });
    }
}
