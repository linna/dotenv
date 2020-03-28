<?php

/**
 * Linna Framework.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types = 1);

namespace Linna\DotEnv;

/**
 * DotEnv.
 *
 * Load variables from a .env file to environment.
 */
class DotEnv
{
    /**
     * @var array Matches for particula values
     */
    private static $valuesMatches = [
        'true' => true,
        '(true)' => true,
        'false' => false,
        '(false)' => false,
        'empty' => '',
        '(empty)' => '',
        'null' => null,
        '(null)' => null,
    ];

    /**
     * Get a value from environment.
     *
     * @param string $key     Key name
     * @param mixed  $default Default value if key not found
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        if (($value = \getenv($key)) === false) {
            return $default;
        }

        if (\array_key_exists(\strtolower($value), self::$valuesMatches)) {
            return self::$valuesMatches[\strtolower($value)];
        }

        return $value;
    }

    /**
     * Load environment variables from file.
     *
     * @param string $file Path to .env file
     *
     * @return bool
     */
    public function load(string $file): bool
    {
        if (!\file_exists($file)) {
            return false;
        }

        $content = \file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($content as $line) {
            $line = \rtrim(\ltrim($line));

            //check if the line contains a key value pair
            if (!\preg_match("/^\s*([\w.-]+)\s*=\s*(.*)?\s*$/", $line)) {
                continue;
            }

            [$key, $value] = \explode('=', $line, 2);

            //remove special chars from beninning and end of key values
            $key = \trim($key, " \t\n\r\0\x0B");
            $value = \trim($value, " \t\n\r\0\x0B");

            //set to empty value
            if (\strlen($value) === 0) {
                \putenv("{$key}=");
                continue;
            }

            //remove single and double quotes
            $this->unQuote($value);

            \putenv("{$key}={$value}");
        }

        return true;
    }

    /**
     * Remove quotes or double quotes from the begin and the end of a string
     * 
     * @param string $value
     * 
     * @return void
     */
    private function unQuote(string &$value): void
    {
        $first = $value[0];
        $last = $value[-1];
        $edges = $first.$last;

        //string begin and end with ' or "
        if ($edges === "''" || $edges === '""') {
            $value = \substr($value, 1, -1);
        }

        //string begin with ' or "
        else if ($first === "'" || $first === '"') {
            $value = \substr($value, 1);
        }

        //string end with ' or "
        else if ($last === "'" || $last === '"') {
            $value = \substr($value, 0, -1);
        }
    }
}
