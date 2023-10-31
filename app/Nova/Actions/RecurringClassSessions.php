<?php

namespace App\Nova\Actions;

use App\Models\FitnessClass;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class RecurringClassSessions extends Action
{
    public $name = 'Create Schedule';

    public $confirmText = 'Create a recurring schedule for this class?';

    public $confirmButtonText = 'Create Schedule';

    public $modalSize = '3xl'; // Make room for the AM/PM selector in the date field.

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        /** @var FitnessClass $class */
        $class = $models->first();
        $startDate = new Carbon($fields->start_date);
        $scheduleIncrement = match($fields->schedule) {
            'day' => static function(&$date) { return $date->addDay(); },
            'week' => static function(&$date) { return $date->addWeek(); },
            'month' => static function(&$date) { return $date->addMonth(); },
        };

        $sessions = $class->fitnessClassSessions();
        while($startDate < now()->endOfYear()) {
            $sessions->create(['start_time' => $startDate]);
            $scheduleIncrement($startDate);
        }

        return Action::message('Recurring sessions created!');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Select::make('Schedule')->options([
                'day' => 'Daily',
                'week' => 'Weekly',
                'month' => 'Monthly',
            ]),
            DateTime::make('Start Date'),
        ];
    }
}
