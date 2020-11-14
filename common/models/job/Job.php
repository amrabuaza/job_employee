<?php

namespace common\models\job;

use common\models\user\User;
use Yii;

/**
 * This is the model class for table "job".
 *
 * @property int $id
 * @property string|null $status
 * @property float $price
 * @property int $owner_id
 * @property int|null $employee_id
 * @property int $address_id
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property JobAddress $address
 * @property User $employee
 * @property User $owner
 * @property JobOffer[] $jobOffers
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'string'],
            [['price', 'owner_id', 'address_id'], 'required'],
            [['price'], 'number'],
            [['owner_id', 'employee_id', 'address_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobAddress::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'price' => 'Price',
            'owner_id' => 'Owner ID',
            'employee_id' => 'Employee ID',
            'address_id' => 'Address ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Address]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(JobAddress::className(), ['id' => 'address_id']);
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
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[JobOffers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobOffers()
    {
        return $this->hasMany(JobOffer::className(), ['job_id' => 'id']);
    }
}
