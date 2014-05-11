<?php
namespace TreeCrawler\FileSystem;

class WrapperTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var Wrapper
     */
    private $fileSystem;

    public function setUp() {
        $this->fileSystem = new Wrapper();
    }

    /**
     * @return array
     */
    public function directoryPaths() {
        return array(
            array(__DIR__, true, 'should be a firectory'),
            array(__FILE__, false, 'should not be a directory')
        );
    }

    /**
     * @dataProvider directorypaths
     * @param string $path
     * @param boolean $isDir
     * @param string $message
     */
    public function testIsDirIndicatesPathIsDirectory($path, $isDir, $message) {
        $this->assertEquals($isDir, $this->fileSystem->isDir($path), $message);
    }

    /**
     * @return array
     */
    public function filepaths() {
        return array(
            array(__FILE__, true, 'should be a file'),
            array(__DIR__, false, 'should not be a file')
        );
    }

    /**
     * @dataProvider filepaths
     * @param string $path
     * @param boolean $isFile
     * @param string $message
     */
    public function testIsFileIndicatesPathIsFile($path, $isFile, $message) {
        $this->assertEquals($isFile, $this->fileSystem->isFile($path), $message);
    }

    /**
     * @expectedException \TreeCrawler\FileSystem\Exception
     */
    public function testScanDirThrowsExceptionWhenPathIsNotADirectory() {
        $this->fileSystem->scanDir(__FILE__);
    }

    /**
     * @expectedException \TreeCrawler\FileSystem\Exception
     */
    public function testMd5ThrowsExceptionWhenPathIsNotAFile() {
        $this->fileSystem->md5(__DIR__);
    }
}