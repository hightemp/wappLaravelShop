<?php

define("HOUR", strtotime('1 hour', 0));
for ($iIndex = 2; $iIndex<24; $iIndex++) {
    define("{$iIndex}_HOURS", strtotime("$iIndex hours", 0));
}
define("DAY", strtotime('1 day', 0));
for ($iIndex = 2; $iIndex<7; $iIndex++) {
    define("{$iIndex}_DAYS", strtotime("$iIndex days", 0));
}
define("WEEK", strtotime('1 week', 0));
for ($iIndex = 2; $iIndex<30; $iIndex++) {
    define("{$iIndex}_WEEKS", strtotime("$iIndex weeks", 0));
}
define("MONTH", strtotime('1 month', 0));
for ($iIndex = 2; $iIndex<12; $iIndex++) {
    define("{$iIndex}_MONTHS", strtotime("$iIndex months", 0));
}
define("YEAR", strtotime('1 year', 0));
