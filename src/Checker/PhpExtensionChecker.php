<?php

namespace Prerequisiter\Checker;

class PhpExtensionChecker extends AbstractChecker
{
    public function check(string $extension): CheckerResponse
    {
        if (\extension_loaded($extension)) {
            return $this->ok();
        }
        return $this->fail();
    }
}
