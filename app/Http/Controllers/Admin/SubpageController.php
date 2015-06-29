<?php namespace BookieGG\Http\Controllers\Admin;

use BookieGG\Commands\CreateSubpageCommand;
use BookieGG\Commands\UpdateSubpageCommand;
use BookieGG\Contracts\Repositories\SubpageRepositoryInterface;
use BookieGG\Http\Requests;
use BookieGG\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SubpageController extends Controller {

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
     * @param SubpageRepositoryInterface $sri
     * @return Response
     */
    public function create(SubpageRepositoryInterface $sri)
    {
        return view('admin/subpage/create')
            ->with('subpages', $sri->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\AddSubpageRequest $request
     * @return Response
     */
    public function store(Requests\AddSubpageRequest $request)
    {
        $this->dispatch(
            new CreateSubpageCommand(\Input::get('name'), \Input::get('content'))
        );

        \Session::flash('message',
            [['type' => 'success', 'message' => "Subpage ". \Input::get('name') . " was successfully created"]]);

        return \Redirect::route('admin.subpage.create');
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
     * @param SubpageRepositoryInterface $sri
     * @param  int $id
     * @return Response
     */
    public function edit(SubpageRepositoryInterface $sri, $id)
    {
        return view('admin/subpage/edit')
            ->with('subpage', $sri->find($id))
            ->with('subpages', $sri->getAll());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $this->dispatch(
            new UpdateSubpageCommand($id, \Input::get('name'), \Input::get('content'))
        );

        \Session::flash('message',
            [['type' => 'success', 'message' => "Subpage ". \Input::get('name') . " was successfully edited"]]);

        return \Redirect::route('admin.subpage.create');
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
