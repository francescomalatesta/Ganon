<?php

namespace francescomalatesta\ganon\Nodes;


class Node
{
    /**
     * The tag of this node.
     *
     * @var string
     */
    private $tag;

    /**
     * Node constructor.
     *
     * @param string $tag
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }

    /**
     * Returns the tag name of this node.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Sets the tag name of this node.
     *
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }
}