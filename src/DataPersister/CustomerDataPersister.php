<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

/**
 * Class CustomerDataPersister
 * @package App\DataPersister
 */
class CustomerDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_request;
    private $_security;

    /**
     * ProductDataPersister constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param RequestStack           $request
     * @param Security               $security
     */
    public function __construct(EntityManagerInterface $entityManager, RequestStack $request, Security $security)
    {
        $this->_entityManager = $entityManager;
        $this->_request = $request->getCurrentRequest();
        $this->_security = $security;
    }

    /**
     * @param       $data
     * @param array $context
     *
     * @return bool
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Customer;
    }

    /**
     * @param Customer $data
     * @param array    $context
     *
     * @return object|void
     */
    public function persist($data, array $context = [])
    {
        if ($this->_request->getMethod() === 'POST') {
            $data->setUpdatedAt();
            $data->setUser($this->_security->getUser());
        }

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    /**
     * @param       $data
     * @param array $context
     */
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}