<?php


namespace app\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

class Error extends ActiveRecord
{
    public static function tableName()
    {
        return 'errors';
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT=>['error_date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE=>['error_date'],
                ],
                'value' => new Expression('NOW()'),

            ],
        ];
    }
}