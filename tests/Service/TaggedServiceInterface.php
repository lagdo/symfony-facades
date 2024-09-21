<?php

namespace Lagdo\Symfony\Facades\Tests\Service;

interface TaggedServiceInterface
{
    /**
     * @param string $message
     *
     * @return void
     */
    public function log(string $message);
}
