<?php namespace BookieGG\Console\Commands\Organization;

use BookieGG\Contracts\Repositories\OrganizationRepositoryInterface;
use BookieGG\Repositories\Eloquent\OrganizationRepository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class OrganizationDelete extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'org:delete';

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
     * @param OrganizationRepositoryInterface $organizationRepository
     */
    public function __construct(OrganizationRepositoryInterface $organizationRepository)
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
        $organization = $this->organizationRepository->findById($this->argument('id'));

        if(!$organization) {
            $this->error("Organization #" . $this->argument('id') . " does not exist!");
        } else {
            $delete = $this->organizationRepository->delete($organization);

            if ($delete === true) {
                $this->info("Organization '" . $organization->name . "' was successfully deleted.");
            } else {
                $this->error("Organization #" . $this->argument('id') . " was not deleted!");
            }
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
            ['id', InputArgument::REQUIRED, 'ID of organization to be deleted'],
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
