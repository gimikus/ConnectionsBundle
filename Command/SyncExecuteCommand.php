<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ConnectionsBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command which checks sync storage for updated/created/deleted data and imports changes to elastic search.
 */
class SyncExecuteCommand extends AbstractStartServiceCommand
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('ongr:sync:execute', 'Imports data from SyncStorage.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->start($input, $output, 'ongr_connections.sync.execute_service', 'sync.execute.');
    }
}
