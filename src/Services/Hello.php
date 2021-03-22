<?php


namespace App\Services;


class Hello
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message['message'];
    }

    public function say(){
        return $this->message;
    }
}