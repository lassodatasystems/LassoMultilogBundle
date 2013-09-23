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
class JsonLogObject  {
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

    public function setValues(Array $values)
    {
        $this->values = array_merge($this->values, $values);
    }

    /**
     * Add a timestamp to the data and return json
     *
     * @return string
     */
    public function __toString()
    {
        $microtime = explode(' ', microtime())[0];
        $microseconds = explode('.', $microtime)[1];
        
        $this->values['timestamp'] = date('Y-m-d\TH:i:s.' . $microseconds . 'O');

        return json_encode($this->values);
    }
}
