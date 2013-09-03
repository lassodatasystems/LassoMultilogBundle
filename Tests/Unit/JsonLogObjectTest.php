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
namespace Lasso\MultilogBundle\Tests\Unit;
use Lasso\MultilogBundle\JsonLogObject;
use PHPUnit_Framework_TestCase;

/**
 * Test
 */
class JsonLogObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function turnValuesIntoJsonString()
    {
        $message = new JsonLogObject([
            'one' => [2, 3]
        ]);

        $messageData = json_decode((string)$message, true);

        $this->assertEquals(['one', 'timestamp'], array_keys($messageData));
        $this->assertEquals($messageData['one'], [2, 3]);
    }
}
