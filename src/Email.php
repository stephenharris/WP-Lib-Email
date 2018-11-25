<?php
namespace WPLib\Email;

interface Email
{

    const CONTENT_TYPE_HTML = 'text/html';

    const CONTENT_TYPE_PLAIN = 'text/plain';

    public function addRecipient($recipient);

    public function setRecipients($recipients);

    public function getRecipients();

    public function setMessage($message);

    public function getMessage();

    public function setSubject($subject);

    public function getSubject();

    public function addCc($recipient);

    public function setCc($recipients);

    public function getCc();

    public function addBlindCc($recipient);

    public function setBlindCc($recipients);

    public function getBlindCc();

    public function addAttachment($absolutePathToAttachment);

    public function getAttachments();

    public function addStringAttachment($content, $filename);

    public function getStringAttachments();

    public function setContentType($contentType);

    public function getContentType();

    public function setFrom($email, $name = null);

    public function getFromEmail();

    public function getFromName();

    public function setTemplate(Template $template);
}
