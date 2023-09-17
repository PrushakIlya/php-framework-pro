<?php

namespace Prushak\Framework\Test;

use PHPUnit\Framework\TestCase;
use Prushak\Framework\Container\Container;
use Prushak\Framework\Container\ContainerException;

class ContainerTest extends TestCase {
    /** @test */
    public function a_service_can_be_retrieved_from_the_container(): void
    {
        // Setup
        $container = new Container();

        // Do
        // id string, concrete class name string | object
        $container->add('dependant-class', DependantClass::class);

        // Make assertions

        $this->assertInstanceOf(DependantClass::class, $container->get('dependant-class'));
    }

    /** @test */
    public function throw_containerException_if_concrete_class_does_not_exist() {
        $container = new Container();

        $this->expectException(ContainerException::class);

        $container->add('foobar');
    }

    /** @test */
    public function check_if_the_container_has_a_service(): void
    {
        $container = new Container();

        $container->add('dependant-class', DependantClass::class);

        $this->assertTrue($container->has('dependant-class'));
        $this->assertFalse($container->has('not-existent-class'));
    }

    /** @test */
    public function service_can_be_recursive_autowired() {
        $container = new Container();

        $container->add('dependant-service', DependantClass::class);

        $dependencyClass = $container->get('dependant-service');

        $this->assertInstanceOf(DependencyClass::class, $dependencyClass);
    }
}

