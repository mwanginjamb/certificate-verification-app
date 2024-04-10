<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%program}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m240407_091021_create_program_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%program}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
            'created_at' => $this->integer(20),
            'updated_at' => $this->integer(20),
            'updated_by' => $this->integer(),
            'created_by' => $this->integer(),
        ]);

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-program-updated_by}}',
            '{{%program}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-program-updated_by}}',
            '{{%program}}',
            'updated_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-program-created_by}}',
            '{{%program}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-program-created_by}}',
            '{{%program}}',
            'created_by',
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
            '{{%fk-program-updated_by}}',
            '{{%program}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-program-updated_by}}',
            '{{%program}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-program-created_by}}',
            '{{%program}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-program-created_by}}',
            '{{%program}}'
        );

        $this->dropTable('{{%program}}');
    }
}
