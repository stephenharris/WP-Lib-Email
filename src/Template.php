<?php
namespace WPLib\Email;

use WPLib\Email\Booking;

interface Template
{
    /**
     * @return string The content of the email, with the template applied
     */
    public function applyTemplate($message);
}
