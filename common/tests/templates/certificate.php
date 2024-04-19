<?php

namespace common\tests\templates;

use common\models\Program;
use common\models\User;
use Faker\Factory;
use yii\helpers\ArrayHelper;

$faker = Factory::create();

$programs = ArrayHelper::index(Program::find()->select(['id'])->asArray()->all(), "id");
$users = ArrayHelper::index(User::find()->select(['id'])->asArray()->all(), "id");



return [
    'program_id' => $faker->randomElement($programs)['id'],
    'certificate_id' => $faker->isbn10(),
    'student_name' => $faker->name(),
    'issue_date' => $faker->date(),
    'created_at' => strtotime($faker->dateTimeThisYear()->format('Y-m-d H:i:s')),
    'updated_at' => strtotime($faker->dateTimeThisYear()->format('Y-m-d H:i:s')),
    'created_by' => $faker->randomElement($users)['id'],
    'updated_by' => $faker->randomElement($users)['id'],
];
