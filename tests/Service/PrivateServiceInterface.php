<?php

namespace Lagdo\Symfony\Facades\Tests\Service;

interface PrivateServiceInterface
{
    /**
     * @param string $message
     *
     * @return void
     */
    public function log(string $message);
}
