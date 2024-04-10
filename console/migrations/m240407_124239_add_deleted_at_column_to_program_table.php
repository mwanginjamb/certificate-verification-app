<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%program}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m240407_124239_add_deleted_at_column_to_program_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%program}}', 'deleted_at', $this->integer(20));
        $this->addColumn('{{%program}}', 'deleted_by', $this->integer());

        // creates index for column `deleted_by`
        $this->createIndex(
            '{{%idx-program-deleted_by}}',
            '{{%program}}',
            'deleted_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-program-deleted_by}}',
            '{{%program}}',
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
            '{{%fk-program-deleted_by}}',
            '{{%program}}'
        );

        // drops index for column `deleted_by`
        $this->dropIndex(
            '{{%idx-program-deleted_by}}',
            '{{%program}}'
        );

        $this->dropColumn('{{%program}}', 'deleted_at');
        $this->dropColumn('{{%program}}', 'deleted_by');
    }
}
