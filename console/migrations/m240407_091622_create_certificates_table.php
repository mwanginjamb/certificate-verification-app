<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%certificates}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%program}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m240407_091622_create_certificates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%certificates}}', [
            'id' => $this->primaryKey(),
            'program_id' => $this->integer(),
            'student_name' => $this->string(250),
            'issue_date' => $this->date(),
            'created_at' => $this->integer(20),
            'updated_at' => $this->integer(20),
            'updated_by' => $this->integer(),
            'created_by' => $this->integer(),
        ]);

        // creates index for column `program_id`
        $this->createIndex(
            '{{%idx-certificates-program_id}}',
            '{{%certificates}}',
            'program_id'
        );

        // add foreign key for table `{{%program}}`
        $this->addForeignKey(
            '{{%fk-certificates-program_id}}',
            '{{%certificates}}',
            'program_id',
            '{{%program}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-certificates-updated_by}}',
            '{{%certificates}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-certificates-updated_by}}',
            '{{%certificates}}',
            'updated_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-certificates-created_by}}',
            '{{%certificates}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-certificates-created_by}}',
            '{{%certificates}}',
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
        // drops foreign key for table `{{%program}}`
        $this->dropForeignKey(
            '{{%fk-certificates-program_id}}',
            '{{%certificates}}'
        );

        // drops index for column `program_id`
        $this->dropIndex(
            '{{%idx-certificates-program_id}}',
            '{{%certificates}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-certificates-updated_by}}',
            '{{%certificates}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-certificates-updated_by}}',
            '{{%certificates}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-certificates-created_by}}',
            '{{%certificates}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-certificates-created_by}}',
            '{{%certificates}}'
        );

        $this->dropTable('{{%certificates}}');
    }
}
