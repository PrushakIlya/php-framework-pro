<?php

namespace Prushak\Framework\Test;

class DependantClass {
    public function __construct(private SomeClass $dependencyClasssssss , private DependencyClass $dependencyClass)
    {

    }

    public function kk() {
        return $this->dependencyClass->test();
    }
}