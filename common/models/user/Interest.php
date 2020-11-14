<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "interest".
 *
 * @property int $id
 * @property string $name
 *
 * @property UserInterestIn[] $userInterestIns
 */
class Interest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[UserInterestIns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserInterestIns()
    {
        return $this->hasMany(UserInterestIn::className(), ['interest_id' => 'id']);
    }
}
