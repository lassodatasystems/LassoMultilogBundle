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
namespace Lasso\MultilogBundle\Tests\Integration;

use Lasso\MultilogBundle\JsonLogObject;
use Lasso\MultilogBundle\MultilogFactory;
use PHPUnit_Framework_TestCase;

/**
 * Test
 */
class MultilogFactoryTest extends PHPUnit_Framework_TestCase
{
    const LOG_PATH            = '/tmp/lasso_multilog_bundle_test_log.log';
    const ADDITIONAL_LOG_PATH = '/tmp/lasso_multilog_bundle_additional_test_log.log';

    private function deleteLogFiles()
    {
        if (file_exists(self::LOG_PATH)) {
            unlink(self::LOG_PATH);
        }
        if (file_exists(self::ADDITIONAL_LOG_PATH)) {
            unlink(self::ADDITIONAL_LOG_PATH);
        }
    }

    public function setUp()
    {
        $this->deleteLogFiles();

        touch(self::LOG_PATH);
        chmod(self::LOG_PATH, 0666);
        touch(self::ADDITIONAL_LOG_PATH);
        chmod(self::ADDITIONAL_LOG_PATH, 0666);
    }

    /**
     * @test
     */
    public function logToFile()
    {
        $message = 'This is a test';

        $factory = new MultilogFactory();
        $logger  = $factory->get(self::LOG_PATH);

        $logger->info($message);

        $this->assertEquals("{$message}\n", file_get_contents(self::LOG_PATH));
    }

    /**
     * @test
     */
    public function logArrayAsJson()
    {
        $factory = new MultilogFactory();
        $logger  = $factory->get(self::LOG_PATH);

        $logger->info(new JsonLogObject(['one' => '1']));

        $data = json_decode(file_get_contents(self::LOG_PATH), true);

        $this->assertArrayHasKey('one', $data);
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertEquals('1', $data['one']);
    }

    /**
     * @test
     */
    public function multipleLoggersAtTheSameTime()
    {
        $message = 'This is a test';

        $factory = new MultilogFactory();

        $loggerA = $factory->get(self::LOG_PATH);
        $loggerB = $factory->get(self::ADDITIONAL_LOG_PATH);

        $loggerA->info($message);
        $loggerB->info($message);

        $this->assertEquals("{$message}\n", file_get_contents(self::LOG_PATH));
        $this->assertEquals("{$message}\n", file_get_contents(self::ADDITIONAL_LOG_PATH));
    }

    public function tearDown()
    {
        $this->deleteLogFiles();
    }
}
