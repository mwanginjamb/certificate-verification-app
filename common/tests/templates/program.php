<?php

namespace common\tests\templates;


use Faker\Factory;

$faker = Factory::create();


return [
    'name' => $faker->sentence(),
    'description' => $faker->text(),
    'start_date' => $faker->date(),
    'end_date' => $faker->date(),
    'created_at' => strtotime($faker->dateTimeThisYear()->format('Y-m-d H:i:s')),
    'updated_at' => strtotime($faker->dateTimeThisYear()->format('Y-m-d H:i:s')),
];
