<?php

namespace Telegram;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;


class BotTelegram
{
    const KEY = TELEGRAM_TOKEN;
    const USER = TELEGRAM_USER;
    const ID_USER = TELEGRAM_ID_USER;

    public static function send(string $message)
    {
        try {
            $message = preg_replace('/([_*\[\]()~`>#+\-=|{}.!])/', '\\\\$1', $message);
            $telegram = new Telegram(self::KEY, self::USER);
            $result = Request::send('sendMessage', [
                'chat_id' => self::ID_USER,
                'parse_mode' => 'MarkdownV2',
                'text' => $message,
            ]);
        } catch (TelegramException $e) {
            echo $e->getMessage();
        }
    }
}
