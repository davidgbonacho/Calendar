<?php

namespace DGBcalendar;

/**
 * Dynamic calendar
 * GET params
 * @param int year (y)
 * @param int month (m)
 * @author David G. Bonacho / Tizedit
 * 
 * @return object HTML with a calendar view of the required month
 */


class calendar
{
    public $year;
    public $month;
    public $day;
    public $first;
    public $last_day;
    public $monthname;
    public $dateobj;

    /**
     * Construct function
     * @param $year
     * @param $month
     */
    public function __construct($year, $month)
    {

        $this->year = $year;
        $this->month = $month;
        $this->day = '01';

        /**
         * build date object
         */
        $datestr = "{$this->year}-{$this->month}-{$this->day}";
        $this->dateobj = new \DateTime($datestr);

        /**
         * gets first day of the week on select month
         */
        $this->first = (int)$this->dateobj->format('w');

        /**
         * gets month name
         */
        $this->monthname = $this->dateobj->format('F');
        //setlocale(LC_TIME, 'es_ES');
        //$month_number = $this->dateobj->format('n');
        //$this->monthname = strftime('%B', mktime(0, 0, 0, $month_number, 1));

        /**
         * gets last day on select month
         */
        $this->last_day = new \DateTime($this->dateobj->format('Y-m-t'));
    }

    /**
     * Draw calendar in ul list
     * @return string HTML with a calendar view of the required month
     */
    public function getCalendar()
    {
        // set style for first day
        $htm = "<style>
        @import url('dgbcalendar/DGBcalendar.css');

        .first-day {
            grid-column-start: {$this->first};
        }
        
        </style>";

        // put  month
        $htm.= "<h2>{$this->monthname}</h1><ul>";

        /** 
         * list all days of the week as header
         */
        for ($i = 0; $i < 7; $i++) {
            $day = date('D', strtotime("Sunday +{$i} days"));
            $htm .= "<li class='day-name'>$day</li>" . PHP_EOL;
        }
        // list all days of the week as header in local language
       // $daysweek = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sab', 'Dom'];
        //foreach ($daysweek as $day) {
        //    $htm.= "<li class='day-name'>$day</li>".PHP_EOL;
        //}

        /**
         * list all days in select month. Styled the first with "first-day"
         */
        $style = ' class="first-day"';
        while ($this->dateobj <= $this->last_day) {
            // echo $dateobj->format('Y-m-d') . PHP_EOL;
            $htm.= "<li$style>{$this->dateobj->format('j')}</li>".PHP_EOL;

            $this->dateobj->modify('+1 day');
            $style = '';
        }

        return '<div id="calendar">'.$htm.'</ul></div>';
    }

    public function getFirst() {
        return $this->first;
    }
}