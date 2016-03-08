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

    public function testHasAttribute()
    {
        $node = new Node('div', [
           'class' => 'form-control'
        ]);

        $this->assertTrue($node->hasAttribute('class'));
        $this->assertTrue($node->hasAttribute('CLASS'));
        $this->assertFalse($node->hasAttribute('foo'));
    }

    public function testGetAttribute()
    {
        $node = new Node('div', [
            'class' => 'form-control',
            'BAR'   => 'test',
            'id'    => 'name'
        ]);

        $this->assertEquals('form-control', $node->getAttribute('class'));
        $this->assertEquals('name', $node->getAttribute('id'));
        $this->assertEquals('test', $node->getAttribute('bar'));
        $this->assertNull($node->getAttribute('foo'));
    }

    public function testSetAttribute()
    {
        $node = new Node('div', [
            'class' => 'form-control',
            'id'    => 'name'
        ]);

        $node->setAttribute('class', 'row');
        $node->setAttribute('FOO', 'bar');
        $this->assertEquals('row', $node->getAttribute('class'));
        $this->assertEquals('bar', $node->getAttribute('foo'));
    }

    public function testHasClass()
    {
        $node = new Node('div', [
            'class' => 'class1 class2'
        ]);

        $this->assertTrue($node->hasClass('class1'));
        $this->assertTrue($node->hasClass('class2'));
        $this->assertFalse($node->hasClass('class3'));

        $node = new Node('div');
        $this->assertFalse($node->hasClass('class1'));
    }

    public function testAddClass()
    {
        $node = new Node('div', [
            'class' => 'class1 class2'
        ]);

        $this->assertFalse($node->hasClass('class3'));
        $node->addClass('class3');
        $this->assertTrue($node->hasClass('class3'));

        $node = new Node('div');

        $node->addClass('class1');
        $this->assertTrue($node->hasClass('class1'));
    }

    public function testRemoveClass()
    {
        $node = new Node('div', [
            'class' => 'class1 class2'
        ]);

        $node->removeClass('class1');
        $this->assertEquals('class2', $node->getAttribute('class'));

        $node->removeClass('class2');
        $this->assertFalse($node->hasAttribute('class'));
    }
}
