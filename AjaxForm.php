<?php


class AjaxForm
{

    public $message_error = 'Error message send';

    public $message = '';

    private $email = 'vovasik2012@ya.ru';

    private $subject = 'subject';

    public $smtp = false;

    public $smtp_options = [
        'from_name' => 'vasia',
        'from_mail' => 'mysitemai@my-site-domine.ru',
        'smtp_username' => 'mail_user@yandex.ru',
        'smtp_password' => '***',
        'smtp_host' => 'ssl://smtp.yandex.ru',
        'smtp_port' => 25,
    ];


    public function __construct()
    {
        if ($this->smtp) {
            require_once "lib/SendMailSmtpClass.php";
        }

        $this->ajax();
    }

    public function message_text($reguest)
    {
        foreach ($reguest as $k => $v) {
            $this->message .= "{$k} : $v \r\n";
        }

    }

    public function ajax()
    {
        $request = $_REQUEST;

        $request = array_map('trim', $request);
        $this->message_text($request);

        if ($this->mail()) {
            echo json_encode([
                'success' => true,
                'data' => [
                    'message' => $this->message
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'data' => [
                    'message' => $this->message_error
                ]

            ]);

        }

    }

    public function mail()
    {
        if ($this->smtp) {
            return $this->mail_smtp();
        }

        return mail($this->email, $this->subject, $this->message);

    }

    public function mail_smtp()
    {
         $mailSMTP = new SendMailSmtpClass(
            $this->smtp_options['smtp_username'],
            $this->smtp_options['smtp_password'],
            $this->smtp_options['smtp_host'],
            $this->smtp_options['smtp_port']
        );

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: {$this->smtp_options['from_name']} <{$this->smtp_options['from_mail']}>\r\n";

        return $mailSMTP->send($this->email, $this->subject, $this->message, $headers);

    }


}

new AjaxForm();
