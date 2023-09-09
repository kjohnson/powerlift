<?php

use App\Providers\FitnessClassCalendarDataProvider;

return [
    'fitness-classes' => [
        'dataProvider' => FitnessClassCalendarDataProvider::class,
        'uri' => 'calendars/fitness-classes',
        'windowTitle' => 'Fitness Classes',
    ],
];
