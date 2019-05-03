<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Genres;
use Session;

class GenresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genre = Genres::query();
        $genre->latest();
        if (request()->has("search") && strlen(request()->query("search")) >= 1) {
          $genre->where(
            "genres.name", "like", "%" . request()->query("search") . "%"
          );
        }
        $counter = 1;
        $pagination = 5;
        $genre = $genre->paginate($pagination);
        if( request()->has('page') && request()->get('page') > 1){
          $counter += (request()->get('page')- 1) * $pagination;
        }

        $counter = 1;
        return view('genre',
               compact('genre',
                       'counter'
               ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
            'name'        => 'required',
      ]);
      $genre = new Genres($request->except("_token"));
      $genre->save();
      Session::flash('sukses_tambah', 'Data Berhasil Ditambahkan');
      return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $genre = Genres::findOrFail($id);
      return view('genre_edit',
             compact('genre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, [
            'name'        => 'required',
      ]);
      $genre = Genres::findOrFail($id);
      $genre->name = $request->name;
      $genre->save();
      Session::flash('sukses', 'Data Berhasil Di Edit');
      return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Genres::where('id',$id)->delete();
        Session::flash('sukses', 'Data Berhasil dihapus');
        return redirect()->back();
    }
}
