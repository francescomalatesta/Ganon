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
     * The attributes of this node.
     *
     * @var array
     */
    private $attributes;

    /**
     * Node constructor.
     *
     * @param string $tag
     */
    public function __construct($tag, $attributes = [])
    {
        $this->tag = $tag;
        $this->attributes = $attributes;
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

    /**
     * Checks if the attribute named $name exists.
     *
     * @param string $name The desired attribute name
     *
     * @return bool
     */
    public function hasAttribute($name)
    {
        return (isset($this->attributes[$name]));
    }

    /**
     * Returns the value of the specified attribute.
     *
     * @param string $name The attribute's name.
     *
     * @return string
     */
    public function getAttribute($name)
    {
        return ($this->hasAttribute($name)) ? $this->attributes[$name] : null;
    }

    /**
     * Sets $value as the value for the $name attribute.
     *
     * @param string $name
     * @param string $value
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}
