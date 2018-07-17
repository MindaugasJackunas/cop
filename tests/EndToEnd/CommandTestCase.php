<?php

declare(strict_types = 1);

namespace App\Tests\EndToEnd;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CommandTestCase
 */
class CommandTestCase extends KernelTestCase
{
    /**
     * @var Application
     */
    protected $application;

    /**
     * Setup application for e2e testing.
     */
    protected function setUp()
    {
        $this->application = new Application(self::bootKernel());
    }
}
