<?php

namespace tests\ddd\Utility;

use PHPUnit\Framework\TestCase;

use ddd\Utility\Specification;
use ddd\Utility\AbstractSpecification;
use ddd\Utility\AndSpecification;
use ddd\Utility\OrSpecification;
use ddd\Utility\NotSpecification;

/**
 * Tests the specification system.
 *
 * @author ely
 */
class SpecificationTest extends TestCase
{

    /**
     * @dataProvider andSpecificationProvider
     */
    public function testAndSpecification(string $expect, Specification $left, Specification $right)
    {
        $and = new AndSpecification($left, $right);
        
        $this->{$expect}(
            $and->isSatisfiedBy(new \stdClass())
        );
    }
    
    public function andSpecificationProvider()
    {
        $true  = new SpecificationMock(true);
        $false = new SpecificationMock(false);
        
        return [
            'true  && true'  => ['assertTrue',  $true,  $true],
            'true  && false' => ['assertFalse', $true,  $false],
            'false && true'  => ['assertFalse', $false, $true],
            'false && false' => ['assertFalse', $false, $false],
        ];
    }
    
    /**
     * @dataProvider orSpecificationProvider
     */
    public function testOrSpecification(string $expect, Specification $left, Specification $right)
    {
        $and = new OrSpecification($left, $right);
        
        $this->{$expect}(
            $and->isSatisfiedBy(new \stdClass())
        );
    }
    
    public function orSpecificationProvider()
    {
        $true  = new SpecificationMock(true);
        $false = new SpecificationMock(false);

        return [
            'true  || true'  => ['assertTrue',  $true,  $true],
            'true  || false' => ['assertTrue',  $true,  $false],
            'false || true'  => ['assertTrue',  $false, $true],
            'false || false' => ['assertFalse', $false, $false],
        ];
    }
    
    /**
     * @dataProvider notSpecificationProvider
     */
    public function testNotSpecification(string $expect, Specification $specification)
    {
        $and = new NotSpecification($specification);
        
        $this->{$expect}(
            $and->isSatisfiedBy(new \stdClass())
        );
    }
    
    public function notSpecificationProvider()
    {
        $true  = new SpecificationMock(true);
        $false = new SpecificationMock(false);
        
        return [
            '!true'  => ['assertFalse', $true],
            '!false' => ['assertTrue',  $false],
        ];
    }
    
    public function testCompositeSpecifications()
    {
        $true  = new SpecificationMock(true);
        $false = new SpecificationMock(false);
        
        $this->assertTrue(
            $true
                ->andSpec($true)
                ->isSatisfiedBy(new \stdClass())
        );
        
        $this->assertTrue(
            $false
                ->orSpec($true)
                ->isSatisfiedBy(new \stdClass())
        );
        
        $this->assertTrue(
            $false
                ->notSpec()
                ->isSatisfiedBy(new \stdClass())
        );
        
        $this->assertTrue(
            $false->notSpec()
                ->andSpec(
                    $true->andSpec(
                        $false->orSpec($true)
                    )
                )
                ->isSatisfiedBy(new \stdClass())
        );
    }

}
