<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Customer;
use app\models\Purchase;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\base\ErrorException;
use Yii;

class MessagesController extends Controller
{

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public $SMS;
    public $EMAIL;

    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['SMS', 'EMAIL']);
    }

    public function optionAliases()
    {
        return array_merge(parent::optionAliases(), [
            's' => 'SMS',
            'e' => 'EMAIL'
        ]);
    }

    public function actionNotify()
    {

         $purchase = new Purchase();
         $orders = $purchase::find()->asArray()->all();

         foreach ($orders as $order){

                 $e ='';
                 $customer = Customer::find()->where(['id'=>$order['customer_id']])->asArray()->one();
                 /* Отправка смс сообщения*/
                 if ($customer['mobile_phone'] && $this->SMS && $order['sms_sent']=='N')
                 {
                     try
                      {
                          $purchase->send_sms($customer['mobile_phone'],'TEST');

                      }
                      catch (\Exception  $e)
                      {
                          $err="При отправке смс сообщения поризашла следующая ошибка:\n". $e->getMessage();
                          $purchase->error_save($order['buy_id'],$order['customer_id'],substr($err,0,255));
                          echo  $err.PHP_EOL;
                      }

                     if(empty($e))
                     {
                         $purchase->check_sent($order['buy_id'],$order['customer_id'],'SMS');
                         echo 'СМС сообщение на номер '.$customer['mobile_phone']. ' отправлено'.PHP_EOL;
                     }

                 }
                 else
                 {
                     $err= 'У клиента '.$order['customer_id']. ' не указан номер телефона или не выбрана услуга или уже было отправлено';
                     $purchase->error_save($order['buy_id'],$order['customer_id'],substr($err,0,255));
                     echo $err.PHP_EOL;;
                 }
                 /* Отправка пиьсма на почту*/

                 if ($customer['email'] && $this->EMAIL && $order['email_sent']=='N')
                      {
                          try
                          {
                                $purchase->send_email('purchase',$customer['email'],['order' =>$order]);
                          }
                          catch (\Swift_TransportException  $e)
                           {
                               $err="При отправке почты поризашла следующая ошибка:\n". $e->getMessage();
                               $purchase->error_save($order['buy_id'],$order['customer_id'],substr($err,0,255));
                               echo  $err.PHP_EOL;
                           }
                           if(empty($e))
                           {
                               $purchase->check_sent($order['buy_id'],$order['customer_id'],'EMAIL');
                               echo 'Уведомление на электронную почту '.$customer['email']. ' отправлено'.PHP_EOL;
                           }

                      }
                  else
                      {
                          $err='У клиента '.$order['customer_id']. ' не указан email  или не выбрана услуга или уже было отправлено';
                          $purchase->error_save($order['buy_id'],$order['customer_id'],substr($err,0,255));
                          echo $err .PHP_EOL;
                      }

         }
        return ExitCode::OK;

    }
}