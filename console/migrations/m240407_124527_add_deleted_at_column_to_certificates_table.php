<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%certificates}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m240407_124527_add_deleted_at_column_to_certificates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%certificates}}', 'deleted_at', $this->integer(20));
        $this->addColumn('{{%certificates}}', 'deleted_by', $this->integer());

        // creates index for column `deleted_by`
        $this->createIndex(
            '{{%idx-certificates-deleted_by}}',
            '{{%certificates}}',
            'deleted_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-certificates-deleted_by}}',
            '{{%certificates}}',
            'deleted_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-certificates-deleted_by}}',
            '{{%certificates}}'
        );

        // drops index for column `deleted_by`
        $this->dropIndex(
            '{{%idx-certificates-deleted_by}}',
            '{{%certificates}}'
        );

        $this->dropColumn('{{%certificates}}', 'deleted_at');
        $this->dropColumn('{{%certificates}}', 'deleted_by');
    }
}
