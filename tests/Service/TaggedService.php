<?php

namespace Lagdo\Symfony\Facades\Tests\Service;

use Psr\Log\LoggerInterface;

class TaggedService implements TaggedServiceInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function log(string $message)
    {
        $this->logger->debug($message);
    }
}
