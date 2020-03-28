<?php

/**
 * Linna Framework.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\Tests;

use Linna\DotEnv\DotEnv;
use PHPUnit\Framework\TestCase;

/**
 * DotEnv test.
 */
class DotEnvTest extends TestCase
{
    /**
     * Test new instance.
     *
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(DotEnv::class, new DotEnv());
    }

    /**
     * Test load existing file.
     */
    public function testLoadFile(): void
    {
        $this->assertTrue((new DotEnv())->load(__DIR__.'/.env.test'));
    }

    /**
     * Test load non-existent file.
     */
    public function testLoadBadFile(): void
    {
        $this->assertFalse((new DotEnv())->load(__DIR__.'/.env.bad.test'));
    }

    /**
     * Env values provider.
     *
     * @return array
     */
    public function envProvider(): array
    {
        return [
            ['PHP_ENV', 'development'],
            ['BASIC', 'basic'],
            ['AFTER_LINE', 'after_line'],
            ['UNDEFINED_EXPAND', '$TOTALLY_UNDEFINED_ENV_KEY'],
            ['EMPTY', ''],
            ['SINGLE_QUOTES', 'single_quotes'],
            ['DOUBLE_QUOTES', 'double_quotes'],
            ['SINGLE_QUOTES_FIRST', 'single_quotes'],
            ['DOUBLE_QUOTES_FIRST', 'double_quotes'],
            ['SINGLE_QUOTES_LAST', 'single_quotes'],
            ['DOUBLE_QUOTES_LAST', 'double_quotes'],
            ['EXPAND_NEWLINES', 'expand\nnewlines'],
            ['DONT_EXPAND_NEWLINES_1', 'dontexpand\nnewlines'],
            ['DONT_EXPAND_NEWLINES_2', 'dontexpand\nnewlines'],
            ['EQUAL_SIGNS_1', 'equals=='],
            ['EQUAL_SIGNS_2', 'equals=another;foo=bar'],
            ['RETAIN_INNER_QUOTES', '{"foo": "bar"}'],
            ['RETAIN_INNER_QUOTES_AS_STRING', '{"foo": "bar"}'],
            ['INCLUDE_SPACE', 'some spaced out string'],
            ['USERNAME', 'therealnerdybeast@example.tld'],
            ['TEST', 'ALFA'],
            ['TEST_1', 'BETA'],
            ['TEST_2', 'GAMMA']
         ];
    }

    /**
     * Test keys and values.
     *
     * @dataProvider envProvider
     *
     * @param string $key
     * @param string $value
     */
    public function testKeyValue(string $key, string $value): void
    {
        $d = new DotEnv();
        $d->load(__DIR__.'/.env.test');

        $this->assertSame($value, $d->get($key));
    }

    /**
     * Test default value.
     */
    public function testDefaultValue(): void
    {
        \putenv('FOO=foo');
        $this->assertSame('bar', (new DotEnv())->get('BAR', 'bar'));
    }

    /**
     * Env particular values provider.
     *
     * @return array
     */
    public function envParticularValuesProvider(): array
    {
        return [
            ['FOO_1', 'foo'],   //FOO_1=foo
            ['FOO_2', true],    //FOO_2=true
            ['FOO_3', true],    //FOO_3=(true)
            ['FOO_4', false],   //FOO_4=false
            ['FOO_5', false],   //FOO_5=(false)
            ['FOO_6', ''],      //FOO_6=empty
            ['FOO_7', ''],      //FOO_7=(empty)
            ['FOO_8', null],    //FOO_8=null
            ['FOO_9', null],    //FOO_9=(null)
            ['FOO_10', 'foo'],  //FOO_10="foo"
            ['FOO_11', 'fo'],   //FOO_11="fo"
            ['FOO_12', 'f'],    //FOO_12="f"
            ['FOO_13', ''],     //FOO_13="
            #case insensitive for special values
            ['FOO_14', true],   //FOO_14=TRUE
            ['FOO_15', true],   //FOO_15=(TRUE)
            ['FOO_16', false],  //FOO_16=FALSE
            ['FOO_17', false],  //FOO_17=(FALSE)
            ['FOO_18', ''],     //FOO_18=EMPTY
            ['FOO_19', ''],     //FOO_19=(EMPTY)
            ['FOO_20', null],   //FOO_20=NULL
            ['FOO_21', null]    //FOO_21=(NULL)
        ];
    }

    /**
     * Test particular keys and values.
     *
     * @dataProvider envParticularValuesProvider
     *
     * @param string $key
     * @param mixed $value
     */
    public function testParticularKeyValue(string $key, $value): void
    {
        $d = new DotEnv();
        $d->load(__DIR__.'/.env.type.test');

        $this->assertSame($value, $d->get($key));
    }
}
