<?php

namespace Prerequisiter\Checker;

class PhpFunctionChecker extends AbstractChecker
{
    public function check(string $function): CheckerResponse
    {
        if (\function_exists($function)) {
            return $this->ok();
        }
        return $this->fail();
    }
}
