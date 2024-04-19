<?php

namespace common\tests\fixtures;

use common\models\Certificates;
use yii\test\ActiveFixture;

class CertificateFixture extends ActiveFixture
{
    public $modelClass = Certificates::class;
    public $dataFile = 'common\tests\fixtures\data\certificate.php';
}
