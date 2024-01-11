<?php
namespace app\util;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use app\util\Res;

class Email
{
    function __construct()
    {
    }

    function sendMail($email,$type,$price)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //服务器配置
            $mail->CharSet = "UTF-8";                     //设定邮件编码
            $mail->SMTPDebug = 0;                        // 调试模式输出
            $mail->isSMTP();                             // 使用SMTP
            $mail->Host = 'smtp.qq.com';                // SMTP服务器
            $mail->SMTPAuth = true;                      // 允许 SMTP 认证
            $mail->Username = '212681712@qq.com';                // SMTP 用户名  即邮箱的用户名
            $mail->Password = 'crlrryfvnhuybjaj';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
            $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
            $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

            $mail->setFrom('212681712@qq.com', 'Mailer');  //发件人
            $mail->addAddress($email);  // 收件人
            //$mail->addAddress('ellen@example.com');  // 可添加多个收件人
            // $mail->addReplyTo('xxxx@163.com', 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致

            //Content
            $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
            $mail->Subject = "{$type}价格提醒";
            $mail->Body = "{$type}价格达到{$price}";
            // $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';

            $mail->send();
            return '邮件发送成功';
        } catch (Exception $e) {
            echo '邮件发送失败: ', $mail->ErrorInfo;
        }
    }
}


