<?php


namespace app\models;
use yii\db\ActiveRecord;
use Yii;
use alexeevdv\sms\ru\Sms;
use app\models\Error;

class Purchase extends ActiveRecord
{
    public static function tableName()
    {
        return 'purchases';
    }

    public function send_email($template,$to_email,$massage)
    {
        return Yii::$app->mailer->compose($template,$massage)
             ->setFrom([\Yii::$app->params['adminEmail'] => \Yii::$app->params['adminName']])
             ->setTo($to_email)
             ->setSubject('Ваш заказ')
             ->send();
    }
    public function send_sms($to,$text)
    {
        return \Yii::$app->sms->send(new Sms([
            "to" => $to,
            "text" => $text,
        ]));
    }

    public function check_sent($buy_id,$cust_id,$chanel)
    {
        if ($chanel='SMS')
        {
            $upd = self::find()->where(['buy_id'=>$buy_id, 'customer_id'=>$cust_id])->one();
            $upd->sms_sent ='Y';
            $upd->save();
        }
        else
        {
            $upd = self::find()->where(['buy_id'=>$buy_id, 'customer_id'=>$cust_id])->one();
            $upd->email_sent ='Y';
            $upd->save();
        }

        return true;
    }
    public function error_save($buy_id,$cust_id,$msg)
    {
        $error = new Error();
        $error->purchase_id=$buy_id;
        $error->customer_id=$cust_id;
        $error->error_desc =$msg;
        $error->save();
        return true;
    }
}