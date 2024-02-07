<?php

namespace App\Jobs;

use App\Controllers\ParserController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductParser extends Command
{
    private $parserController;
    public function __construct(ParserController $parserController, ?string $name = null)
    {
        parent::__construct($name);
        $this->parserController = $parserController;
    }

    protected function configure()
    {
        $this->setName('products:Parser')
            ->setDescription('Парсер для xml Выгрузки')
            ->setHelp('Нет аргументов для выгрузки');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $parserController = $this->parserController->productProcessing();
        print_r($parserController);
        $output->writeln('Комманда успешно запущена');
        return Command::SUCCESS;
    }
}