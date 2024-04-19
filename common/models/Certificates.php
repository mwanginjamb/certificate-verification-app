<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "certificates".
 *
 * @property int $id
 * @property int|null $program_id
 * @property string|null $student_name
 * @property string|null $issue_date
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $created_by
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property User $createdBy
 * @property User $deletedBy
 * @property Program $program
 * @property User $updatedBy
 */
class Certificates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'certificates';
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['program_id', 'created_at', 'updated_at', 'updated_by', 'created_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['issue_date'], 'safe'],
            [['certificate_id'], 'string'],
            [['student_name'], 'string', 'max' => 250],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['deleted_by' => 'id']],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => Program::class, 'targetAttribute' => ['program_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'certificate_id' => Yii::t('app', 'Certificate_id'),
            'program_id' => Yii::t('app', 'Program ID'),
            'student_name' => Yii::t('app', 'Student Name'),
            'issue_date' => Yii::t('app', 'Issue Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_by' => Yii::t('app', 'Created By'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[DeletedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::class, ['id' => 'deleted_by']);
    }

    /**
     * Gets query for [[Program]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(Program::class, ['id' => 'program_id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
