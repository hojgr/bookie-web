<?php namespace BookieGG\Http\Controllers\Admin;

use BookieGG\Commands\CreateTeamCommand;
use BookieGG\Commands\EditTeamCommand;
use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use BookieGG\Http\Requests;
use BookieGG\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TeamController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @param TeamRepositoryInterface $tri
	 * @return Response
	 */
	public function index(TeamRepositoryInterface $tri)
	{
		return view('admin/team/index')->with('teams', $tri->getAll())
			->with('hide_right_side', true);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin/team/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Requests\TeamAddRequest $request
	 * @return Response
	 */
	public function store(Requests\TeamAddRequest $request)
	{
		$name = \Input::get('name');
		$shortname = \Input::get('shortname');
		$logo = \Input::file('logo');

		$this->dispatch(new CreateTeamCommand(
			$name,
			$shortname,
			$logo
		));

		\Session::flash('message',
			[['type' => 'success', 'message' => "Team <i>$name</i> was successfully created"]]);

		return \Redirect::route('admin.team.index');
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
	 * @param TeamRepositoryInterface $tri
	 * @param  int $id
	 * @return Response
	 */
	public function edit(TeamRepositoryInterface $tri, $id)
	{
		return view('admin/team/edit')->with('team', $tri->getById($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Requests\TeamEditRequest $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(Requests\TeamEditRequest $request, $id)
	{
		$name = \Input::get('name');
		$image = \Input::file('logo');

		$this->dispatch(new EditTeamCommand($id, $name, $image));

		\Session::flash('message',
			[['type' => 'success', 'message' => "Team <i>$name</i> was successfully edited"]]);

		return \Redirect::route('admin.team.index');
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
