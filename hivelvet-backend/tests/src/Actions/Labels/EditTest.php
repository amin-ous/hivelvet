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

namespace Actions\Labels;

use Fake\LabelFaker;
use Faker\Factory as Faker;
use ReflectionException;
use Test\Scenario;

/**
 * @internal
 *
 * @coversNothing
 */
final class EditTest extends Scenario
{
    final protected const EDIT_LABEL_ROUTE = 'PUT /labels/';
    protected $group                       = 'Actions Label Edit';

    /**
     * @param $f3
     *
     * @return array
     *
     * @throws ReflectionException
     */
    public function testNonExistingLabel($f3)
    {
        $test  = $this->newTest();
        $faker = Faker::create();
        $data  = LabelFaker::generateJsondata();

        $f3->mock(self::EDIT_LABEL_ROUTE . $nonExistingId = $faker->numberBetween(1000), null, null, $this->postJsonData($data));
        $test->expect($this->compareTemplateToResponse('not_found_error.json'), 'edit non existing label with id "' . $nonExistingId . '" show an error');

        return $test->results();
    }

    /**
     * @param $f3
     *
     * @return array
     *
     * @throws ReflectionException
     */
    public function testEmptyName($f3)
    {
        $test  = $this->newTest();
        $label = LabelFaker::create();
        $data  = LabelFaker::generateJsondata(['name' => '']);
        $f3->mock(self::EDIT_LABEL_ROUTE . $label->id, null, null, $this->postJsonData($data));
        $test->expect($this->compareTemplateToResponse('label/empty_name_error.json'), 'Empty name');

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
        $test  = $this->newTest();
        $label = LabelFaker::create();
        $data  = LabelFaker::generateJsondata(['name' => $label->name]);
        $f3->mock(self::EDIT_LABEL_ROUTE . $label->id, null, null, $this->postJsonData($data));
        $test->expect($this->compareTemplateToResponse('label/exist_error.json'), 'edit label with an existing name "' . $label->name . '" show an error');

        return $test->results();
    }

    /**
     * @param $f3
     *
     * @return array
     *
     * @throws ReflectionException
     */
    public function testInvalidColor($f3)
    {
        $test  = $this->newTest();
        $label = LabelFaker::create();
        $data  = LabelFaker::generateJsondata(['color' => '#ffffXX']);

        $f3->mock(self::EDIT_LABEL_ROUTE . $label->id, null, null, $this->postJsonData($data));
        $test->expect($this->compareTemplateToResponse('label/invalid_color_error.json'), 'Invalid Color');

        return $test->results();
    }

    public function testValidLabel($f3)
    {
        $test  = $this->newTest();
        $label = LabelFaker::create();
        $data  = LabelFaker::generateJsondata();

        $f3->mock(self::EDIT_LABEL_ROUTE . $label->id, null, null, $this->postJsonData($data));
        $test->expect($this->compareTemplateToResponse('label/edit_success.json'), 'Update existing label with id "' . $label->id . '" using new name "' . $label->name . '" successfully');

        // Asserting that the changes took place at the model layer.
        $label->load(['id = ?', $label->id]);
        $test->expect($f3->snakeCase($data['data']['name']) === $label->name, 'Label with id "' . $label->id . '" "name" updated in the DB.');
        $test->expect($data['data']['description'] === $label->description, 'Label with id "' . $label->id . '" "description" updated in the DB.');
        $test->expect($data['data']['color'] === $label->color, 'Label with id "' . $label->id . '" "color" updated in the DB.');

        return $test->results();
    }
}
