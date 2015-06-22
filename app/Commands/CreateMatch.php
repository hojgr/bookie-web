<?php namespace BookieGG\Commands;

use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use BookieGG\Contracts\Repositories\OrganizationRepositoryInterface;
use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateMatch extends Command implements SelfHandling {
    /**
     * @var
     */
    private $org_id;
    /**
     * @var
     */
    private $t1;
    /**
     * @var
     */
    private $t2;
    /**
     * @var
     */
    private $bo;
    /**
     * @var \DateTime
     */
    private $start;
    /**
     * @var
     */
    private $note;

    /**
     * Create a new command instance.
     *
     * @param $org_id
     * @param $t1
     * @param $t2
     * @param $bo
     * @param \DateTime $start
     * @param $note
     */
    public function __construct($org_id, $t1, $t2, $bo, \DateTime $start, $note)
    {
        //
        $this->org_id = $org_id;
        $this->t1 = $t1;
        $this->t2 = $t2;
        $this->bo = $bo;
        $this->start = $start;
        $this->note = $note;
    }

    /**
     * Execute the command.
     *
     * @param OrganizationRepositoryInterface $ori
     * @param TeamRepositoryInterface $tri
     * @param MatchRepositoryInterface $mri
     * @return array
     */
    public function handle(
        OrganizationRepositoryInterface $ori,
        TeamRepositoryInterface $tri,
        MatchRepositoryInterface $mri
    ) {
        $organization = $ori->findById($this->org_id);
        $team1 = $tri->getById($this->t1);
        $team2 = $tri->getById($this->t2);

        $mri->create($organization, $team1, $team2, $this->bo, $this->start, $this->note);

        return [$team1, $team2];
    }

}
