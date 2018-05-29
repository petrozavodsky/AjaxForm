<?php


class AjaxForm
{

    public $message_error = 'Error message send';

    public $message = '';

    private $email = 'vovasik2012@ya.ru';

    private $subject = 'subject';


    public function __construct()
    {
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
        return mail($this->email, $this->subject, $this->message);
    }
}

new AjaxForm();
