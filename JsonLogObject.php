<?php
/*
 * Copyright 2013 Lasso Data Systems
 *
 * This file is part of LassoMultilog.
 *
 * LassoMultilog is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * LassoMultilog is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with LassoMultilog. If not, see <http://www.gnu.org/licenses/>.
 *
 */
namespace Lasso\MultilogBundle;

use ArrayObject;

/**
 * Class JsonLogObject
 *
 * Simple wrapper class around an associative array. Adds a timestamp
 * field (for logstash) and outputs json when converted to a string.
 *
 * @package Lasso\MultilogBundle
 */
class JsonLogObject
{
    /**
     * Holds the values to log
     *
     * @var array
     */
    protected $values = [];

    /**
     * @param array $values
     */
    public function __construct(Array $values = [])
    {
        $this->setValues($values);
    }

    /**
     * @param array $values
     */
    public function setValues(Array $values)
    {
        $this->values = array_merge($this->values, $values);
    }

    /**
     * Requires the output of microtime() to be passed in.
     * _NOT_ microtime(true), as that creates a decimal number
     * which will not be parsed correctly.
     *
     * @param string $microTime
     *
     * @return string
     */
    public function makeTimestamp($microTime)
    {
        $timeParts = explode(' ', $microTime);
        $partOfSecond = $timeParts[0];
        $second = $timeParts[1];

        $microSeconds = explode('.', $partOfSecond)[1];

        return date('Y-m-d\TH:i:s.' . $microSeconds . 'O', $second);
    }

    /**
     * Add a timestamp to the data and return json
     *
     * @return string
     */
    public function __toString()
    {
        $this->values['timestamp'] = $this->makeTimestamp(microtime());

        return json_encode($this->ensureUtf8($this->values));
    }

    private function ensureUtf8($element) {
        if (is_string($element)) {
            $element = utf8_encode($element);
        } else  if (is_array($element)) {
            foreach ($element as $key => $value) {
                $element[$key] = $this->ensureUtf8($value);
            }
        } else if (is_object($element)) {
            foreach ($element as $key => $value) {
                $element->$key = $this->ensureUtf8($value);
            }
        }

        return $element;
    }
}
