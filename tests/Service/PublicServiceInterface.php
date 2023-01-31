<?php

namespace Lagdo\Symfony\Facades\Tests\Service;

interface PublicServiceInterface
{
    /**
     * @param string $message
     *
     * @return void
     */
    public function log(string $message);
}
