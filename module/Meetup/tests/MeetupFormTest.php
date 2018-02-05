<?php

declare(strict_types=1);

use Meetup\Form\MeetupForm;
use PHPUnit\Framework\TestCase;

class MeetupFormTest extends TestCase
{

    protected $mf;

	public function setUp()
    {
    	$this->mf = new MeetupForm(new \DateTimeImmutable()); 

        parent::setUp();
    }

    public function testValidateDateChronologyCorrect()
    {
    	$value = "2018-02-07";
    	$context = ["dateEnd" => "2018-02-08"];
    	$compare = "dateEnd";

    	$this->assertTrue($this->mf->validateDateChronology($value, $context, $compare));
    }

    public function testValidateDateChronologyInvalid()
    {
    	$value = "2018-02-13";
    	$context = ["dateEnd" => "2018-02-08"];
    	$compare = "dateEnd";

    	$this->assertFalse($this->mf->validateDateChronology($value, $context, $compare));
    }

    public function testValidateDateChronologyImpossibleDate()
    {
    	$value = "2018-02-35";
    	$context = ["dateEnd" => "2018-02-08"];
    	$compare = "dateEnd";

    	$this->assertFalse($this->mf->validateDateChronology($value, $context, $compare));
    }

    public function testValidateDateChronologyBadValue()
    {
    	$value = "Wrong String";
    	$context = ["dateEnd" => "2018-02-08"];
    	$compare = "dateEnd";

    	$this->assertFalse($this->mf->validateDateChronology($value, $context, $compare));
    }

    public function testValidateDateChronologyBadContextDateInvalid()
    {
    	$value = "2018-02-07";
    	$context = ["dateEnd" => "Wrong string"];
    	$compare = "dateEnd";

    	$this->assertFalse($this->mf->validateDateChronology($value, $context, $compare));
    }

/* FAILURE */
    public function testValidateDateChronologyBadContextKeyInvalid()
    {
    	$value = "2018-02-07";
    	$context = ["Wrong text" => "2018-02-08"];
    	$compare = "dateEnd";

    	$this->assertFalse($this->mf->validateDateChronology($value, $context, $compare));
    }

    public function testValidateDateChronologyBadCompare()
    {
    	$value = "2018-02-07";
    	$context = ["dateEnd" => "2018-02-08"];
    	$compare = "Wrong text";

    	$this->assertFalse($this->mf->validateDateChronology($value, $context, $compare));
    }


    public function tearDown()
    {
        $this->mf = null;
    }
}
