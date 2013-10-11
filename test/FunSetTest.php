<?php

class FunSetsTest extends PHPUnit_Framework_TestCase
{

    private $funSets;

    protected function setUp()
    {
        $this->funSets = new FunSets();
    }


    public function testSingletonSetContainsSingleElement()
    {
        // A singleton set is characterize by a function which passed to contains will return true for the single element
        // passed as its parameter. In other words, a singleton is a set with a single element.

        $singleton = $this->funSets->singletonSet(1);
        $this->assertTrue($this->funSets->contains($singleton, 1));
    }

    public function testUnionContainsAllElements()
    {
        // A union is characterized by a function which gets 2 sets as parameters and contains all the provided sets

        // We can only create singletons at this point, so we create 2 singletons and unite them
        $s1 = $this->funSets->singletonSet(1);
        $s2 = $this->funSets->singletonSet(2);
        $union = $this->funSets->union($s1, $s2);

        // Now, check that both 1 and 2 are part of the union
        $this->assertTrue($this->funSets->contains($union, 1));
        $this->assertTrue($this->funSets->contains($union, 2));
        // ... and that it does not contain 3
        $this->assertFalse($this->funSets->contains($union, 3));
    }

    function testIntersectionContainsOnlyCommonElements()
    {
        $u12 = $this->createUnionWithElements(1, 2);
        $u23 = $this->createUnionWithElements(2, 3);
        $intersection = $this->funSets->intersect($u12, $u23);

        // Verify intersection has common elements
        $this->assertTrue($this->funSets->contains($intersection, 2));
        // Check intersection does not have unique elements
        $this->assertFalse($this->funSets->contains($intersection, 1));
        $this->assertFalse($this->funSets->contains($intersection, 3));
    }

    function testDiffContainsOnlyUniqueElementsFromTheFirstArray()
    {
        $u12 = $this->createUnionWithElements(1, 2);
        $u23 = $this->createUnionWithElements(2, 3);
        $difference = $this->funSets->diff($u12, $u23);

        // Verify difference has the unique element from the first set
        $this->assertTrue($this->funSets->contains($difference, 1));
        // Check difference does not have the common element
        $this->assertFalse($this->funSets->contains($difference, 2));
        // Check difference does not have the element form the second set
        $this->assertFalse($this->funSets->contains($difference, 3));
    }

    private function createUnionWithElements($elem1, $elem2)
    {
        $s1 = $this->funSets->singletonSet($elem1);
        $s2 = $this->funSets->singletonSet($elem2);
        return $this->funSets->union($s1, $s2);
    }
}