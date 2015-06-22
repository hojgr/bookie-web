<?php namespace BookieGG\Http\Controllers\Admin;

use BookieGG\Commands\CreateOrganizationCommand;
use BookieGG\Commands\EditOrganizationCommand;
use BookieGG\Contracts\Repositories\OrganizationRepositoryInterface;
use BookieGG\Http\Requests;
use BookieGG\Http\Controllers\Controller;

use Illuminate\Http\Request;

class OrganizationController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param OrganizationRepositoryInterface $ori
     * @return Response
     */
    public function index(OrganizationRepositoryInterface $ori)
    {
        return view('admin/organization/index')->with('organizations', $ori->getAll())
            ->with('hide_right_side', true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin/organization/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\OrganizationAddRequest $request
     * @return Response
     */
    public function store(Requests\OrganizationAddRequest $request)
    {
        $name = \Input::get('name');

        $this->dispatch(new CreateOrganizationCommand(
            $name,
            \Input::get('url'),
            \Input::file('logo')
        ));

        \Session::flash('message',
            [['type' => 'success', 'message' => "Organization <i>$name</i> was successfully created"]]);

        return \Redirect::route('admin.organization.index');
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
     * @param OrganizationRepositoryInterface $ori
     * @param  int $id
     * @return Response
     */
    public function edit(OrganizationRepositoryInterface $ori, $id)
    {
        return view('admin/organization/edit')
            ->with('organization', $ori->findById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Requests\OrganizationEditRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(Requests\OrganizationEditRequest $request, $id)
    {
        $name = \Input::get('name');
        $this->dispatch(new EditOrganizationCommand(
            $id,
            $name,
            \Input::get('url'),
            \Input::file('logo')
        ));

        \Session::flash('message',
            [['type' => 'success', 'message' => "Organization <i>$name</i> was successfully edited"]]);

        return \Redirect::route('admin.organization.index');
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
