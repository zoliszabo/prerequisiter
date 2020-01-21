<?php

namespace Prerequisiter\Checker;

class ExecutablesChecker extends AbstractChecker
{
    public function check(string $executable): CheckerResponse
    {
        $last_output_line = $this->which($executable);
        if ($last_output_line !== NULL) {
            return $this->ok('OK [' . $last_output_line . ']');
        }
        return $this->fail();
    }

    private function which(string $executable) : ?string
    {
        $output = [];
        $return_var = null;
        // Avoid outputting of stderr to stdout: https://stackoverflow.com/a/57071648/3219919
        $last_line = exec("which $executable 2>/dev/null", $output, $return_var);
        if ($return_var === 0) {
            return $last_line;
        }
        return null;
    }
}
