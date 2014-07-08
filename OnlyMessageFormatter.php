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
use Monolog\Formatter\FormatterInterface;

/**
 * Format logging messages for the mailscanner log in the right format
 */
class OnlyMessageFormatter implements FormatterInterface
{
    /**
     * Convert a record into json
     *
     * @param array $record
     *
     * @return string
     */
    public function format(Array $record)
    {
        return $record['message'] . "\n";
    }

    /**
     * Convert multiple records into multiple lines of json
     *
     * @param array $records
     *
     * @return string
     */
    public function formatBatch(Array $records)
    {
        $self = $this;

        return json_encode(array_map(function($record) use ($self) {
            return $self->format($record);
        }, $records));
    }
}
