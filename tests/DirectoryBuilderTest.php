<?php
namespace TreeCrawler;

class DirectoryBuilderTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var FileSystem\Wrapper
     */
    private $fileSystem;

    public function setUp() {
        $this->fileSystem = $this->getMockBuilder('\TreeCrawler\FileSystem\Wrapper')
            ->setMethods(array('scanDir'))
            ->getMock();
        $this->fileSystem->expects($this->any())
            ->method('scanDir')
            ->will($this->returnValueMap(array(
                array('foo', array('bar', 'baz'))
            )));
    }

    public function testDirectoryBuilderCanBuildDirectory() {
        $builder = new DirectoryBuilder($this->fileSystem);
        $directory = $builder->build('foo');
        $fileNames = array_map(function($treeNode) {
            return $treeNode->getName();
        }, $directory->getCHildren());

        $this->assertEquals(array('bar', 'baz'), $fileNames);
    }
}