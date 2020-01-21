<?php

namespace Prerequisiter\Checker;

abstract class AbstractChecker implements CheckerInterface
{
    protected function ok($message = 'OK') : CheckerResponse
    {
        return new CheckerResponse(true, $message);
    }

    protected function fail($message = 'Fail') : CheckerResponse
    {
        return new CheckerResponse(false, $message);
    }
}
