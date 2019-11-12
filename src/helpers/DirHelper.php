<?php

namespace drlenux\codePenLoader\helpers;

/**
 * Class DirHelper
 * @package src\helpers
 */
class DirHelper
{
    /**
     * @param string $path
     * @return bool
     */
    public static function isDir(string $path): bool
    {
        return is_dir($path);
    }

    /**
     * @param string $path
     * @param int $mode
     * @param bool $recursive
     * @param null $context
     * @return bool
     */
    public static function mkDir(string $path, $mode = 0777, $recursive = false, $context = null): bool
    {
        if (self::isDir($path)) {
            return true;
        }

        $pathArray = explode('/', $path);
        array_pop($pathArray);
        $tmpPath = implode('/', $pathArray);

        self::mkDir($tmpPath, $mode, $recursive, $context);
        return @mkdir($path, $mode, $recursive, $context);
    }
}
