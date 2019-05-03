<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Orders;
use App\Films;
use App\Genres;
use App\Studios;
use ApiBuilder;

class OrderController extends Controller
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
        $response = Orders::query()->with('user','film',)->latest();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try {
        $this->validate($request, [
              'user_id'        => 'required|numeric',
              'film_id'        => 'required|numeric',
              'qty'            => 'required',
        ]);

        $checkfilm = Films::where('id', $request->film_id)->first();
        $checkharga = Studios::where('id', $checkfilm->studio_id)->first();

        $checkquota = $checkharga->quota - $request->qty;
        if($checkquota <= 0){
          $code= 402;
          $response = "Quota Tidak Mencukupi";
        }

        else{
          $order = Orders::all();
          $checkOrder = Orders::where('user_id', $request->user_id)->where('film_id', $request->film_id)->first();
          if($checkOrder){
            $response = Orders::find($checkOrder->id);
            $response->qty = $response->qty + $request->qty;

            $response->save();

            $KurangiQuota = $checkquota;
            $dataStudio = Studios::find($checkfilm->studio_id);
            $dataStudio->quota = $KurangiQuota;
            $dataStudio->save();
            $code = 200;
          }

          else{
            $KurangiQuota = $checkquota;
            $dataStudio = Studios::find($checkfilm->studio_id);
            $dataStudio->quota = $KurangiQuota;
            $dataStudio->save();

            $response = new Orders($request->except("_token"));
            $response->total_price = ($request->qty * $checkharga->price);
            $response->save();

            $code = 200;
          }
        }

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try {
        $code= "200";
        $response = Orders::with('film','user')->findOrFail($id);
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
