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

        foreach($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
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
        $name = strtolower($name);
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
        $name = strtolower($name);
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
        $name = strtolower($name);
        $this->attributes[$name] = $value;
    }

    /**
     * Checks if the current node has the $name class.
     *
     * @param string $name
     * @return bool
     */
    public function hasClass($name)
    {
        if(!$this->hasAttribute('class')) {
            return false;
        }

        $classes = explode(' ', $this->getAttribute('class'));

        return in_array($name, $classes);
    }

    /**
     * Adds the $name class to the current node.
     *
     * @param string $name
     */
    public function addClass($name)
    {
        if(!$this->hasAttribute('class')) {
            $this->setAttribute('class', $name);
            return;
        }

        $classes = explode(' ', $this->getAttribute('class'));

        if(!in_array($name, $classes)) {
            $classes[] = $name;
            $this->setAttribute('class', implode(' ', $classes));
        }
    }

    public function removeClass($name)
    {
        if(!$this->hasAttribute('class')) {
            return;
        }

        if($this->hasClass($name)) {
            $classes = explode(' ', $this->getAttribute('class'));
            $classes = array_diff($classes, [$name]);

            if(count($classes) != 0){
                $this->setAttribute('class', implode(' ', $classes));
            } else {
                // so ugly
                $this->attributes = array_diff_key($this->attributes, ['class' => '']);
            }
        }
    }
}
