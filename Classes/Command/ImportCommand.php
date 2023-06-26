<?php
declare(strict_types=1);
namespace WapplerSystems\Pretix\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use WapplerSystens\Pretix\Service\ApiService;

class ImportCommand extends Command
{

    protected ApiService $apiService;

    public function __construct(string $name = null, ApiService $apiService)
    {
        parent::__construct($name);
        $this->apiService = $apiService;
    }


    /**
     * Configure the command
     */
    public function configure()
    {
        $description = 'Importer command to import json export files into a current database. ' .
            'New uids will be inserted for records.' .
            'Note: At the moment only sys_file_reference is supported as mm table ';
        $this->setDescription($description);
    }

    /**
     *
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {


        $this->apiService->getEvents();


        try {

            $importService = GeneralUtility::makeInstance(ImportService::class);

            $events = $importService->import(
                (int)$input->getArgument('pid'),
                (string)$input->getArgument('url'));
            $message = 'Success. ' . $events . ' new events imported!';
        } catch (\Exception $exception) {
            $message = $exception->getMessage() . ' (Errorcode ' . $exception->getCode() . ')';
        }
        $output->writeln($message);
        return 0;
    }


}
