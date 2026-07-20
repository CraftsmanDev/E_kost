<?php

namespace App\Helpers;

class FlashMessageHelper
{
    public static function setFlashMessage($type, $message)
    {
        $session = session();
        $session->setFlashdata($type, $message);
        $session->setFlashdata($type . '_message', $message);
    }

    public static function setSuccess($message)
    {
        self::setFlashMessage('success', $message);
    }

    public static function setError($message)
    {
        self::setFlashMessage('error', $message);
    }

    public static function setWarning($message)
    {
        self::setFlashMessage('warning', $message);
    }

    public static function setInfo($message)
    {
        self::setFlashMessage('info', $message);
    }
}
