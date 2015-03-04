<?php namespace BookieGG\Http\Controllers\Admin;

use BookieGG\Http\Requests\MatchEditRequest;
use BookieGG\Commands\CreateMatch;
use BookieGG\Commands\EditMatch;
use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use BookieGG\Contracts\Repositories\OrganizationRepositoryInterface;
use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use BookieGG\Http\Requests;
use BookieGG\Http\Controllers\Controller;
use BookieGG\Models\Match;
use BookieGG\Repositories\Eloquent\MatchRepository;

class MatchController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @param MatchRepositoryInterface $mri
	 * @return Response
	 */
	public function index(MatchRepositoryInterface $mri)
	{
		return view('admin/match/index')
			->with('matches', $mri->allDesc())
			->with('hide_right_side', true);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param OrganizationRepositoryInterface $ori
	 * @param TeamRepositoryInterface $tri
	 * @return Response
	 */
	public function create(OrganizationRepositoryInterface $ori, TeamRepositoryInterface $tri)
	{
		$organizers = $this->getRight($ori->getAll());
		$teams = $this->getRight($tri->getAll());
		array_unshift($organizers, 'None selected');
		array_unshift($teams, 'None selected');

		$_bos = [1, 3, 5];
		$bos = [];

		foreach($_bos as $b) {
			$bos[$b] = "BO$b";
		}

		return view('admin/match/create')
			->with('organizers', $organizers)
			->with('teams', $teams)
			->with('all_bos', $bos);
	}

	public function getRight($col) {
		$select = [];

		foreach($col as $o) {
			$select[$o->id] = $o->name;
		}

		return $select;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Requests\MatchCreateRequest $request
	 * @return Response
	 */
	public function store(Requests\MatchCreateRequest $request)
	{
		$all = \Input::all();

		list($t1, $t2) = $this->dispatch(
			new CreateMatch(
				$all['organizer'],
				$all['t1'],
				$all['t2'],
				$all['bo'],
				new \DateTime($all['start'])
			)
		);

		\Session::flash('message',
			[['type' => 'success', 'message' => "Match <b>{$t1->name}</b> vs. <b>{$t2->name}</b> was successfully created"]]);

		return \Redirect::route('admin.match.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param MatchRepositoryInterface $mri
	 * @param  int $id
	 * @return Response
	 */
	public function edit(MatchRepositoryInterface $mri, $id) {
		$_bos = [1, 3, 5];
		$bos = [];

		foreach($_bos as $b) {
			$bos[$b] = "BO$b";
		}

		return view('admin/match/edit')
			->with('match', $mri->find($id))
			->with('all_bos', $bos);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param MatchEditRequest $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(MatchEditRequest $request, $id)
	{
		$this->dispatch(
			new EditMatch($id, \Input::get('bo'), \Input::get('start'))
		);

		\Session::flash('message',
			[['type' => 'success', 'message' => "Match was successfully edited"]]);

		return \Redirect::route('admin.match.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	public function pickwinner($matchid, $tid) {
		// TODO: move it to repository :'(
		$match = Match::find($matchid);

		$match->winner_id = $tid;
		$match->status = Match::STATUS_FINISHED;

		$match->save();

		\Session::flash('message',
			[['type' => 'success', 'message' => "Winner was successfully picked"]]);

		return \Redirect::route('admin.match.index');
	}
}
