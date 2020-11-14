<?php

namespace common\models\job;

use Yii;

/**
 * This is the model class for table "job_address".
 *
 * @property int $id
 * @property string $country
 * @property string $city
 * @property string $region
 * @property string $street_name
 * @property string $building_number_or_name
 * @property string $floor_number
 * @property string $apartment_number
 * @property string $description
 *
 * @property Job[] $jobs
 */
class JobAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country', 'city', 'region', 'street_name', 'building_number_or_name', 'floor_number', 'apartment_number', 'description'], 'required'],
            [['country', 'city', 'region', 'street_name', 'building_number_or_name', 'floor_number', 'apartment_number', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Country',
            'city' => 'City',
            'region' => 'Region',
            'street_name' => 'Street Name',
            'building_number_or_name' => 'Building Number Or Name',
            'floor_number' => 'Floor Number',
            'apartment_number' => 'Apartment Number',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Jobs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::className(), ['address_id' => 'id']);
    }
}
