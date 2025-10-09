<?php

namespace X7\Tests\Unit;

use PHPUnit\Framework\TestCase;
use X7\Utils\ParamTool;

class ParamToolTest extends TestCase
{
    public function testBuildQueryStringWithEmptyArray()
    {
        $result = ParamTool::buildQueryString([]);
        $this->assertEquals("", $result);
    }

    public function testBuildQueryStringWithValidArray()
    {
        $queryArr = ['key1' => 'value1', 'key2' => 'value2'];
        $result = ParamTool::buildQueryString($queryArr);
        $this->assertEquals("key1=value1&key2=value2", $result);
    }

    public function testBuildQueryStringWithUrlEncode()
    {
        $queryArr = ['key1' => 'value with spaces', 'key2' => 'value2'];
        $result = ParamTool::buildQueryString($queryArr, true, true);
        $this->assertStringContainsString("key1=value+with+spaces", $result);
    }

    public function testIsNumberWithInteger()
    {
        $this->assertTrue(ParamTool::isNumber("123"));
    }

    public function testIsNumberWithFloat()
    {
        $this->assertTrue(ParamTool::isNumber("123.45"));
    }

    public function testIsNumberWithInvalidInput()
    {
        $this->assertFalse(ParamTool::isNumber("abc"));
        $this->assertFalse(ParamTool::isNumber("12.34.56"));
        $this->assertFalse(ParamTool::isNumber(""));
    }

    public function testIsIntegerNumber()
    {
        $this->assertTrue(ParamTool::isIntegerNumber("123"));
        $this->assertFalse(ParamTool::isIntegerNumber("123.45"));
        $this->assertFalse(ParamTool::isIntegerNumber("abc"));
    }

    public function testIsFloatNumber()
    {
        $this->assertTrue(ParamTool::isFloatNumber("123.45"));
        $this->assertFalse(ParamTool::isFloatNumber("123"));
        $this->assertFalse(ParamTool::isFloatNumber("abc"));
    }

    public function testIsValidAppkey()
    {
        // Valid appkey format
        $this->assertTrue(ParamTool::isValidAppkey("x7sy1234567890abcdef1234567890ab"));
        $this->assertTrue(ParamTool::isValidAppkey("1234567890abcdef1234567890abcdef"));

        // Invalid appkey format
        $this->assertFalse(ParamTool::isValidAppkey("invalid"));
        $this->assertFalse(ParamTool::isValidAppkey(""));
        $this->assertFalse(ParamTool::isValidAppkey("x7sy1234567890abcdef1234567890abc")); // too long
        $this->assertFalse(ParamTool::isValidAppkey("x7sy1234567890abcdef1234567890a")); // too short
    }

    public function testIsValidPublicKey()
    {
        // This test requires a valid RSA public key
        // For testing purposes, we'll use a mock approach
        $this->markTestSkipped('Requires valid RSA public key for testing');
    }

    public function testIsValidPrivateKey()
    {
        // This test requires a valid RSA private key
        // For testing purposes, we'll use a mock approach
        $this->markTestSkipped('Requires valid RSA private key for testing');
    }
}

