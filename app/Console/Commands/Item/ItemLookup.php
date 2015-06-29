<?php namespace BookieGG\Console\Commands\Item;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ItemLookup extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'item:lookup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Looks up items by given keywords';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->comment("Not implemented");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['keywords', InputArgument::REQUIRED, 'Keywords'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['item', 'i', InputArgument::REQUIRED, 'Item name/keyword'],
        ];
    }

}
