<?php

use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;
use WPLib\Email\PlainEmail;
use WPLib\Email\Template;

final class EmailTest extends TestCase
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

    public function testAddingRecipient()
    {
        $email = new PlainEmail();
        $email->addRecipient('foo@example.com');
        $email->addRecipient('bar@example.com');

        $this->assertEquals(['foo@example.com', 'bar@example.com'], $email->getRecipients());
    }

    public function testSettingRecipients()
    {
        $email = new PlainEmail();
        $email->addRecipient('foo@example.com');
        $email->setRecipients(['bar@example.com']);

        $this->assertEquals(['bar@example.com'], $email->getRecipients());
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage setRecipients must be given an array of emails
     */
    public function testSettingRecipientsNotArray()
    {
        $email = new PlainEmail();
        $email->setRecipients('bar@example.com');
    }

    public function testSetMessageAndSubject()
    {
        $email = new PlainEmail();
        $email->setMessage('Foobar');
        $email->setSubject('Subject');
        $this->assertEquals('Foobar', $email->getMessage());
        $this->assertEquals('Subject', $email->getSubject());
    }

    public function testAddingCc()
    {
        $email = new PlainEmail();
        $email->addCc('foo@example.com');
        $email->addCc('bar@example.com');

        $this->assertEquals(['foo@example.com', 'bar@example.com'], $email->getCc());
    }

    public function testSettingCc()
    {
        $email = new PlainEmail();
        $email->addCc('foo@example.com');
        $email->setCc(['bar@example.com']);

        $this->assertEquals(['bar@example.com'], $email->getCc());
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage setCc must be given an array of emails
     */
    public function testSettingCcNotArray()
    {
        $email = new PlainEmail();
        $email->setCc('bar@example.com');
    }

    public function testAddingBcc()
    {
        $email = new PlainEmail();
        $email->addBlindCc('foo@example.com');
        $email->addBlindCc('bar@example.com');

        $this->assertEquals(['foo@example.com', 'bar@example.com'], $email->getBlindCc());
    }

    public function testSettingBcc()
    {
        $email = new PlainEmail();
        $email->addBlindCc('foo@example.com');
        $email->setBlindCc(['bar@example.com']);

        $this->assertEquals(['bar@example.com'], $email->getBlindCc());
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage setBlindCc must be given an array of emails
     */
    public function testSettingBlindcNotArray()
    {
        $email = new PlainEmail();
        $email->setBlindCc('bar@example.com');
    }

    public function testAddAttachment()
    {
        $email = new PlainEmail();
        $email->addAttachment('/absolute/path/to/file/to/upload.pdf');
        $email->addAttachment('/another/absolute/path/to/file.txt');

        $this->assertEquals(
            [
            '/absolute/path/to/file/to/upload.pdf',
            '/another/absolute/path/to/file.txt'
            ],
            $email->getAttachments()
        );
    }


    public function testAddStringAttachment()
    {
        $email = new PlainEmail();
        $email->addStringAttachment('...content to add ...', 'attached-file-name.pdf');
        $email->addStringAttachment('...more content ...', 'file-name.txt');

        $this->assertEquals(
            [
            'attached-file-name.pdf' => '...content to add ...',
            'file-name.txt' => '...more content ...'
            ],
            $email->getStringAttachments()
        );
    }


    public function testSetContentType()
    {
        $email = new PlainEmail();
        $email->setContentType("text/html");

        $this->assertEquals("text/html", $email->getContentType());
    }

    public function testSetFromEmailOnly()
    {
        $email = new PlainEmail();
        $email->setFrom("test@example.com");
        $this->assertEquals('test@example.com', $email->getFromEmail());
        $this->assertNull($email->getFromName());
    }

    public function testSetFromEmail()
    {
        $email = new PlainEmail();
        $email->setFrom("test@example.com", 'Test');
        $this->assertEquals('test@example.com', $email->getFromEmail());
        $this->assertEquals('Test', $email->getFromName());
    }

    public function testGetMessageWithTemplate()
    {
        $email = new PlainEmail();
        $mockTemplate = $this->createMock(Template::class);
        $mockTemplate->expects($this->once())
            ->method('applyTemplate')
            ->with('Foobar')
            ->willReturn('<body style="background:#cdcdcd"><div>Foobar</div></body>');

        $email->setMessage('Foobar');
        $email->setTemplate($mockTemplate);
    
        $this->assertEquals(
            '<body style="background:#cdcdcd"><div>Foobar</div></body>',
            $email->getMessage()
        );
    }
}
