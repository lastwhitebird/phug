<?php

namespace Phug\Test;

use PHPUnit\Framework\TestCase;
use Phug\Test\Extension\VerbatimExtension;

abstract class AbstractPhugTest extends TestCase
{
    /**
     * @var VerbatimExtension
     */
    protected $verbatim;

    protected static function emptyDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }
        foreach (scandir($dir) as $file) {
            if ($file !== '.' && $file !== '..') {
                $path = $dir.'/'.$file;
                if (is_dir($path)) {
                    static::emptyDirectory($path);
                } else {
                    unlink($path);
                }
            }
        }
    }

    public function setUp()
    {
        $this->verbatim = new VerbatimExtension();
    }
}
