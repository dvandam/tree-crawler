<?php

namespace TreeCrawler;

class TreeBuilder {
    /**
     * @var FileSystem\Wrapper
     */
    private $fileSystem;

    /**
     * @param FileSystem\Wrapper $filesystem
     */
    public function __construct(FileSystem\Wrapper $fileSystem) {
        $this->fileSystem = $fileSystem;
    }

    /**
     * @param string $directory
     * @return \TreeCrawler\Directory
     */
    public function build($directory) {
        $nodes = array();
        foreach ($this->fileSystem->scanDir($directory) as $fileName) {
            $path = $directory . DIRECTORY_SEPARATOR . $fileName;
            if ($this->fileSystem->isFile($path)) {
                $nodes[] = new File($path);
            }
            if ($this->fileSystem->isDir($path)) {
                $nodes[] = $this->build($path);
            }
        }
        return new Directory($directory, $nodes);
    }
}