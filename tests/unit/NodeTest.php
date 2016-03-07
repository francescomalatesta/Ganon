<?php

use francescomalatesta\ganon\Nodes\Node;

class NodeTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $node = new Node('div');
        $this->assertInstanceOf(Node::class, $node);
    }

    public function testGetTag()
    {
        $node = new Node('div');
        $this->assertEquals('div', $node->getTag());
    }

    public function testSetTag()
    {
        $node = new Node('div');
        $node->setTag('p');

        $this->assertEquals('p', $node->getTag());
    }

    public function testGetAttribute()
    {
        $node = new Node('div', [
            'class' => 'form-control',
            'id'    => 'name'
        ]);

        $this->assertEquals('form-control', $node->getAttribute('class'));
        $this->assertEquals('name', $node->getAttribute('id'));
        $this->assertNull($node->getAttribute('foo'));
    }

    public function testSetAttribute()
    {
        $node = new Node('div', [
            'class' => 'form-control',
            'id'    => 'name'
        ]);

        $node->setAttribute('class', 'row');
        $this->assertEquals('row', $node->getAttribute('class'));
    }
}
