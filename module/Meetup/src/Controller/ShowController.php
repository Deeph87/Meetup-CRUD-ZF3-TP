<?php

declare(strict_types=1);

namespace Meetup\Controller;

use Meetup\Bootstrap\Component;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Meetup\Repository\MeetupRepository;
use Doctrine\ORM\EntityManager;

class ShowController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var MeetupRepository
     */
    private $meetupRepository;

    /**
     * @var Component
     */
    private $bootstrapComponent;

    /**
     * @var
     */
    private $meetupEntity;

    public function __construct(EntityManager $entityManager, MeetupRepository $meetupRepository, Component $bootstrapComponent)
    {
        $this->entityManager = $entityManager;
        $this->meetupRepository = $meetupRepository;
        $this->bootstrapComponent = $bootstrapComponent;
    }

    public function indexAction()
    {
        $flashMessenger = $this->flashMessenger();
        if ($flashMessenger->hasSuccessMessages()) {
            $dataToView['successMessages'] = $flashMessenger->getSuccessMessages();
        }

        if ($flashMessenger->hasErrorMessages()) {
            $dataToView['errorMessages'] = $flashMessenger->getErrorMessages();
        }
        $dataToView['meetups'] = $this->meetupRepository->findAll();

        if (empty($dataToView['meetups'])) {
            $content = 'Aucun Meetup enregistré';
            $warningMessage = $this->bootstrapComponent->getAlertComponent(Component::ALERT_WARNING, $content);
            $flashMessenger->addWarningMessage($warningMessage);

            if ($flashMessenger->hasWarningMessages()) {
                $dataToView['warningMessages'] = $flashMessenger->getWarningMessages();
            }
        }

        return new ViewModel($dataToView);
    }

    public function showAction()
    {
        $id = $this->params()->fromRoute('id', -1);

        $this->meetupEntity = $this->entityManager->find('Meetup\\Entity\\Meetup', $id);

        if ($this->meetupEntity == null) {
            $content = 'Le Meetup n\'éxiste pas.';
            $errorMessage = $this->bootstrapComponent->getAlertComponent(Component::ALERT_DANGER, $content);

            $this->flashMessenger()->addErrorMessage($errorMessage);

            return $this->redirect()->toRoute('home');
        }

        return new ViewModel([
            'meetup' => $this->meetupEntity,
        ]);
    }
}
