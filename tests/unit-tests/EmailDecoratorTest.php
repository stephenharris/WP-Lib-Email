<?php

use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;
use StephenHarris\WPEmail\Email;
use StephenHarris\WPEmail\PlainEmail;
use StephenHarris\WPEmail\Decorator;

final class EmailDecoratorTest extends TestCase
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
     * @dataProvider methodProvider
     */
    public function testDecorates($method, $args)
    {
        $stubEmail = $this->createMock(PlainEmail::class);
        $builder = $stubEmail->expects($this->once())->method($method);

        if ($args) {
            $builder = call_user_func_array([$builder,'with'], $args);
        }
        
        $decorator = new StubDecorator($stubEmail);

        call_user_func_array([$decorator,$method], $args);
    }

    public function methodProvider()
    {
        $class = new ReflectionClass(Email::class);
        $methods = [];
        foreach ($class->getMethods() as $method) {
            $r = new ReflectionMethod(Email::class, $method->name);
            $params = array_map(function ($param) {
                $type = $param->getType();
                if (is_null($type)) {
                    return '';
                }
                switch ($type->__toString()) {
                    case 'string':
                        return 'string';
                    case 'int':
                        return int;
                    case 'boolean':
                        return bool;
                    default:
                        if ($type->allowsNull()) {
                            return '';
                        }

                        return $this->createMock($type->__toString());
                }
                return '';
            }, $r->getParameters());
            $methods[$method->name] = [$method->name, $params];
        }
        return $methods;
    }

    /**
     * @dataProvider methodReturnsProvider
     */
    public function testDecorateReturnMethods($method, $return)
    {
        $stubEmail = $this->createMock(PlainEmail::class);
        $stubEmail->expects($this->once())
            ->method($method)
            ->willReturn($return);

        $decorator = new StubDecorator($stubEmail);

        $this->assertEquals($return, $decorator->$method());
    }

    public function methodReturnsProvider()
    {
        return [
            'getMessage' => ['getMessage', 'message'],
            'getSubject' => ['getSubject', 'subject'],
            'getCc' => ['getCc', ['foo@bar.com', 'bar@baz.com']],
            'getBlindCc' => ['getBlindCc', ['foo@bar.com', 'bar@baz.com']],
            'getAttachments' => ['getAttachments', ['/path/to/attachment']],
            'getStringAttachments' => ['getStringAttachments', ['filename.pdf' => 'content']],
            'getContentType' => ['getContentType', 'text/html'],
            'getFromEmail' => ['getFromEmail', 'foo@bar.com'],
            'getFromName' => ['getFromName', 'Foo Bar'],
        ];
    }
}

class StubDecorator extends \StephenHarris\WPEmail\Decorator {
    
}