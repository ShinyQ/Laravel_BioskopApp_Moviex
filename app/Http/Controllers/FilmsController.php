<?php

namespace App\Http\Controllers;

use App\Films;
use App\Genres;
use App\Studios;
use Session;
use Illuminate\Http\Request;

class FilmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $counter = 1;
      $genre =  Genres::all();
      $studio =  Studios::all();
      $film = Films::all();
      return view('film',
             compact('film',
                     'genre',
                     'studio',
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
        //
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
          'deskripsi'        => 'required',
          'genre_id'        => 'required',
          'studio_id'        => 'required',
          'start_at'        => 'required',
          'end_at'        => 'required',
      ]);
      $film = new Films($request->except("_token"));
      $film->save();
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
      $genre =  Genres::all();
      $studio =  Studios::all();
      $film = Films::findOrFail($id);
      return view('film_edit',
             compact('film','genre','studio'));
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
          'deskripsi'        => 'required',
          'genre_id'        => 'required',
          'start_at'        => 'required',
          'end_at'        => 'required',
          'studio_id'        => 'required',
      ]);
      $film = Films::findOrFail($id);
      $film->name = $request->name;
      $film->deskripsi = $request->deskripsi;
      $film->genre_id = $request->genre_id;
      $film->studio_id = $request->studio_id;
      $film->start_at = $request->start_at;
      $film->end_at = $request->end_at;
      $film->save();
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
      Films::where('id',$id)->delete();
      Session::flash('sukses', 'Data Berhasil dihapus');
      return redirect()->back();
    }
}
