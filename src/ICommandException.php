<?php


namespace Fthi\LaraRpcRmq;


interface ICommandException
{
    public function onCommandException();
}
