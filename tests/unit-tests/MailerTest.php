<?php

use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;
use StephenHarris\WPEmail\PlainEmail;
use StephenHarris\WPEmail\Mailer;

final class MailerTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Monkey::setUpWP();
    }

    protected function tearDown()
    {
        Monkey::tearDownWP();
        parent::tearDown();
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Email must have at least one recipient
     */
    public function testNoRecipient()
    {
        $email = new PlainEmail();
        $email->setMessage("Message");
        $email->setSubject("Subject");

        $mailer = new Mailer();
        $mailer->send($email);
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Email message must be non-empty
     */
    public function testNoMessage()
    {
        $email = new PlainEmail();
        $email->addRecipient("example@example.com");
        $email->setSubject("Subject");

        $mailer = new Mailer();
        $mailer->send($email);
    }


    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Email subject must be non-empty
     */
    public function testNoSubject()
    {
        $email = new PlainEmail();
        $email->addRecipient("example@example.com");
        $email->setMessage("Message");

        $mailer = new Mailer();
        $mailer->send($email);
    }
}
