<?php

declare(strict_types=1);

namespace Meetup\Controller;

use Meetup\Bootstrap\Component;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;

class DeleteController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Component
     */
    private $bootstrapComponent;

    /**
     * @var
     */
    private $meetupEntity;

    public function __construct(EntityManager $entityManager, Component $bootstrapComponent)
    {
        $this->entityManager = $entityManager;
        $this->bootstrapComponent = $bootstrapComponent;
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', false);

        $this->meetupEntity = $this->entityManager->find('Meetup\\Entity\\Meetup', $id);

        if ($this->meetupEntity == null) {
            $content = 'Le Meetup n\'éxiste pas.';
            $successMessage = $this->bootstrapComponent->getAlertComponent(Component::ALERT_DANGER, $content);

            $this->flashMessenger()->addErrorMessage($successMessage);

            return $this->redirect()->toRoute('home');
        }

        $this->entityManager->remove($this->meetupEntity);
        $this->entityManager->flush();

        $content = 'Le Meetup "' . $this->meetupEntity->getTitle() . '" a été supprimé avec succés.';
        $successMessage = $this->bootstrapComponent->getAlertComponent(Component::ALERT_SUCCESS, $content);

        $this->flashMessenger()->addSuccessMessage($successMessage);

        return $this->redirect()->toRoute('home');
    }
}
