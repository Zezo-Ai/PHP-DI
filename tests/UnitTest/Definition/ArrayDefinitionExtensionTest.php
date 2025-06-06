<?php

declare(strict_types=1);

namespace DI\Test\UnitTest\Definition;

use DI\Definition\ArrayDefinition;
use DI\Definition\ArrayDefinitionExtension;
use DI\Definition\ValueDefinition;
use PHPUnit\Framework\TestCase;
use DI\Definition\Exception\InvalidDefinition;

/**
 * @covers \DI\Definition\ArrayDefinitionExtension
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\DI\Definition\ArrayDefinitionExtension::class)]
class ArrayDefinitionExtensionTest extends TestCase
{
    public function test_getters()
    {
        $definition = new ArrayDefinitionExtension(['hello']);
        $definition->setName('foo');

        $this->assertEquals('foo', $definition->getName());
        $this->assertEquals(['hello'], $definition->getValues());
    }

    /**
     * @test
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function should_append_values_after_sub_definitions_values()
    {
        $definition = new ArrayDefinitionExtension(['foo']);
        $definition->setExtendedDefinition(new ArrayDefinition(['bar']));

        $expected = [
            'bar',
            'foo',
        ];

        $this->assertEquals($expected, $definition->getValues());
    }

    /**
     * @test
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function should_error_if_not_extending_an_array()
    {
        $this->expectException(InvalidDefinition::class);
        $this->expectExceptionMessage('Definition name tries to add array entries but the previous definition is not an array');
        $definition = new ArrayDefinitionExtension(['foo']);
        $definition->setName('name');
        $definition->setExtendedDefinition(new ValueDefinition('value'));
    }
}
