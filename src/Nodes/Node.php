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
    private $attributes = [];

    /**
     * @var Node|null
     */
    private $parent = null;

    /**
     * @var array
     */
    private $children = [];

    /**
     * Node constructor.
     *
     * @param string $tag
     */
    public function __construct($tag, $attributes = [])
    {
        $this->setTag($tag);

        foreach ($attributes as $name => $value) {
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
        $this->tag = strtolower($tag);
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
        return (array_key_exists($name, $this->attributes));
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

        if ($this->hasAttribute($name) && $value === null) {
            $this->attributes = array_diff_key($this->attributes, [$name => '']);
            return;
        }

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
        if (!$this->hasAttribute('class')) {
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
        if (!$this->hasAttribute('class')) {
            $this->setAttribute('class', $name);
            return;
        }

        $classes = explode(' ', $this->getAttribute('class'));

        if (!in_array($name, $classes)) {
            $classes[] = $name;
            $this->setAttribute('class', implode(' ', $classes));
        }
    }

    /**
     * Removes the $name class from the current node.
     *
     * @param string $name
     */
    public function removeClass($name)
    {
        if (!$this->hasAttribute('class')) {
            return;
        }

        if ($this->hasClass($name)) {
            $classes = explode(' ', $this->getAttribute('class'));
            $classes = array_diff($classes, [$name]);

            if (count($classes) != 0) {
                $this->setAttribute('class', implode(' ', $classes));
            } else {
                $this->setAttribute('class', null);
            }
        }
    }

    /**
     * Returns true if the current node has a parent, false otherwise.
     *
     * @return bool
     */
    public function hasParent()
    {
        return ($this->parent !== null);
    }

    /**
     * Returns the parent node of the current one. Returns null if not present.
     *
     * @return Node|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets a new parent node for the current one.
     *
     * @param Node $node The desired new parent node.
     */
    public function setParent(Node $node)
    {
        $this->parent = $node;
    }

    /**
     * Returns the root element of the current one.
     *
     * @return Node
     */
    public function getRootElement()
    {
        if (!$this->hasParent()) {
            return $this;
        } else {
            return $this->parent->getRootElement();
        }
    }

    /**
     * Returns all the children for the current node.
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Adds the $node node as a child of the current one.
     *
     * @param Node $node The node that has to be added.
     * @param int|null $index The desired position for the new node. By default it is added at the end.
     */
    public function addChild(Node $node, $index = null)
    {
        $node->setParent($this);

        if ($index !== null && $index < count($this->children)) {
            $this->children = array_merge(
                array_slice($this->children, 0, $index),
                [$node],
                array_slice($this->children, $index)
            );

        } else {
            $this->children[] = $node;
        }
    }

    /**
     * Returns the index of $node if present. Returns null otherwise.
     *
     * @param Node $node
     * @return int|null
     */
    public function findChild(Node $node)
    {
        $childIndex = array_search($node, $this->children);
        return ($childIndex !== false) ? $childIndex : null;
    }

    /**
     * Deletes the current node and every link with other nodes in the tree.
     */
    public function delete()
    {
        /* @var Node $child */
        foreach ($this->children as $child) {
            $child->delete();
        }

        $this->children = [];

        $parent = $this->getParent();
        if ($parent !== null) {
            $this->parent = null;
            $parent->removeChild($this);
        }
    }

    protected function removeChild(Node $node)
    {
        $index = $this->findChild($node);
        unset($this->children[$index]);
    }
}
