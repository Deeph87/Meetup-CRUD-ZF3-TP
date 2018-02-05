<?php

declare(strict_types=1);

namespace Meetup\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Date;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;
use Zend\Validator;

class MeetupForm extends Form
{
    const DATE_START_POST = 'dateStart';
    const DATE_END_POST = 'dateEnd';

    /**
     * @var \DateTimeImmutable
     */
    private $dateTime;

    public function __construct(\DateTimeImmutable $dateTime)
    {
        parent::__construct('meetup');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Add form Elements
        $this->addElements();

        // Add Filters & Validators
        $this->addInputFilters();

        $this->dateTime = $dateTime;
    }

    private function addElements()
    {
        $title = new Text('title');
        $title->setLabel('Titre');
        $title->setAttributes([
            'class' =>'form-control',
            'placeholder' => 'Insérez un titre de Meetup ...'
        ]);
        $this->add($title);

        $description = new Textarea('description');
        $description->setLabel('Description');
        $description->setAttributes([
            'class' => 'form-control',
            'placeholder' => 'Insérez une description de Meetup ...'
        ]);
        $this->add($description);

        $dateStart = new Date(self::DATE_START_POST);
        $dateStart->setLabel('Date de début');
        $this->add($dateStart);

        $dateEnd = new Date(self::DATE_END_POST);
        $dateEnd->setLabel('Date de fin');
        $this->add($dateEnd);
    }

    private function addInputFilters()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add(
            [
                'name'     => 'title',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 50
                        ],
                    ],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name'     => 'description',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 800
                        ],
                    ],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name'     => self::DATE_START_POST,
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'Callback',
                        'options' => [
                            'callback' => [$this, 'validateDateChronology'],
                            'callbackOptions' => [
                                'compare' => 'dateEnd'
                            ],
                            'messages' => [
                                Validator\Callback::INVALID_VALUE => 'La date de début ne peut pas être après la date de fin.',
                            ]
                        ],
                    ],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name'     => self::DATE_END_POST,
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'Callback',
                        'options' => [
                            'callback' => [$this, 'validateDateChronology'],
                            'callbackOptions' => [
                                'compare' => 'dateStart'
                            ],
                            'messages' => [
                                Validator\Callback::INVALID_VALUE => 'La date de fin ne peut pas être avant la date de début.',
                            ],
                        ],
                    ],
                ],
            ]
        );
    }

    public function validateDateChronology($value, $context, $compare)
    {
        if ($context[$compare] && ($compare === self::DATE_START_POST || $compare === self::DATE_END_POST)) {
            $currentDate = $this->dateTime::createFromFormat('Y-m-d', $value);
            $compareDate = $this->dateTime::createFromFormat('Y-m-d', $context[$compare]);

            if ($currentDate && $compareDate) {
                if ($compare === self::DATE_START_POST) {
                    if ($currentDate->getTimestamp() >= $compareDate->getTimestamp()) {
                        return true;
                    }
                } elseif ($compare === self::DATE_END_POST) {
                    if ($currentDate->getTimestamp() <= $compareDate->getTimestamp()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
