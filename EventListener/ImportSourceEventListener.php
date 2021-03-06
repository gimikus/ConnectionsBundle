<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ConnectionsBundle\EventListener;

use Doctrine\ORM\EntityManager;
use ONGR\ConnectionsBundle\Import\DoctrineImportIterator;
use ONGR\ConnectionsBundle\Pipeline\Event\SourcePipelineEvent;
use ONGR\ElasticsearchBundle\ORM\Manager;

/**
 * Class ImportSourceEventListener - gets items from Doctrine, creates empty Elasticsearch documents.
 */
class ImportSourceEventListener extends AbstractImportSourceEventListener
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string Entity class type of source.
     */
    protected $entityClass;

    /**
     * @var Manager Elasticsearch manager.
     */
    protected $elasticsearchManager;

    /**
     * @var string Classname of Elasticsearch document. (e.g. Product).
     */
    protected $documentClass;

    /**
     * Gets all documents by given type.
     *
     * @return DoctrineImportIterator
     */
    public function getAllDocuments()
    {
        return new DoctrineImportIterator(
            $this->entityManager->createQuery("SELECT e FROM {$this->entityClass} e")->iterate(),
            $this->entityManager,
            $this->elasticsearchManager->getRepository($this->documentClass)
        );
    }

    /**
     * Gets data and adds source.
     *
     * @param SourcePipelineEvent $event
     */
    public function onSource(SourcePipelineEvent $event)
    {
        $event->addSource($this->getAllDocuments());
    }
}
