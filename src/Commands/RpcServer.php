<?php

namespace Fthi\LaraRpcRmq\Commands;

use Enqueue\Consumption\Result;
use Fthi\LaraRpcRmq\BoundedQueue;
use Fthi\LaraRpcRmq\CheckFailsExtension;
use Illuminate\Console\Command;
use Interop\Queue\Context;
use Interop\Queue\Message;

class RpcServer extends Command
{

    protected $signature = 'rpc:server';

    protected $description;

    protected $patterns;

    protected $rmqConfig;

    protected $context;

    protected $client;

    protected $result;


    public function __construct()
    {
        parent::__construct();

        $this->rmqConfig = config('rpc-client');

        $this->patterns = $this->rmqConfig['patterns'];

        $this->client = app('rmqClient');

        $this->context = $this->client->getDriver()->getContext();

    }


    public function handle()
    {
        try {

            $this->patternConsume();

        } catch (\Exception $e) {

            $this->error('Consumer Error: ' . $e->getMessage());
            exit(1);
        }
    }


    private function patternConsume()
    {

        foreach ($this->patterns as $pattern => $mapController) {
            $this->client->bindCommand($pattern, function (Message $message, Context $context) use ($mapController) {

                try {

                    unset($this->result);

                    $this->info('Process message: ' . $message->getBody());

                    $msgBody = json_decode($message->getBody(), true);

                    $controller = new $mapController['controller']();

                    $this->result = $controller->{$mapController['method']}($msgBody);

                } catch (\Exception $e) {

                    $this->result = [
                       'exception' => $e->getMessage()
                    ];

                    $this->error('Error on process: ' . $e->getMessage());
                }

                unset($controller);

                return Result::reply($this->context->createMessage(json_encode($this->result, JSON_UNESCAPED_UNICODE)));

            }, $this->rmqConfig['client']['client']['router_queue']);
        }

        $this->info('Rpc Started');

        $this->client->consume();
    }
}
