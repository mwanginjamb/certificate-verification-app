<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%certificates}}`.
 */
class m240410_105657_add_certificate_id_column_to_certificates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%certificates}}', 'certificate_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%certificates}}', 'certificate_id');
    }
}
