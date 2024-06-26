<?php

// Calculate number of days between 2 given dates
function calculateDaysDifference($date1, $date2) {
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);

    $dateDifference = $datetime1->diff($datetime2);
    return $dateDifference->format('%a'); // Returns the total number of days
}

// Check if a number is odd or even
function isNumberOddOrEven($number) {
    return ($number % 2 == 0) ? "Even" : "Odd";
}

// Check if the day of a date is odd or even
function isDateDayOddOrEven($date) {
    $datetime = new DateTime($date);
    $day = $datetime->format('j'); // Get the day of the month

    return ($day % 2 == 0) ? "Even" : "Odd";
}

function formatDaysDifference($date1, $date2) {
    // Verify date formats in Y-M-D format
    $date1_valid = DateTime::createFromFormat('Y-m-d', $date1) !== false;
    $date2_valid = DateTime::createFromFormat('Y-m-d', $date2) !== false;

    if (!$date1_valid || !$date2_valid) {
        return "Error: Please enter dates in YYYY-MM-DD format.";
    }

    $daysDifference = calculateDaysDifference($date1, $date2);
    $oddOrEvenDays = isNumberOddOrEven($daysDifference);

    $date1DayOddOrEven = isDateDayOddOrEven($date1);
    $date2DayOddOrEven = isDateDayOddOrEven($date2);

    return "Number of days between $date1 and $date2: $daysDifference days, and it is $oddOrEvenDays.\n" .
           "The day of the date $date1 is $date1DayOddOrEven.\n" .
           "The day of the date $date2 is $date2DayOddOrEven.\n";
}

// Example usage
$date1 = "2024-06-02";
$date2 = "2024-06-27";
echo formatDaysDifference($date1, $date2);


/* Result:
Number of days between 2024-06-02 and 2024-06-27: 25 days, and it is Odd.
The day of the date 2024-06-02 is Even.
The day of the date 2024-06-27 is Odd.
*/

?>  
