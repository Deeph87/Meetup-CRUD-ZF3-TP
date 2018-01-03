<?php
namespace ZendSkeletonModule;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Meetup\Bootstrap\Component;
use Meetup\Entity\Meetup;
use Meetup\Form\MeetupForm;
use Meetup\Controller;
use Meetup\Factory;
use Meetup\Service;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\ShowController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'show' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => 'meetup/show/:id',
                            'defaults' => [
                                'action'     => 'show',
                            ],
                        ],
                    ],
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => 'meetup/new',
                            'defaults' => [
                                'controller' => Controller\WriteController::class,
                                'action'     => 'add',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => 'meetup/edit/:id',
                            'defaults' => [
                                'controller' => Controller\WriteController::class,
                                'action'     => 'edit',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => 'meetup/delete/:id',
                            'defaults' => [
                                'controller' => Controller\DeleteController::class,
                                'action'     => 'delete',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\WriteController::class => Factory\WriteControllerFactory::class,
            Controller\ShowController::class => Factory\ShowControllerFactory::class,
            Controller\DeleteController::class => Factory\DeleteControllerFactory::class
        ],
    ],
    'service_manager' => [
        'factories' => [
            \DateTimeImmutable::class => Factory\DateTimeImmutableFactory::class,
            MeetupForm::class => InvokableFactory::class,
            MeetupForm::class => Factory\MeetupFormFactory::class,
            Meetup::class => InvokableFactory::class,
            Component::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'         => __DIR__ . '/../view/layout/layout.phtml',
            'meetup/show/show'            => __DIR__ . '/../view/meetup/show/show.phtml',
            'meetup/show/index'          => __DIR__ . '/../view/meetup/show/index.phtml',
            'meetup/write/add'            => __DIR__ . '/../view/meetup/write/add.phtml',
            'meetup/write/edit'            => __DIR__ . '/../view/meetup/write/edit.phtml',
            'error/404'             => __DIR__ . '/../view/error/404.phtml',
            'error/index'           => __DIR__ . '/../view/error/index.phtml',
        ],
    ],
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'application_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../src/Entity/',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `application_driver` for any entity under namespace `Meetup\Entity`
                    'Meetup\Entity' => 'application_driver',
                ],
            ],
        ],
    ],
];
