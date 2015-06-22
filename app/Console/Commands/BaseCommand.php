<?php


namespace BookieGG\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command {
    public function run(InputInterface $input, OutputInterface $output) {
        $formatter = new OutputFormatter($output->isDecorated());
        $formatter->setStyle('green', new OutputFormatterStyle('green'));
        $formatter->setStyle('red', new OutputFormatterStyle('red'));
        $formatter->setStyle('back-green', new OutputFormatterStyle(null, 'green'));
        $formatter->setStyle('back-red', new OutputFormatterStyle(null, 'red'));
        $formatter->setStyle('yellow', new OutputFormatterStyle('yellow'));
        $formatter->setStyle('blue', new OutputFormatterStyle('blue'));
        $formatter->setStyle('magenta', new OutputFormatterStyle('magenta'));
        $formatter->setStyle('yellow-blue', new OutputFormatterStyle('yellow'));

        $output->setFormatter($formatter);

        parent::run($input, $output);
    }
}