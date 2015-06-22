<?php namespace BookieGG\Console\Commands\Match;

use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use Illuminate\Console\Command;

class MatchList extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'match:list';

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
        $teams = $this->mri->all();
        $team_array = [];

        foreach($teams as $team) {
            $team_array[] = [
                $team->id,
                $team->organization->name,
                $team->bo,
                $team->teams[0]->name,
                $team->teams[1]->name
            ];
        }

        $this->table(['#', 'Host', 'BO', 'Team#1', 'Team#2'], $team_array);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
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
        ];
    }

}
