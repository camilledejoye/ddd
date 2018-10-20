<?php

namespace ddd\Specification;

use PHPUnit\Framework\TestCase;

use ddd\Specification\Specification;
use ddd\Specification\AndSpecification;
use ddd\Specification\OrSpecification;
use ddd\Specification\NotSpecification;

use ddd\Specification\SpecificationMock;

/**
 * Tests the specification system.
 *
 * @author cdejoye
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
                ->and_($true)
                ->isSatisfiedBy(new \stdClass())
        );
        
        $this->assertTrue(
            $false
                ->or_($true)
                ->isSatisfiedBy(new \stdClass())
        );
        
        $this->assertTrue(
            $false
                ->not_()
                ->isSatisfiedBy(new \stdClass())
        );
        
        $this->assertTrue(
            $false->not_()
                ->and_(
                    $true->and_(
                        $false->or_($true)
                    )
                )
                ->isSatisfiedBy(new \stdClass())
        );
    }

}
