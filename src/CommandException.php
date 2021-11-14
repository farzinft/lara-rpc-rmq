<?php


namespace Fthi\LaraRpcRmq;
use Interop\Queue\Context;
use Interop\Queue\Message;

class CommandException implements ICommandException
{

    private $context;

    private $message;

    public function __construct(Context $context, Message $message)
    {
        $this->context = $context;

        $this->message = $message;
    }

    public function onCommandException()
    {

    }


}
