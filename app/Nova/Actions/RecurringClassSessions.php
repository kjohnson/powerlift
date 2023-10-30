<?php

namespace App\Nova\Actions;

use App\Models\FitnessClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class RecurringClassSessions extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Create Schedule';

    public $confirmText = 'Create a recurring schedule for this class?';

    public $confirmButtonText = 'Create Schedule';

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
        $schedule = $fields->schedule;
        $startDate = new Carbon($fields->start_date);

        $sessions = $class->fitnessClassSessions();
        while($startDate < now()->endOfYear()) {

            $sessions->create([
                'start_time' => $startDate,
            ]);

            switch($schedule) {
                case 'day':
                    $startDate->addDay();
                    break;
                case 'week':
                    $startDate->addWeek();
                    break;
                case 'month':
                default:
                    $startDate->addMonth();
                    break;
            }
        }
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
