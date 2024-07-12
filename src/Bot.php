<?php

namespace App;

use VK\Client\VKApiClient;
use App\utils\Config;
use App\utils\MainLogger;

class Bot
{
    private $vk;
    private $groupId;
    private $accessToken;
    private $config;

    public function __construct(Config $config)
    {
        $this->vk = new VKApiClient();
        $this->groupId = $config->get("vk.group_id");
        $this->accessToken = $config->get("vk.token");
        $this->config = $config;
    }

    public function handleRequest($data)
    {
        if (isset($data["type"]) && $data["type"] === "message_new") {
            
            $message = $data["object"]["message"];
            var_dump($message);
            $text = $message["text"];
            $user_id = $message["from_id"];
            
            MainLogger::log("[message_new] User: {$user_id} -> {$text}", "info");
            
            if (stripos($text, "/test") === 0) {
                $this->sendMessage($user_id, "Test");
            }
        }
    }

    private function sendMessage($user_id, $text)
    {
        $this->vk->messages()->send($this->accessToken, [
            "peer_id" => $user_id,
            "message" => $text,
            "random_id" => rand()
        ]);
        MainLogger::log("[message_new] Bot -> {$text}", "warning");
    }
}