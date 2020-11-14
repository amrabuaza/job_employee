<?php

namespace common\models\job;

use common\models\user\User;
use Yii;

/**
 * This is the model class for table "job_offer".
 *
 * @property int $id
 * @property float $price
 * @property int $job_id
 * @property int $employee_id
 *
 * @property User $employee
 * @property Job $job
 */
class JobOffer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_offer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'job_id', 'employee_id'], 'required'],
            [['price'], 'number'],
            [['job_id', 'employee_id'], 'integer'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => Job::className(), 'targetAttribute' => ['job_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'job_id' => 'Job ID',
            'employee_id' => 'Employee ID',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(User::className(), ['id' => 'employee_id']);
    }

    /**
     * Gets query for [[Job]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }
}
