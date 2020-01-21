<?php

namespace Prerequisiter\Checker;

class CheckerResponse
{
    public $result = NULL;
    public $message = NULL;

    public function __construct(bool $result, string $message)
    {
        $this->result = $result;
        $this->message = $message;
    }
}
