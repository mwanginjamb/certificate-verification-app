<?php

namespace common\tests\fixtures;

use common\models\Program;
use yii\test\ActiveFixture;

class ProgramFixture extends ActiveFixture
{
    public $modelClass = Program::class;
    public $dataFile = 'common\tests\fixtures\data\program.php';
}
