<?php

namespace App\Providers;

use App\Nova\FitnessClassSession;
use Wdelfuego\NovaCalendar\DataProvider\AbstractCalendarDataProvider;
use Wdelfuego\NovaCalendar\Event;

class FitnessClassCalendarDataProvider extends AbstractCalendarDataProvider
{
    public function novaResources() : array
    {
        return [
            FitnessClassSession::class => 'start_time',
        ];
    }

    protected function customizeEvent(Event $event): Event
    {
        if($event->model()) {
            $event->name($event->model()->fitnessClass?->name);
            $event->displayTime();
        }
        return $event;
    }
}
