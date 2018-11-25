<?php
namespace WPLib\Email;

class Mailer
{

    private $email;

    public function send(Email $email)
    {

        if (count($email->getRecipients()) === 0) {
            throw new \InvalidArgumentException('Email must have at least one recipient');
        }

        if (empty($email->getMessage())) {
            throw new \InvalidArgumentException('Email message must be non-empty');
        }

        if (empty($email->getSubject())) {
            throw new \InvalidArgumentException('Email subject must be non-empty');
        }

        $this->email = $email;

        add_filter('wp_mail_content_type', array($this, '_setContentType'));

        if ($this->email->getFromEmail() !== null) {
            add_filter('wp_mail_from', array($this, '_setFromEmail'));
        }
        if ($this->email->getFromName() !== null) {
            add_filter('wp_mail_from_name', array($this, '_setFromName'));
        }

        if ($this->email->getStringAttachments()) {
            add_action('phpmailer_init', array($this, '_addAttachments'));
        }

        $send = \wp_mail(
            $email->getRecipients(),
            $email->getSubject(),
            $email->getMessage(),
            $this->buildHeaders(),
            $email->getAttachments()
        );

        remove_filter('wp_mail_content_type', array($this, '_setContentType'));
        remove_filter('phpmailer_init', array($this, '_addAttachments'));

        $this->email = null;
        return $send;
    }

    public function buildHeaders()
    {
        $headers = [];

        $CCs = $this->email->getCC();
        if ($CCs) {
            foreach ($CCs as $cc) {
                $headers[] = "Cc: $cc";
            }
        }

        $BCCs = $this->email->getBlindCc();
        if ($BCCs) {
            foreach ($BCCs as $bcc) {
                $headers[] = "Bcc: $bcc";
            }
        }

        return $headers;
    }


    public function _setContentType($contentType)
    {
        return $this->email->getContentType() ? $this->email->getContentType() : $contentType;
    }

    public function _addAttachments($phpmailer)
    {
        if ($this->email->getStringAttachments()) {
            $attachments = $this->email->getStringAttachments();
            foreach ($attachments as $filename => $content) {
                $phpmailer->AddStringAttachment($content, $filename);
            }
        }
    }

    public function _setFromEmail($from)
    {
        return $this->email->getFromEmail();
    }

    public function _setFromName($fromName)
    {
        return $this->email->getFromName();
    }
}
