<?php

namespace TreeCrawler\FileSystem;

class Wrapper {
    /**
     * @param string $directory
     * @return array
     * @throws Exception
     */
    public function scanDir($directory) {
        if (!$this->isDir($directory)) throw new Exception(
            "$directory is not a directory."
        );

        return scandir($directory);
    }

    /**
     * @param string $path
     * @return boolean
     */
    public function isDir($path) {
        return is_dir($path);
    }

    /**
     * @param string $path
     * @return boolean
     */
    public function isFile($path) {
        return is_file($path);
    }

    /**
     * @param string $file
     * @return string
     * @throws Exception
     */
    public function md5($file) {
        if (!$this->isFile($file)) throw new Exception(
            "$file is not a directory."
        );

        return md5_file($file);
    }
}