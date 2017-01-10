<?php
/**
 * Created by PhpStorm.
 * User: regepanda
 * Date: 2016/12/26
 * Time: 17:15
 */

namespace App\Libraries\Tools;

use Illuminate\Support\Facades\Mail;

class Email
{

    const WarningAddress = "1084259251@qq.com";
    const WarningTitle = "邮件发送上限通知";
    const WarningContent = "您今日所有的邮箱已经到达发送上限，为了系统的安全，已自动关闭邮件发送功能";
    /**
     * 自动出票或者人工出票成功后发送邮件给卖家以及抄送给相应客服
     * @param $businessAdr 需要抄送则为抄送地址，不需要则为0
     * @param      $userAdr  接收方
     * @param null $recvTitle  邮件主题，需要调用方自己规范传入
     * @param null $recvContent  邮件内容
     * @param null $template   发送附件的模板
     * @return bool     //返回结果  成功：返回true  失败：返回数组，里面是发送信息
     *
     */
    public static function sendEmailSuccess($businessAdr, $userAdr, $recvTitle = null, $recvContent = NULL, $template = [])
    {
        $data["businessAdr"] = $businessAdr;
        $data["userAdr"] = $userAdr;
        $data["recvTitle"] = $recvTitle;
        $data["recvContent"] = $recvContent;
        $data["template"] = $template;

        $check_result = Email::checkEmailCount();
        if($check_result == 1)
        {
            //邮件数量到达上限，不允许发送
            $data['detail'] = "邮件已到达上限，不能发送";
            return $data;
        }

        $flag = Mail::send('mail.sendMail', ["recvTitle"=> $recvTitle,"recvContent"=>$recvContent],
            function($message)use($businessAdr, $userAdr, $recvTitle, $recvContent, $template)
        {
            //是否需要发送附件
            if(!empty($template))
            {
                foreach($template as $path)
                {
                    $message->attach($path);
                }
            }

            //发送给买家
            $message->to($userAdr, $recvTitle);

            //是否需要抄送
            if($businessAdr != 0)
            {
                $message->cc($businessAdr, $recvTitle);
            }
            $message->subject($recvContent);
        });

        if($flag == null)
        {
            //跟新邮件的发送数量
            Email::updateSendCount($check_result['from']['address']);
            return true;
        }
        else
        {
            return $data;
        }
    }

    /**
     * 用于邮件报错用，意思就是说在邮件给用户发送电子票之前由于条件等种种原因不能发送自动出票邮件，
     * 需要邮件告知相应客服不能发送电子票的详细情况
     * @param $businessAdr  //客服邮箱
     * @param null $recvTitle
     * @param null $recvContent
     * @return bool     //返回结果  成功：返回true  失败：返回数组，里面是发送信息
     */
    public static function sendEmailError($businessAdr, $recvTitle = null, $recvContent = null)
    {

        $data["businessAdr"] = $businessAdr;
        $data["recvTitle"] = $recvTitle;
        $data["recvContent"] = $recvContent;

        $check_result = Email::checkEmailCount();
        if($check_result == 1)
        {
            //邮件数量到达上限，不允许发送
            $data['detail'] = "邮件已到达上限，不能发送";
            return $data;
        }

        $flag = Mail::send('mail.sendMail', ["recvTitle"=> $recvTitle,"recvContent"=>$recvContent],
            function($message)use($businessAdr, $recvTitle, $recvContent)
        {
            //发送给相应客服
            $message->to($businessAdr, $recvTitle);
            $message->subject($recvContent);
        });
        if($flag)
        {
            //跟新邮件的发送数量
            Email::updateSendCount($check_result['from']['address']);
            return true;
        }
        else
        {
            return $data;
        }
    }

    /**
     * 因为每个邮件配置每天只能发送固定的邮件数量，所以这里需要依次检查每个邮件的发送上线，
     * 如果到了每天的发送上线，就换一个邮件继续工作
     *
     * @return int|mixed
     * 如果到达上限返回1
     *
     * 如果没有到达上限返回邮件配置 array
     * [
     *      "driver" => "smtp"
     *      "host" => "smtp.mxhichina.com"
     *       "port" => 465
     *       "from" => [
     *          "address" => "jtcool@jtcool.com"
     *          "name" => "途风网客服部"
     *       ]
     *       "encryption" => "ssl"
     *       "username" => "jtcool@jtcool.com"
     *       "password" => "RagPanda1234"
     *       "sendmail" => "/usr/sbin/sendmail -bs"
     *       "pretend" => false
     * ]
     */
    public static function checkEmailCount()
    {
        $email_configs = app("db")->connection("alitrip")->table("tmall_email_config")
            ->get();

        if(!empty($email_configs))
        {
            foreach($email_configs as $key => $email_config)
            {
                //最后一个邮箱都已经到达上限
                if($key+1 == count($email_configs) && $email_config->send_count == $email_config->max_send)
                {
                    return 1;
                }
                //已经是最后一个邮箱了并且还差一个到达上限,需要邮件告诉客服不能再发送邮件了
                if($key+1 == count($email_configs) && $email_config->send_count >= $email_config->max_send-1)
                {
                    //重写配置
                    config([
                        'mail.host' => $email_config->smtp_host_address,
                        'mail.port' => $email_config->smtp_host_port,
                        'mail.from' => ['address' => $email_config->email_from_address, 'name' => $email_config->email_from_name],
                        'mail.encryption' => $email_config->email_encryption_protocol,
                        'mail.username' => $email_config->smtp_server_username,
                        'mail.password' => $email_config->smtp_server_password
                    ]);

                    $warningTitle = self::WarningTitle;
                    $warningContent = self::WarningContent;
                    $warningAddress = self::WarningAddress;
                    Mail::send('mail.sendMail', ["recvTitle"=> $warningTitle,"recvContent"=>$warningContent],
                        function($message)use($warningAddress, $warningTitle, $warningContent)
                        {
                            $message->to($warningAddress, $warningTitle);
                            $message->subject($warningContent);
                        });
                    Email::updateSendCount($email_config->email_from_address);
                    return 1;
                }
                else
                {
                    if($email_config->send_count < $email_config->max_send)
                    {
                        //重写配置
                        config([
                            'mail.host' => $email_config->smtp_host_address,
                            'mail.port' => $email_config->smtp_host_port,
                            'mail.from' => ['address' => $email_config->email_from_address, 'name' => $email_config->email_from_name],
                            'mail.encryption' => $email_config->email_encryption_protocol,
                            'mail.username' => $email_config->smtp_server_username,
                            'mail.password' => $email_config->smtp_server_password
                        ]);
                        return config('mail');
                    }
                    else
                    {
                        continue;
                    }
                }
            }
        }
    }

    /**
     * 发送一次邮件成功后需要把该邮件的发送上线增加1
     * @param $email_from_address
     */
    public static function updateSendCount($email_from_address)
    {
         app("db")->connection("alitrip")->table("tmall_email_config")
            ->where("email_from_address", $email_from_address)
            ->increment("send_count");
    }
}