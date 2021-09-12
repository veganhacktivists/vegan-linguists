<?php

namespace App\View\Components\Notifications;

use Carbon\Carbon;
use Illuminate\View\Component;

class BaseNotification extends Component
{
    public string $dateDiff;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public mixed $user = null, // prevent dependency injection
        Carbon $date,
        public string $description = '',
        public string $icon = '',
    )
    {
        $this->dateDiff = $this->calculateDateDiff($date);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notifications.base-notification');
    }

    private function calculateDateDiff(Carbon $date)
    {
        $now = Carbon::now();

        $numYears = $now->diffInYears($date);
        if ($numYears > 0) {
            return __(':numYearsy', ['numYears' => $numYears]);
        }

        $numWeeks = $now->diffInWeeks($date);
        if ($numWeeks > 0) {
            return __(':numWeeksw', ['numWeeks' => $numWeeks]);
        }

        $numDays = $now->diffInDays($date);
        if ($numDays > 0) {
            return __(':numDaysd', ['numDays' => $numDays]);
        }

        $numHours = $now->diffInHours($date);
        if ($numHours > 0) {
            return __(':numHoursh', ['numHours' => $numHours]);
        }

        $numMinutes = $now->diffInMinutes($date);
        if ($numMinutes > 0) {
            return __(':numMinutesm', ['numMinutes' => $numMinutes]);
        }

        return __(':numSecondss', ['numSeconds' => $now->diffInSeconds($date)]);
    }
}
