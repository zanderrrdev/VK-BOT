<?php

namespace App;

use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Exception;
use App\utils\MainLogger;

class Swoole
{
    private $bot;
    private $code;

    public function __construct($bot, $code)
    {
        $this->bot = $bot;
        $this->code = $code;
    }

    public function start()
    {
        $start = microtime(true);
        
        try {
            $server = new Server("0.0.0.0", 80);
        } catch (Exception $e) {
            MainLogger::log("Failed to start server: " . $e->getMessage(), 'error');
            return;
        }

        $server->on("start", function () use ($start) {
            $end = microtime(true);
            $load = $end - $start;
            MainLogger::log("Server started at 127.0.0.1", 'info');
            MainLogger::log('Loaded (' . number_format($load, 3) . ' sec)', 'info');
        });

        $server->on("request", function (Request $request, Response $response) {
            if ($request->server['request_method'] === 'POST') {
                $data = json_decode($request->rawContent(), true);

                if (isset($data['type'])) {
                    if ($data['type'] === 'confirmation') {
                        $response->end($this->code);
                    } elseif ($data['type'] === 'message_new') {
                        $this->bot->handleRequest($data);
                        $response->end('OK');
                    } else {
                        $response->end($this->code);
                    }
                } else {
                    $response->end($this->code);
                }
            } else {
                $response->end($this->code);
            }
        });

        $server->start();
    }
}