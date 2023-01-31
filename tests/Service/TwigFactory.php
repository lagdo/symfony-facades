<?php

namespace Lagdo\Symfony\Facades\Tests\Service;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class TwigFactory
{
    /**
     * @return Environment
     */
    public static function twig(): Environment
    {
        $loader = new FilesystemLoader(__DIR__ . '/../twig/templates');

        return new Environment($loader, ['cache' => __DIR__ . '/../twig/cache']);
    }
}
