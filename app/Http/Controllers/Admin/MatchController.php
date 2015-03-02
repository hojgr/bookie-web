<?php namespace BookieGG\Http\Controllers\Admin;

use BookieGG\Contracts\Repositories\OrganizationRepositoryInterface;
use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use BookieGG\Http\Requests;
use BookieGG\Http\Controllers\Controller;

class MatchController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
		dd(\Input::all());
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
