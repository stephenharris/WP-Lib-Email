<?php
namespace StephenHarris\WPEmail;

use StephenHarris\WPEmail\Booking;

interface Template
{
    /**
     * @return string The content of the email, with the template applied
     */
    public function applyTemplate($message);
}
