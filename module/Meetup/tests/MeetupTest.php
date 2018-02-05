<?php

declare(strict_types=1);

use Meetup\Entity\Meetup;
use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;

class MeetupTest extends TestCase
{

    protected $mu;

	public function setUp()
    {
    	$this->mu = new Meetup(); 
        $this->mu->setTitle("This is a title");
        $this->mu->setDescription("This is a not very long description");
        $this->mu->setDateStart("2018-02-07");
        $this->mu->setDateEnd("2018-02-08");

        parent::setUp();
    }

    public function testUuidIsValid()
    {
        $this->assertTrue(Uuid::isValid($this->mu->getId()));
    }

    public function testGoodTypes()
    {
        $this->assertInternalType('string', $this->mu->getId());
        $this->assertInternalType('string', $this->mu->getTitle());
        $this->assertInternalType('string', $this->mu->getDescription());
    }

    public function testGetArrayCopy()
    {
        $testArray = [
            "id" => $this->mu->getId(),
            "title" => $this->mu->getTitle(),
            "description" => $this->mu->getDescription(),
            "dateStart" => $this->mu->getDateStart(),
            "dateEnd" => $this->mu->getDateEnd(),
        ];

        $this->assertEquals($this->mu->getArrayCopy(),$testArray);
    }

    public function tearDown()
    {
        $this->mu = null;
    }
}
