<?php

namespace TreeCrawler;

class Directory {
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $children;

    /**
     * @param string $name
     * @param array $nodes
     */
    public function __construct($name, array $children) {
        $this->name = $name;
        $this->children = $children;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getChildren() {
        return $this->children;
    }
}