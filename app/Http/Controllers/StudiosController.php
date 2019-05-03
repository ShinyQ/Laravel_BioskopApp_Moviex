<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Studios;
use App\Genres;
use Session;
use Illuminate\Support\Facades\DB;

class StudiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $studio = Studios::query();
      $studio->latest();
      if (request()->has("search") && strlen(request()->query("search")) >= 1) {
        $studio->where(
          "studios.name", "like", "%" . request()->query("search") . "%"
        );
      }
      $counter = 1;
      $pagination = 5;
      $studio = $studio->paginate($pagination);
      if( request()->has('page') && request()->get('page') > 1){
        $counter += (request()->get('page')- 1) * $pagination;
      }

      return view('studio',
             compact('studio',
                     'counter',
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
          'quota'        => 'required',
          'price'        => 'required',
      ]);
      $studio = new Studios($request->except("_token"));
      $studio->save();
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
      $studio = Studios::findOrFail($id);
      return view('studio_edit',
             compact('studio',));
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
          'quota'        => 'required',
          'price'        => 'required',
      ]);
      $studio = Studios::findOrFail($id);
      $studio->name = $request->name;
      $studio->quota = $request->quota;
      $studio->price = $request->price;
      $studio->save();
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
      Studios::where('id',$id)->delete();
      Session::flash('sukses', 'Data Berhasil dihapus');
      return redirect()->back();
    }
}
