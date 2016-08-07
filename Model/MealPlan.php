<?php

App::uses('AppModel', 'Model');
/**
 * MealPlan Model.
 *
 * @property MealName $MealName
 * @property Recipe $Recipe
 * @property User $User
 */
class MealPlan extends AppModel
{
    public $DaysAbbreviated = [
        'Sun',
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat', ];

    public $DaysFull = [
       'Sunday',
       'Monday',
       'Tuesday',
       'Wednesday',
       'Thursday',
       'Friday',
       'Saturday', ];

    public $MonthsAbbreviated = [
        'Jan',
    'Feb',
    'Mar',
    'Apr',
    'May',
    'Jun',
    'Jul',
    'Aug',
    'Sep',
    'Oct',
    'Nov',
    'Dec', ];

    public $MonthsFull = [
        'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December', ];

    public $startWeekDay = 0;
    public $currentMonth;
    public $currentDay;
    public $currentYear;
    public $realMonth;
    public $realDay;
    public $realYear;

    /**
     Initializes the current date settings for use later on
     */
    public function InitDate($date, $startDayOfWeek)
    {
        if ($date == null) {
            $date = date('m-d-Y');
        }
        $this->currentDate = $date;
        list($this->currentMonth, $this->currentDay, $this->currentYear) = explode('-', $date);
        // Now set the real date
        $date = date('m-d-Y');
        $this->realDate = $date;
        $this->startWeekDay = $startDayOfWeek;
        list($this->realMonth, $this->realDay, $this->realYear) = explode('-', $date);
    }

    /**
     @return seven element array of arrays (day, month, year)
     */
    public function getWeekDaysList($day = null, $month = null, $year = null)
    {
        if ($day == null && $month == null && $year == null) {
            $day = $this->currentDay;
            $month = $this->currentMonth;
            $year = $this->currentYear;
        }
        $dayList = [];
        $count = 1;
        // Figure out what day of the week this date is on
        $weekDay = date('w', mktime(0, 0, 0, $month, $day, $year));
        // Set the date so that it is the given start of the week (any day)
        if ($weekDay != $this->startWeekDay) {
            if ($weekDay < $this->startWeekDay) {
                $dec = 7 - $this->startWeekDay + $weekDay;
                list($day, $month, $year) = $this->getPreviousDay($day, $month, $year, $dec);
            } elseif ($weekDay > $this->startWeekDay) {
                $dec = $weekDay - $this->startWeekDay;
                list($day, $month, $year) = $this->getPreviousDay($day, $month, $year, $dec);
            }
        }
        // Save the start date
        $dayList[] = [$day, $month, $year];
        // Add days to the list until we reach 7 days (one week)
        while ($count < 7) {
            list($day, $month, $year) = $this->getNextDay($day, $month, $year, 1);
            $dayList[] = [$day, $month, $year];
            $count++;
        }

        return $dayList;
    }

    /**
     @return the number of days in the month/year combo
     */
    private function daysInMonth($month, $year)
    {
        $dim = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $value = $dim[$month - 1];
        if ($month == 2 && $year % 4 == 0 && $year % 100 != 0) {
            $value++;
        }

        return $value;
    }

    /**
     @return array of ($day, $month, $year) that is the new date
     */
    public function getNextDay($day = null, $month = null, $year = null, $num = 1)
    {
        if ($day == null && $month == null && $year == null) {
            $day = $this->currentDay;
            $month = $this->currentMonth;
            $year = $this->currentYear;
        }
        $maxdays = $this->daysInMonth($month, $year);
        while ($num > 0) {
            if ($day == $maxdays) {
                // We need to roll over to a new month
                if ($month < 12) {
                    $month++;
                } else {
                    $year++;
                    $month = 1;
                }
                $day = 1;
            } else {
                $day++;
            }
            $num--;
        }

        return [$day, $month, $year];
    }

    /**
     @return array of ($day, $month, $year) that is the new date
     */
    public function getPreviousDay($day = null, $month = null, $year = null, $num = 1)
    {
        if ($day == null && $month == null && $year == null) {
            $day = $this->currentDay;
            $month = $this->currentMonth;
            $year = $this->currentYear;
        }
        // Loop until we have gone $num days backwards
        while ($num > 0) {
            if ($day == 1) {
                // we need to roll back to the previous month
                if ($month > 1) {
                    $month--;
                } else {
                    $year--;
                    $month = 12;
                }
                // Set days to the max days of the new month
                $day = $this->daysInMonth($month, $year);
            } else {
                $day--;
            }
            $num--;
        }

        return [$day, $month, $year];
    }

    /**
     Gets the next week (Sunday) for a given date
     */
    public function getNextWeek($day = null, $month = null, $year = null)
    {
        if ($day == null && $month == null && $year == null) {
            $day = $this->currentDay;
            $month = $this->currentMonth;
            $year = $this->currentYear;
        }
        $weekList = $this->getWeekDaysList($day, $month, $year);
        $day = $weekList[6][0];
        $month = $weekList[6][1];
        $year = $weekList[6][2];

        return $this->getNextDay($day, $month, $year, 1);
    }

    /**
     Gets the previous week (Sunday) for a given date
     */
    public function getPreviousWeek($day = null, $month = null, $year = null)
    {
        if ($day == null && $month == null && $year == null) {
            $day = $this->currentDay;
            $month = $this->currentMonth;
            $year = $this->currentYear;
        }
        $weekList = $this->getWeekDaysList($day, $month, $year);
        $day = $weekList[0][0];
        $month = $weekList[0][1];
        $year = $weekList[0][2];

        return $this->getPreviousDay($day, $month, $year, 7);
    }

    /**
     Gets the next month
     */
    public function getNextMonth($day = null, $month = null, $year = null)
    {
        if ($day == null && $month == null && $year == null) {
            $day = $this->currentDay;
            $month = $this->currentMonth;
            $year = $this->currentYear;
        }
        if ($month < 12) {
            $month++;
        } else {
            $month = 1;
            $year++;
        }

        return [$day, $month, $year];
    }

    /**
     Gets the previous month
     */
    public function getPreviousMonth($day = null, $month = null, $year = null)
    {
        if ($day == null && $month == null && $year == null) {
            $day = $this->currentDay;
            $month = $this->currentMonth;
            $year = $this->currentYear;
        }
        if ($month > 1) {
            $month--;
        } else {
            $month = 12;
            $year--;
        }

        return [$day, $month, $year];
    }

    /**
     * Validation rules.
     *
     * @var array
     */
    public $validate = [
        'mealday' => [
            'date' => [
                'rule' => 'date',
            ],
        ],
        'meal_name_id' => [
            'numeric' => [
                'rule' => 'numeric',
            ],
        ],
        'recipe_id' => [
            'numeric' => [
                'rule' => 'numeric',
            ],
        ],
        'servings' => [
            'numeric' => [
                'rule' => 'numeric',
            ],
        ],
    ];


    /**
     * belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = [
        'MealName' => [
                'className'  => 'MealName',
                'foreignKey' => 'meal_name_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
        'Recipe' => [
                'className'  => 'Recipe',
                'foreignKey' => 'recipe_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
        'User' => [
                'className'  => 'User',
                'foreignKey' => 'user_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
    ];

    public function isOwnedBy($mealId, $user)
    {
        return $this->field('id', ['id' => $mealId, 'user_id' => $user]) !== false;
    }
}
