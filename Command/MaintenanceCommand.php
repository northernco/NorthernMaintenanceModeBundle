<?php

namespace Northern\MaintenanceModeBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'northern:maintenance',
    description: 'Toggle maintenance mode',
)]
class MaintenanceCommand extends Command
{
    private Filesystem $filesystem;

    private string $flagPath;

    public function __construct(
        Filesystem $filesystem,
        string $flagPath,
        string $name = null
    ) {
        parent::__construct($name);

        $this->filesystem = $filesystem;
        $this->flagPath   = $flagPath;
    }

    protected function configure(): void
    {
        $this->addOption('enable', null, InputOption::VALUE_NONE, 'Enable maintenance mode')
             ->addOption('disable', null, InputOption::VALUE_NONE, 'Disable maintenance mode');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $enable  = $input->getOption('enable');
        $disable = $input->getOption('disable');

        if ($enable === $disable) {
            $io->error($enable ? 'Cannot enable and disable maintenance mode at the same time' : 'You must either enable or disable maintenance mode');

            return Command::FAILURE;
        }

        if ($enable) {
            $this->filesystem->touch($this->flagPath);
        } else {
            $this->filesystem->remove($this->flagPath);
        }

        $io->success($enable ? 'Maintenance mode enabled' : 'Maintenance mode disabled');

        return Command::SUCCESS;
    }
}
