<?php

declare(strict_types = 1);

namespace App\Console;

use App\Processor\Processor;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ProcessCommand
 */
class ProcessCommand extends ContainerAwareCommand
{
    const COMMAND_NAME = 'cop:process';

    const ARGUMENT_NAME = 'fileName';

    const ARGUMENT_DESCRIPTION = 'CSV filename of cash operation data to be processed.';

    /**
     * @var Processor
     */
    private $processor;

    /**
     * ProcessCommand constructor.
     *
     * @param Processor $processor
     */
    public function __construct(Processor $processor)
    {
        parent::__construct(self::COMMAND_NAME);

        $this->processor = $processor;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->addArgument(self::ARGUMENT_NAME, InputArgument::REQUIRED, self::ARGUMENT_DESCRIPTION);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument(self::ARGUMENT_NAME);

        foreach ($this->processor->process($fileName) as $commission) {
            $output->writeln($commission);
        }
    }
}
