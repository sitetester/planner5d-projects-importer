<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\Project\ProjectsImporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportProjectsCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:import-projects';
    private ProjectsImporter $projectsImporter;

    public function __construct(ProjectsImporter $projectsImporter)
    {
        $this->projectsImporter = $projectsImporter;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Imports planner5d projects.')

            // the full command description shown when running the command with the "--help" option
            ->setHelp(
                'This command allows us to import planner5d projects from https://planner5d.com/gallery/floorplans'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Importing projects...');

        if ($this->projectsImporter->import()) {
            $output->writeln('<info>Success!</info>');
        } else {
            $output->writeln('<error>Something went wrong while importing projects. Check logs!</error>');
        }

        return Command::SUCCESS;
    }
}
