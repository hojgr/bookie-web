<?php namespace BookieGG\Console\Commands\Match;

use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MatchDelete extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'match:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';
    /**
     * @var MatchRepositoryInterface
     */
    private $mri;

    /**
     * Create a new command instance.
     * @param MatchRepositoryInterface $mri
     */
    public function __construct(MatchRepositoryInterface $mri)
    {
        parent::__construct();
        $this->mri = $mri;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $id = $this->argument('id');
        $match = $this->mri->find($id);

        if(!$match) {
            $this->error("Match #$id was not found");
        } else {
            $this->mri->delete($match);
            $this->info("Match #$id was successfully deleted");
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['id', InputArgument::REQUIRED, 'ID of match to delete'],
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
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

}
