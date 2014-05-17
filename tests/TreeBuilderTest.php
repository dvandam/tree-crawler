<?php
namespace TreeCrawler;

class TreeBuilderTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var FileSystem\Wrapper
     */
    private $fileSystem;

    public function setUp() {
        $this->fileSystem = $this->getMockBuilder('\TreeCrawler\FileSystem\Wrapper')
            ->setMethods(array('scanDir', 'isFile', 'isDir'))
            ->getMock();
        $this->fileSystem->expects($this->any())
            ->method('scanDir')
            ->will($this->returnValueMap(array(
                array('foo', array('bar', 'baz')),
                array('foobar', array('foo')),
                array('foobar/foo', array('bar', 'baz'))
            )));
        $this->fileSystem->expects($this->any())
            ->method('isDir')
            ->will($this->returnValueMap(array(
                array('foo', true),
                array('foobar', true),
                array('foobar/foo', true),
                array('foo/bar', false),
                array('foo/baz', false)
            )));
        $this->fileSystem->expects($this->any())
            ->method('isFile')
            ->will($this->returnValueMap(array(
                array('foo', false),
                array('foobar', false),
                array('foobar/foo', false),
                array('foo/bar', true),
                array('foo/baz', true)
            )));
    }

    public function testTreeBuilderCanBuildDirectoryWithFiles() {
        $builder = new TreeBuilder($this->fileSystem);
        $tree = $builder->build('foo');
        foreach ($tree->getCHildren() as $treeNode) {
            $this->assertInstanceOf('TreeCrawler\File', $treeNode);
        }
    }

    public function testTreeBuilderCanBuildDirectoryWithSubdirectory() {
        $builder = new TreeBuilder($this->fileSystem);
        $tree = $builder->build('foobar');
        foreach ($tree->getCHildren() as $treeNode) {
            $this->assertInstanceOf('TreeCrawler\Directory', $treeNode);
        }
    }
}