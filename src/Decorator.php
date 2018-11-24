<?php
namespace StephenHarris\WPEmail;

abstract class Decorator implements Email
{
    private $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    public function addRecipient($recipient)
    {
        $this->email->addRecipient($recipient);
    }

    public function setRecipients($recipients)
    {
        $this->email->setRecipients($recipients);
    }

    public function getRecipients()
    {
        return $this->email->getRecipients();
    }

    public function setMessage($message)
    {
        $this->email->setMessage($message);
    }

    public function getMessage()
    {
        return $this->email->getMessage();
    }

    public function setSubject($subject)
    {
        $this->email->setSubject($subject);
    }

    public function getSubject()
    {
        return $this->email->getSubject();
    }

    public function addCc($recipient)
    {
        $this->email->addCc($recipient);
    }

    public function setCc($recipients)
    {
        $this->email->setCc($recipients);
    }

    public function getCc()
    {
        return $this->email->getCc();
    }

    public function addBlindCc($recipient)
    {
        $this->email->addBlindCc($recipient);
    }

    public function setBlindCc($recipients)
    {
        $this->email->setBlindCc($recipients);
    }

    public function getBlindCc()
    {
        return $this->email->getBlindCc();
    }

    public function addAttachment($absolutePathToAttachment)
    {
        $this->email->addAttachment($absolutePathToAttachment);
    }

    public function getAttachments()
    {
        return $this->email->getAttachments();
    }

    public function addStringAttachment($content, $filename)
    {
        $this->email->addStringAttachment($content, $filename);
    }

    public function getStringAttachments()
    {
        return $this->email->getStringAttachments();
    }

    public function setContentType($contentType)
    {
        $this->email->setContentType($contentType);
    }

    public function getContentType()
    {
        return $this->email->getContentType();
    }

    public function setFrom($email, $name = null)
    {
        $this->email->setFrom($email, $name);
    }

    public function getFromEmail()
    {
        return $this->email->getFromEmail();
    }

    public function getFromName()
    {
        return $this->email->getFromName();
    }

    public function setTemplate(Template $template)
    {
        $this->email->setTemplate($template);
    }
}
