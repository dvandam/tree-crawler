<?php
namespace TreeCrawler;

class TreeBuilderTest extends \PHPUnit_Framework_TestCase {
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

    public function testTreeBuilderCanBuildDirectoryWithFiles() {
        $builder = new TreeBuilder($this->fileSystem);
        $tree = $builder->build('foo');
        $fileNames = array_map(function($treeNode) {
            return $treeNode->getName();
        }, $tree->getCHildren());

        $this->assertEquals(array('bar', 'baz'), $fileNames);
    }
}