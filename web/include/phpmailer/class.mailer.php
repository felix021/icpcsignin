<?php
$relpath = dirname(__FILE__) . "/";
include_once($relpath . "class.smtp.php");
include_once($relpath . "class.phpmailer.php");

class mailer extends PHPMailer{
    public $Encoding    = 'base64';
    public $ContentType = 'text/html';
    public $CharSet     = 'UTF-8';
    public $From        = 'acm@whu.edu.cn';
    public $FromName    = 'whuacm';

    public function email($name, $address, $subject, $body){
        $this->IsSMTP();
        $this->AddReplyTo('acm@whu.edu.cn', 'whuacm');
        $this->Subject = $subject;
        $this->Body    = $body;
        $this->AddAddress($address, $name);
        return $this->Send();
    }
}

?>
