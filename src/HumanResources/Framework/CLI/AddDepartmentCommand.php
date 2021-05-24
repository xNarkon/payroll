<?php

declare(strict_types=1);

namespace HumanResources\Framework\CLI;

use HumanResources\Application\CQRS\Command\CreateDepartmentCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

final class AddDepartmentCommand extends Command
{
    private MessageBusInterface $humanResourcesCommandBus;

    public function __construct(MessageBusInterface $humanResourcesCommandBus)
    {
        parent::__construct('hr:department:add');
        $this->humanResourcesCommandBus = $humanResourcesCommandBus;
    }

    protected function configure(): void
    {
        $this->setDescription('Adds new department');
        $this->addArgument('name', InputArgument::REQUIRED, 'Department name');
        $this->addArgument('salary_supplement_type', InputArgument::REQUIRED, 'Salary supplement type. Available types are: [percentage, fixed_amount]');
        $this->addArgument('salary_supplement_value', InputArgument::REQUIRED, 'Salary supplement value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->humanResourcesCommandBus->dispatch(
            new CreateDepartmentCommand(
                $departmentUuid = (string) Uuid::v4(),
                $input->getArgument('name'),
                $input->getArgument('salary_supplement_type'),
                (int) $input->getArgument('salary_supplement_value')
            )
        );

        $output->writeln(sprintf('<info>Department successfully added with identifier: %s</info>', $departmentUuid));

        return Command::SUCCESS;
    }
}
