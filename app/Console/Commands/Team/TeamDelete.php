<?php namespace BookieGG\Console\Commands\Team;

use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TeamDelete extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'team:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';
    /**
     * @var TeamRepositoryInterface
     */
    private $teamRepositoryInterface;

    /**
     * Create a new command instance.
     *
     * @param TeamRepositoryInterface $teamRepositoryInterface
     */
    public function __construct(TeamRepositoryInterface $teamRepositoryInterface)
    {
        parent::__construct();
        $this->teamRepositoryInterface = $teamRepositoryInterface;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $id = $this->argument('id');
        $team = $this->teamRepositoryInterface->getById($id);

        if(!$team) {
            $this->error("Team #$id was not found");
        } else {
            $this->teamRepositoryInterface->delete($team);
            $this->info("Team '" . $team->name . "' has been successfully deleted");
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
            ['id', InputArgument::REQUIRED, 'Team ID to be deleted'],
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
