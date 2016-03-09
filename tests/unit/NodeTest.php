<?php

namespace francescomalatesta\ganon\tests;

use francescomalatesta\ganon\Nodes\Node;

class NodeTest extends \PHPUnit_Framework_TestCase
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

        $node = new Node('DIV');
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
        $node->setAttribute('id', null);

        $this->assertEquals('row', $node->getAttribute('class'));
        $this->assertEquals('bar', $node->getAttribute('foo'));
        $this->assertFalse($node->hasAttribute('id'));
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

    public function testHasParent()
    {
        $node = new Node('div');
        $child = new Node('p');

        $child->setParent($node);

        $this->assertTrue($child->hasParent());
        $this->assertFalse($node->hasParent());
    }

    public function testGetParent()
    {
        $node = new Node('div');
        $child = new Node('p');

        $child->setParent($node);

        $this->assertSame($node, $child->getParent());
        $this->assertNull($node->getParent());
    }

    public function testSetParent()
    {
        $node = new Node('div');
        $child = new Node('p');

        $child->setParent($node);

        $this->assertTrue($child->hasParent());
        $this->assertSame($node, $child->getParent());
    }

    public function testGetRootElement()
    {
        $node = new Node('div');
        $child = new Node('ul');
        $child2 = new Node('li');
        $child3 = new Node('a');

        $child3->setParent($child2);
        $child2->setParent($child);
        $child->setParent($node);

        $this->assertSame($node, $child3->getRootElement());
        $this->assertSame($node, $child2->getRootElement());
        $this->assertSame($node, $child->getRootElement());
        $this->assertSame($node, $node->getRootElement());
    }

    public function testGetChildren()
    {
        $node = new Node('div');

        $childNode = new Node('p');
        $childNode2 = new Node('ul');

        $this->assertEmpty($node->getChildren());

        $node->addChild($childNode);
        $node->addChild($childNode2);

        $this->assertCount(2, $node->getChildren());
        $this->assertSame($childNode, $node->getChildren()[0]);
        $this->assertSame($childNode2, $node->getChildren()[1]);
    }

    public function testAddChild()
    {
        $node = new Node('div');

        $childNode = new Node('p');

        $node->addChild($childNode);

        $this->assertSame($childNode, $node->getChildren()[0]);
        $this->assertSame($node, $childNode->getParent());
    }

    public function testAddChildAtSpecificIndex()
    {
        $node = new Node('div');

        $node->addChild(new Node('p'));
        $node->addChild(new Node('p'));
        $node->addChild(new Node('p'));
        $node->addChild(new Node('p'));

        $childNode = new Node('a');
        $childNode2 = new Node('ul');

        $node->addChild($childNode, 0);
        $node->addChild($childNode2, 2);

        $this->assertSame($childNode, $node->getChildren()[0]);
        $this->assertSame($childNode2, $node->getChildren()[2]);
        $this->assertCount(6, $node->getChildren());
    }

    public function testFindChild()
    {
        $node = new Node('div');

        $node->addChild(new Node('p'));
        $node->addChild(new Node('p'));
        $node->addChild(new Node('p'));
        $node->addChild(new Node('p'));

        $childNode = new Node('a');
        $childNode2 = new Node('ul');
        $node->addChild($childNode, 2);

        $this->assertEquals(2, $node->findChild($childNode));
        $this->assertNull($node->findChild($childNode2));
    }

    public function testDelete()
    {
        $node = new Node('div');
        $childNode = new Node('p');
        $childNode2 = new Node('p');

        $node->addChild($childNode);
        $node->addChild($childNode2);

        $childNode->delete();

        $this->assertCount(1, $node->getChildren());
    }
}
