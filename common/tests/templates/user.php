<?php

namespace common\tests\templates;

use Faker\Factory;
use Yii;

$faker = Factory::create();
return [
    'username' => $faker->userName(),
    'email' => $faker->email(),
    'password_hash' => Yii::$app->security->generatePasswordHash('password_' . $index),
    'auth_key' => Yii::$app->security->generateRandomString(),
    'verification_token' => Yii::$app->security->generateRandomString(),
    'created_at' => strtotime($faker->dateTimeThisYear()->format('Y-m-d H:i:s')),
    'updated_at' => strtotime($faker->dateTimeThisYear()->format('Y-m-d H:i:s')),

];
