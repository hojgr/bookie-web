<?php namespace BookieGG\Console\Commands\Organization;

use BookieGG\Repositories\Eloquent\OrganizationRepository;
use Illuminate\Console\Command;

class OrganizationList extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'org:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all organizations';
    /**
     * @var OrganizationRepository
     */
    private $organizationRepository;

    /**
     * Create a new command instance.
     *
     * @param OrganizationRepository $organizationRepository
     */
    public function __construct(OrganizationRepository $organizationRepository)
    {
        parent::__construct();
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $organizations = $this->organizationRepository->getAll();

        $this->table(['#', 'Name', "URL"], array_map(function($organization) {
            return [$organization['id'], $organization['name'], $organization['url']];
        }, $organizations->toArray()));
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
