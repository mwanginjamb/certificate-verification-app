<?php

namespace common\tests\fixtures;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'common\models\User';
    public $dataFile = 'common\tests\fixtures\data\user.php';
}
