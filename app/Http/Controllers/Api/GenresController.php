<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Genres;
use Exception;
use ApiBuilder;

class GenresController extends Controller
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
        $response = Genres::query()->latest();
        if (request()->has("search") && strlen(request()->query("search")) >= 1) {
          $response->where(
            "genres.name", "like", "%" . request()->query("search") . "%"
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
     * @param  \Illuminate\Http\Request  $response
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
          $this->validate($request, [
                'name'        => 'required',
          ]);

          $code= "200";
          $response = new Genres($request->except("_token"));
          $response->save();

        } catch (\Exception $e) {
          if($e instanceof ValidationException){
            $response = $e->errors();
            $code = 400;
          }
          else{
            $code= "500";
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
        $response = Genres::findOrFail($id);
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
     * @param  \Illuminate\Http\Request  $response
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      try {
        $this->validate($request, [
              'name'        => 'required',
        ]);

        $code= "200";
        $response = Genres::findOrFail($id);
        $response->name = $request->name;
        $response->save();

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
          $code= "500";
          $response = "An Error Has Ocurred";
        }
      }
      return ApiBuilder::apiRespond($code, $response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
          Genres::where('id',$id)->delete();
          $response = "Success Delete";
          $code = 200;
        } catch (\Exception $e) {
          $code= "500";
          $response = "An Error Has Ocurred";
        }
        return ApiBuilder::apiRespond($code, $response);
    }
}
