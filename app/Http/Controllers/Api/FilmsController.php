<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Genres;
use Exception;
use App\Films;
use ApiBuilder;

class FilmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try {
        $code = 200;
        $counter = 1;
        $response = Films::query()->with('genre','studio')->latest();
        if (request()->has("search") && strlen(request()->query("search")) >= 1) {
          $response->where(
            "films.name", "like", "%" . request()->query("search") . "%"
        );}

        $pagination = 5;
        $response = $response->paginate($pagination);

      } catch (\Exception $e) {
        $code = 500;
        $response = "An Error Has Ocurred";
      }

      return ApiBuilder::apiRespond($code, $response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try {
        $this->validate($request, [
            'name'        => 'required',
            'deskripsi'        => 'required',
            'genre_id'        => 'required',
            'studio_id'        => 'required',
            'start_at'        => 'required',
            'end_at'        => 'required',
        ]);
        $response = new Films($request->except("_token"));
        $response->save();
        $code = 200;
      } catch (\Exception $e) {
        if($e instanceof ValidationException){
          $response = $e->errors();
          $code = 400;
        }
        else{
          $code= 500;
          $response = "An Error Has Ocurred";
        }
      }
      return ApiBuilder::apiRespond($code, $response);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try {
        $code= "200";
        $response = Films::with('genre','studio')->findOrFail($id);
      } catch (\Exception $e) {
        if($e instanceof ValidationException){
          $response = $e->errors();
          $code = 400;
        }
        elseif($e instanceof ModelNotFoundException){
          $code= 404;
          $response = "Data Not Exist";
        }
        else{
          $code= 500;
          $response = "An Error Has Ocurred";
        }
      }
      return ApiBuilder::apiRespond($code, $response);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
