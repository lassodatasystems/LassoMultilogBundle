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

use Monolog\Handler\StreamHandler;
use Symfony\Bridge\Monolog\Logger;

/**
 * Creates a configured logger
 *
 * Class MultilogFactory
 *
 * @package Lasso\MultilogBundle
 */
class MultilogFactory
{
    /**
     * @param string $path
     * @param string $channel
     * @param int    $priority
     *
     * @return Logger
     */
    public static function get($path, $channel = '', $priority = 200)
    {
        $formatter = new OnlyMessageFormatter();

        $handler = new StreamHandler($path, $priority);
        $handler->setFormatter($formatter);

        $logger = new Logger($channel);

        $logger->pushHandler($handler);

        return $logger;
    }
}
