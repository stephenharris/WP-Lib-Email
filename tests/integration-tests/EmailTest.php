<?php
namespace WPLib\Email\IntegrationTests;

use WPLib\Email\PlainEmail;
use WPLib\Email\Mailer;
use PHPUnit\Framework\TestCase;

class EmailTest extends \WP_UnitTestCase
{

    public function setUp()
    {
        parent::setUp();
        \IntegrationTests\reset_phpmailer_instance();
    }

    public function tearDown()
    {
        \IntegrationTests\reset_phpmailer_instance();
        parent::tearDown();
    }

    public function testEmailStringAttachment()
    {
        $email = new PlainEmail();
        $email->setMessage('Email with string attachment');
        $email->setSubject('Subject');
        $email->addRecipient('foobar@example.com');
        $email->addStringAttachment('This is the content', 'filename.txt');

        $mailer = new Mailer();
        $mailer->send($email);

        $phpmailer = \IntegrationTests\tests_retrieve_phpmailer_instance();
        $this->assertStringEqualsFile(WP_LIB_EMAIL_TEST_DIR . '/fixtures/email-with-string-attachment.txt', $phpmailer->getSentMIMEMessage());
    }

    public function testEmailAttachment()
    {
        $email = new PlainEmail();
        $email->setMessage('Email with file attachment');
        $email->setSubject('Subject');
        $email->addRecipient('foobar@example.com');
        $email->addAttachment(WP_LIB_EMAIL_TEST_DIR . '/fixtures/attachments/text.txt');

        $mailer = new Mailer();
        $mailer->send($email);

        $phpmailer = \IntegrationTests\tests_retrieve_phpmailer_instance();
        $this->assertStringEqualsFile(WP_LIB_EMAIL_TEST_DIR . '/fixtures/email-with-attachment.txt', $phpmailer->getSentMIMEMessage());
    }


    public function testEmailContentType()
    {
        $email = new PlainEmail();
        $email->setMessage('Email with <strong>HTML content</strong>');
        $email->setContentType('text/html');
        $email->setSubject('Subject');
        $email->addRecipient('foobar@example.com');

        $mailer = new Mailer();
        $mailer->send($email);

        $phpmailer = \IntegrationTests\tests_retrieve_phpmailer_instance();
        $this->assertStringEqualsFile(WP_LIB_EMAIL_TEST_DIR . '/fixtures/email-with-html-content-type.txt', $phpmailer->getSentMIMEMessage());
    }

    public function testEmailCcs()
    {
        $email = new PlainEmail();
        $email->setMessage('Email with <strong>HTML content</strong>');
        $email->setContentType('text/html');
        $email->setSubject('Subject');
        $email->addRecipient('foo@example.com');
        $email->addRecipient('bar@example.com');
        $email->addCc('baz@example.com');
        $email->addCc('corge@example.com');
        $email->addBlindCc('qux@example.com');
        $email->addBlindCc('quuz@example.com');

        $mailer = new Mailer();
        $mailer->send($email);

        $phpmailer = \IntegrationTests\tests_retrieve_phpmailer_instance();
        $this->assertStringEqualsFile(WP_LIB_EMAIL_TEST_DIR . '/fixtures/email-with-html-cc.txt', $phpmailer->getSentMIMEMessage());
    }

    public function testEmailFrom()
    {
        $email = new PlainEmail();
        $email->setMessage('Email with only the from email and name changed');
        $email->setSubject('Subject');
        $email->addRecipient('foobar@example.com');
        $email->setFrom('baz@example.com', 'Baz');

        $mailer = new Mailer();
        $mailer->send($email);

        $phpmailer = \IntegrationTests\tests_retrieve_phpmailer_instance();
        $this->assertStringEqualsFile(WP_LIB_EMAIL_TEST_DIR . '/fixtures/email-with-from.txt', $phpmailer->getSentMIMEMessage());
    }


    public function testEmailFromEmailOnly()
    {
        $email = new PlainEmail();
        $email->setMessage('Email with only the from email changed');
        $email->setSubject('Subject');
        $email->addRecipient('foobar@example.com');
        $email->setFrom('baz@example.com');

        $mailer = new Mailer();
        $mailer->send($email);

        $phpmailer = \IntegrationTests\tests_retrieve_phpmailer_instance();
        $this->assertStringEqualsFile(WP_LIB_EMAIL_TEST_DIR . '/fixtures/email-with-from-name.txt', $phpmailer->getSentMIMEMessage());
    }
}
