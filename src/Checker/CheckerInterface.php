<?php

namespace Prerequisiter\Checker;

interface CheckerInterface
{
    public function check(string $object) : CheckerResponse;
}
