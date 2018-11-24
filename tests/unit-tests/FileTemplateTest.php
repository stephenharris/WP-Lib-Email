<?php

use PHPUnit\Framework\TestCase;
use StephenHarris\WPEmail\FileTemplate;

final class FileTemplateTest extends TestCase
{

    public function testApplyTemplate()
    {
        $template = new FileTemplate(WP_LIB_EMAIL_TEST_DIR . '/fixtures/example-template.php');

        $actual = $template->applyTemplate("This is the content of the message");
        
        $this->assertEquals(
            file_get_contents(WP_LIB_EMAIL_TEST_DIR . '/fixtures/example-template-rendered.html'),
            $actual
        );
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessageRegExp /Template file "\S+\/fixtures\/does-not-exist.php" does not exist/
     */
    public function testTemplateNoExists()
    {
        $template = new FileTemplate(WP_LIB_EMAIL_TEST_DIR . '/fixtures/does-not-exist.php');
    }
}
