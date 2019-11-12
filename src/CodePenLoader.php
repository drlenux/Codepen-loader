<?php

namespace drlenux\codePenLoader;

use drlenux\codePenLoader\actions\Load;
use Symfony\Component\Console\Application;

/**
 * Class CodePenLoader
 * @package drlenux\codePenLoader
 */
class CodePenLoader
{
    /**
     * @var string
     */
    private static $dirPath;

    /**
     * @param $dirPath
     * @throws \Exception
     */
    public static function run(string $dirPath): void
    {
        self::$dirPath = $dirPath;
        $app = new Application();

        $app->add(new Load());

        $app->run();
    }

    /**
     * @return string
     */
    public static function getDirPath(): string
    {
        return self::$dirPath;
    }
}
