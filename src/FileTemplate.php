<?php
namespace StephenHarris\WPEmail;

class FileTemplate implements Template
{

    private $template;

    public function __construct($template)
    {
        if (!$template || !file_exists($template)) {
            throw new \InvalidArgumentException(sprintf(
                'Template file "%s" does not exist',
                $template
            ));
        }
        $this->template = $template;
    }

    public function applyTemplate($message)
    {
        $content = $message;
        ob_start();
        require($this->template);
        return ob_get_clean();
    }
}
