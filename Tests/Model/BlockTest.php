<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\PageBundle\Tests\Entity;

use Sonata\PageBundle\Tests\Model\Block;

class BlockTest extends \PHPUnit_Framework_TestCase
{

    public function testGetTtl()
    {
        $page = $this->getMock('Sonata\PageBundle\Model\PageInterface');

        $block = new Block;
        $block->setPage($page);

        $this->assertFalse($block->hasChildren());

        $child1 = $this->getMock('Sonata\PageBundle\Model\BlockInterface');
        $child1->expects($this->once())->method('getTtl')->will($this->returnValue(100));

        $child2 = $this->getMock('Sonata\PageBundle\Model\BlockInterface');
        $child2->expects($this->once())->method('getTtl')->will($this->returnValue(50));

        $child3 = $this->getMock('Sonata\PageBundle\Model\BlockInterface');
        $child3->expects($this->once())->method('getTtl')->will($this->returnValue(65));

        $block->addChildren($child1);
        $block->addChildren($child2);
        $block->addChildren($child3);

        $this->assertEquals(50, $block->getTtl());

        $this->assertTrue($block->hasChildren());
    }

    public function testSetterGetter()
    {
        $time = new \DateTime;
        $page = $this->getMock('Sonata\PageBundle\Model\PageInterface');
        $parent = $this->getMock('Sonata\PageBundle\Model\BlockInterface');

        $block = new Block;

        $block->setCreatedAt($time);
        $block->setUpdatedAt($time);
        $block->setEnabled(true);
        $block->setPosition(1);
        $block->setType('foo.bar');
        $block->setPage($page);
        $block->setParent($parent);

        $this->assertEquals($time, $block->getCreatedAt());
        $this->assertEquals($time, $block->getUpdatedAt());
        $this->assertTrue($block->getEnabled());
        $this->assertEquals(1, $block->getPosition());
        $this->assertEquals('foo.bar', $block->getType());
        $this->assertEquals($page, $block->getPage());
        $this->assertEquals($parent, $block->getParent());

    }

    public function testSetting()
    {
        $block = new Block();
        $block->setSetting('foo', 'bar');
        $this->assertEquals('void', $block->getSetting('fake', 'void'));
        $this->assertNull($block->getSetting('fake'));
        $this->assertEquals('bar', $block->getSetting('foo'));
    }
}