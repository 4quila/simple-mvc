<?php

namespace app\core;

class Session
{
    const FLASH_MESSAGES = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flash_messages = $_SESSION[self::FLASH_MESSAGES] ?? [];
        foreach ($flash_messages as &$message)
        {
            $message['remove'] = true;
        }
        $_SESSION[self::FLASH_MESSAGES] = $flash_messages;
    }

    public function getFlashMessage(string $key)
    {
        return $_SESSION[self::FLASH_MESSAGES][$key]['message'] ?? false;
    }

    public function setFlashMessage(string $key, string $message)
    {
        $_SESSION[self::FLASH_MESSAGES][$key] = [
            'message' => $message,
            'remove' => false
        ];
    }

    public function __destruct()
    {
        $flash_messages = $_SESSION[self::FLASH_MESSAGES] ?? [];
        foreach ($flash_messages as $key => $message)
        {
            if ($message['remove'])
            {
                unset($flash_messages[$key]);
            }
        }
        $_SESSION[self::FLASH_MESSAGES] = $flash_messages;
    }
}