<?php

/**
 * @example +my-mixin()
 */

namespace Phug\Lexer\Scanner;

use Phug\Lexer\ScannerInterface;
use Phug\Lexer\State;
use Phug\Lexer\Token\MixinCallToken;

class MixinCallScanner implements ScannerInterface
{
    public function scan(State $state)
    {
        $keywordName = $state->getOption('mixin_call_keyword');

        if (is_array($keywordName)) {
            $keywordName = '(?:'.implode('|', $keywordName).')';
        }

        foreach ($state->scanToken(
            MixinCallToken::class,
            $keywordName.'[ \t]*(?<name>('.
                '[a-zA-Z_][a-zA-Z0-9\-_]*|'.
                '#\\{(?:(?>"(?:\\\\[\\S\\s]|[^"\\\\])*"|\'(?:\\\\[\\S\\s]|[^\'\\\\])*\'|[^{}\'"]++|(?-1))*+)\\}'.
            '))'
        ) as $token) {
            yield $token;

            foreach ($state->scan(ClassScanner::class) as $subToken) {
                yield $subToken;
            }

            foreach ($state->scan(SubScanner::class) as $subToken) {
                yield $subToken;
            }
        }
    }
}
