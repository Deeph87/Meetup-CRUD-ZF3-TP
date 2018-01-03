<?php

declare(strict_types=1);

namespace Meetup\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Meetup\Entity\Meetup;
use Meetup\Form\MeetupForm;
use Meetup\Bootstrap\Component;
use Zend\View\Model\ViewModel;
use Meetup\Repository\MeetupRepository;
use Doctrine\ORM\EntityManager;

class WriteController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Meetup
     */
    private $meetupEntity;

    /**
     * @var MeetupRepository
     */
    private $meetupRepository;

    /**
     * @var MeetupForm
     */
    private $meetupForm;

    /**
     * @var Component
     */
    private $bootstrapComponent;

    public function __construct(EntityManager $entityManager, Meetup $meetupEntity, MeetupRepository $meetupRepository, MeetupForm $meetupForm, Component $bootstrapComponent)
    {
        $this->entityManager = $entityManager;
        $this->meetupEntity = $meetupEntity;
        $this->meetupRepository = $meetupRepository;
        $this->meetupForm = $meetupForm;
        $this->bootstrapComponent = $bootstrapComponent;
    }

    public function addAction()
    {
        $this->meetupForm->prepare();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $this->meetupForm->setData($data);

            if ($this->meetupForm->isValid()) {
                $dateStart = date_create($data['dateStart']);
                $dateEnd = date_create($data['dateEnd']);

                // Get filtered and validated data
                $data = $this->meetupForm->getData();

                // Setting valid data
                $this->meetupEntity->setTitle($data['title']);
                $this->meetupEntity->setDescription($data['description']);
                $this->meetupEntity->setDateStart($dateStart);
                $this->meetupEntity->setDateEnd($dateEnd);

                $this->entityManager->persist($this->meetupEntity);
                $this->entityManager->flush();

                $content = 'Le Meetup "' . $this->meetupEntity->getTitle() . '" a été ajouté avec succés.';
                $successMessage = $this->bootstrapComponent->getAlertComponent(Component::ALERT_SUCCESS, $content);

                $this->flashMessenger()->addSuccessMessage($successMessage);

                return $this->redirect()->toRoute('home');
            }
        }

        return new ViewModel([
            'form' => $this->meetupForm,
        ]);
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id', -1);

        $this->meetupEntity = $this->entityManager->find('Meetup\\Entity\\Meetup', $id);

        if ($this->meetupEntity == null) {
            $content = 'Ce Meetup n\'éxiste pas';
            $dangerMessage = $this->bootstrapComponent->getAlertComponent(Component::ALERT_DANGER, $content);

            $this->flashMessenger()->addErrorMessage($dangerMessage);

            return $this->redirect()->toRoute('home');
        }

        $this->meetupForm->bind($this->meetupEntity);

        $viewModel = new ViewModel([
            'form' => $this->meetupForm,
        ]);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $this->meetupForm->setData($data);

            if ($this->meetupForm->isValid()) {
                $dateStart = date_create($data['dateStart']);
                $dateEnd = date_create($data['dateEnd']);

                // Setting valid data
                $this->meetupEntity->setTitle($data['title']);
                $this->meetupEntity->setDescription($data['description']);
                $this->meetupEntity->setDateStart($dateStart);
                $this->meetupEntity->setDateEnd($dateEnd);

                $this->entityManager->flush();

                $content = 'Le Meetup "' . $this->meetupEntity->getTitle() . '" a été edité avec succés.';
                $successMessage = $this->bootstrapComponent->getAlertComponent(Component::ALERT_SUCCESS, $content);

                $this->flashMessenger()->addSuccessMessage($successMessage);

                return $this->redirect()->toRoute('home');
            }
        }

        return $viewModel;
    }
}
