<?php

declare(strict_types=1);

/*
 * Hivelvet open source platform - https://riadvice.tn/
 *
 * Copyright (c) 2022 RIADVICE SUARL and by respective authors (see below).
 *
 * This program is free software; you can redistribute it and/or modify it under the
 * terms of the GNU Lesser General Public License as published by the Free Software
 * Foundation; either version 3.0 of the License, or (at your option) any later
 * version.
 *
 * Hivelvet is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with Hivelvet; if not, see <http://www.gnu.org/licenses/>.
 */

namespace Actions\Core;

use Test\Scenario;

/**
 * @internal
 *
 * @coversNothing
 */
final class GetLocaleTest extends Scenario
{
    protected $group = 'Action Core GetLocale';

    /**
     * @param $f3 \Base
     *
     * @return array
     */
    public function testGetLocale($f3)
    {
        $test = $this->newTest();
        $f3->mock('GET /locale/json/en-GB.json [ajax]');

        json_decode($f3->get('RESPONSE'));

        $test->expect(JSON_ERROR_NONE === json_last_error(), 'Create JSON localisation on the fly is valid caching ON');

        return $test->results();
    }
}
