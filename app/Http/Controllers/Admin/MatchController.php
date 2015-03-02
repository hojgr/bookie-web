<?php namespace BookieGG\Http\Controllers\Admin;

use BookieGG\Commands\CreateMatch;
use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use BookieGG\Contracts\Repositories\OrganizationRepositoryInterface;
use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use BookieGG\Http\Requests;
use BookieGG\Http\Controllers\Controller;
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

		return view('admin/match/create')
			->with('organizers', $organizers)
			->with('teams', $teams)
			->with('all_bos', array_map(function($e) { return "BO$e"; }, [1, 3, 5, 7, 9, 11]));
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
			[['type' => 'success', 'message' => "Match <b>{$t1->name}</b> vs. <b>{$t2->name}</b> was successfully edited"]]);

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
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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

}
