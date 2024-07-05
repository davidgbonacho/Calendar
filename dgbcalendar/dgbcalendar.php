<?php

/**
 * DGBcalendar
 *
 *
 * DGBcalendar is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DGBcalendar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DGBcalendar. If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author David G. Bonacho - 2024
 */

namespace DGBcalendar;

// css URL relative 
define('URLcss', 'dgbcalendar');

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
        @import url('".URLcss."/DGBcalendar.css');

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
            $day = date('D', strtotime("Monday +{$i} days"));
            $htm .= "<li class='day-name'>$day</li>" . PHP_EOL;
        }
/*         // list all days of the week as header in local language
        $daysweek = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sab', 'Dom'];
        foreach ($daysweek as $day) {
            $htm.= "<li class='day-name'>$day</li>".PHP_EOL;
        } */

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