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

namespace Actions\Roles;

use Fake\RoleFaker;
use ReflectionException;
use Test\Scenario;

/**
 * @internal
 *
 * @coversNothing
 */
final class AddTest extends Scenario
{
    final protected const ADD_ROLE_ROUTE = 'POST /roles';
    protected $group                     = 'Action Role Add';

    /**
     * @param $f3
     *
     * @return array
     *
     * @throws ReflectionException
     */
    public function testEmptyName($f3)
    {
        $test = $this->newTest();

        $data = ['data' => ['name' => '']];
        $f3->mock(self::ADD_ROLE_ROUTE, null, null, $this->postJsonData($data));
        $test->expect($this->compareTemplateToResponse('role/empty_error.json'), 'Add role with an empty name show an error');

        return $test->results();
    }

    /**
     * @param $f3
     *
     * @return array
     *
     * @throws ReflectionException
     */
    public function testExistingName($f3)
    {
        $test = $this->newTest();

        $role = RoleFaker::create();
        $data = ['data' => ['name' => $role->name]];
        $f3->mock(self::ADD_ROLE_ROUTE, null, null, $this->postJsonData($data));
        $test->expect($this->compareTemplateToResponse('role/exist_error.json'), 'Add role with an existing name "' . $role->name . '" show an error');

        return $test->results();
    }
}
