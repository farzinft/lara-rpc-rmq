<?php


namespace Fthi\LaraRpcRmq;


use Enqueue\Consumption\Context\ProcessorException;
use Enqueue\Consumption\ProcessorExceptionExtensionInterface;

class ProcessException implements ProcessorExceptionExtensionInterface
{

    public function onProcessorException(ProcessorException $context): void
    {
        $context->getConsumer()->acknowledge($context->getMessage());
    }
}
