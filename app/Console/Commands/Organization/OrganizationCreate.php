<?php
namespace BookieGG\Console\Commands\Organization;

use BookieGG\Repositories\Eloquent\OrganizationRepository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class OrganizationCreate extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'org:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new organization';
    /**
     * @var OrganizationRepository
     */
    private $organizationRepository;

    /**
     * Create a new command instance.
     * @param OrganizationRepository $or
     */
    public function __construct(OrganizationRepository $or)
    {
        parent::__construct();
        $this->organizationRepository = $or;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->organizationRepository->create($this->argument('name'), $this->argument('url'));
        $this->info("Organization '" . $this->argument('name') . "' was successfully created.'");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Organization name (eg. ESEA)'],
            ['url', InputArgument::OPTIONAL, 'Organization URL (eg. http://play.esea.net/)']
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
