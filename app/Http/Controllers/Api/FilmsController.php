<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $response = Films::query()->latest();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
