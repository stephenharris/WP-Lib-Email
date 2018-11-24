<?php
namespace StephenHarris\WPEmail;

class PlainEmail implements Email
{

    private $to = [];
    private $cc = [];
    private $bcc = [];
    private $attachments = [];
    private $stringAttachments = [];
    private $message = '';
    private $subject = '';
    private $contentType = null;
    private $from = null;
    private $fromName = null;
    private $template = null;

    public function addRecipient($recipient)
    {
        $this->to[] = $recipient;
    }

    public function setRecipients($recipients)
    {
        if (!is_array($recipients)) {
            throw new \InvalidArgumentException('setRecipients must be given an array of emails');
        }
        $this->to = $recipients;
    }

    public function getRecipients()
    {
        return $this->to;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        $message = $this->message;
        if ($this->template) {
            $message = $this->template->applyTemplate($message);
        }
        return $message;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function addCc($recipient)
    {
        $this->cc[] = $recipient;
    }

    public function setCc($recipients)
    {
        if (!is_array($recipients)) {
            throw new \InvalidArgumentException('setCc must be given an array of emails');
        }
        $this->cc = $recipients;
    }

    public function getCc()
    {
        return $this->cc;
    }

    public function addBlindCc($recipient)
    {
        $this->bcc[] = $recipient;
    }

    public function setBlindCc($recipients)
    {
        if (!is_array($recipients)) {
            throw new \InvalidArgumentException('setBlindCc must be given an array of emails');
        }
        $this->bcc = $recipients;
    }

    public function getBlindCc()
    {
        return $this->bcc;
    }

    public function addAttachment($absolutePathToAttachment)
    {
        $this->attachments[] = $absolutePathToAttachment;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function addStringAttachment($content, $filename)
    {
        $this->stringAttachments[$filename] = $content;
    }

    public function getStringAttachments()
    {
        return $this->stringAttachments;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function setFrom($email, $name = null)
    {
        $this->from = $email;
        $this->fromName = $name;
    }

    public function getFromEmail()
    {
        return $this->from ;
    }

    public function getFromName()
    {
        return $this->fromName ;
    }

    public function setTemplate(Template $template)
    {
        $this->template = $template;
    }
}
