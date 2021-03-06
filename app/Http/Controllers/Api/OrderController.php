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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
              "users.name", "like", "%" . request()->query("search") . "%"
          );
          $pagination = 5;
          $response = $response->paginate($pagination);
        }

        elseif(request()->has("name") && strlen(request()->query("name")) >= 1) {
            $response = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'users.name')->where(
              "users.name", "like", "%" . request()->query("name") . "%"
          )->get();
        }
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
      try{
      $this->validate($request, [
            'film_id'        => 'required|numeric',
            'qty'            => 'required',
      ]);

      $checkfilm = Films::where('id', $request->film_id)->first();
      $checkharga = Studios::where('id', $checkfilm->studio_id)->first();

      $checkquota = $checkharga->quota - $request->qty;

      if($checkquota <= 0){
        $code= 402;
        $response = "Quota Sudah Penuh";
      }

      else{
        $order = Orders::all();
        $checkOrder = Orders::where('user_id', Auth::user()->id)->where('film_id', $request->film_id)->first();
        if($checkOrder){
          $ubahqty = $checkOrder->qty + $request->qty;
          $response = Orders::find($checkOrder->id);
          $response->qty = $ubahqty;
          $response->total_price = $ubahqty * $checkharga->price;
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
          $response->user_id = Auth::user()->id;
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
        try {
          $this->validate($request, [
                'qty'            => 'required',
          ]);
          $checkfilm = Films::where('id', $request->film_id)->first();
          $checkharga = Studios::where('id', $checkfilm->studio_id)->first();
          $checkquotasekarang = Orders::findOrFail($id);

          if($checkquotasekarang->qty < $request->qty){
            $KurangiQuota =  $request->qty - $checkquotasekarang->qty;
            $dataStudio = Studios::find($checkfilm->studio_id);
            $dataStudio->quota = $dataStudio->quota - $KurangiQuota;
            $dataStudio->save();

            $response = Orders::findOrFail($id);
            $response ->qty = $request->qty;
            $response ->save();
            Session::flash('Sukses', 'Jumlah Order Berhasil Diubah');
          }
          elseif($checkquotasekarang->qty > $request->qty){
            if($checkquota <= 0){
              $code = 402;
              $response = "Quota Tidak Mencukupi";
            }
            else{
              $TambahQuota =  $checkquotasekarang->qty - $request->qty;
              $dataStudio = Studios::find($checkfilm->studio_id);
              $dataStudio->quota = $dataStudio->quota + $TambahQuota;
              $dataStudio->save();

              $response = Orders::findOrFail($id);
              $response->qty = $request->qty;
              $response->save();

              $code = 200;
            }
          }

          else{
            $response = Orders::findOrFail($id);
            $response->qty = $request->qty;
            $response->save();
            $code = 200;
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
        $checkorder = Orders::where('id', $id)->first();
        $checkfilm = Films::where('id', $checkorder->film_id)->first();
        $studiofilm = Studios::where('id', $checkfilm->studio_id)->first();
        $TambahQuota =  $checkorder->qty + $studiofilm->quota;

        $dataStudio = Studios::find($checkfilm->studio_id);
        $dataStudio->quota = $TambahQuota;
        $dataStudio->save();
        $code = 200;
        Orders::where('id',$id)->delete();
      } catch (\Exception $e) {
          $code= 500;
          $response = "An Error Has Ocurred";
      }


    }
}
