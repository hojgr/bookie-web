<?php namespace BookieGG\Http\Controllers\Admin;

use BookieGG\Commands\CreateArticle;
use BookieGG\Commands\UpdateArticle;
use BookieGG\Http\Requests;
use BookieGG\Http\Controllers\Controller;

use BookieGG\Repositories\Eloquent\ArticleRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param ArticleRepository $ar
     * @return Response
     */
    public function index(ArticleRepository $ar)
    {
        return view('admin/article/index')->with('articles', $ar->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\AdminArticleCreate $article
     * @return Response
     */
    public function store(Requests\AdminArticleCreate $article)
    {
        $this->dispatch(new CreateArticle(\Auth::user(), \Input::get('title'), \Input::get('text')));

        return \Redirect::route('admin.article.index');
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
     * @param ArticleRepository $ar
     * @param  int $id
     * @return Response
     */
    public function edit(ArticleRepository $ar, $id)
    {
        return view('admin/article/edit')->with('articles', $ar->all())->with('article', $ar->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Requests\AdminArticleCreate $article
     * @param  int $id
     * @return Response
     */
    public function update(Requests\AdminArticleCreate $article, $id)
    {
        $this->dispatch(new UpdateArticle($id, \Input::get('title'), \Input::get('text')));

        return \Redirect::route('admin.article.index');
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
