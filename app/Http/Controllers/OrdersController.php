<?php

namespace App\Http\Controllers;
use App\User;
use App\Orders;
use App\Studios;
use App\Genres;
use App\Films;
use Session;
use Exception;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $order = Orders::query();
      $order->latest();
      if (request()->has("search") && strlen(request()->query("search")) >= 1) {
        $order->where(
          "orders.name", "like", "%" . request()->query("search") . "%"
        );
      }
      $counter = 1;
      $pagination = 5;
      $order = $order->paginate($pagination);
      if( request()->has('page') && request()->get('page') > 1){
        $counter += (request()->get('page')- 1) * $pagination;
      }

      $film =  Films::all();
      $user =  User::all();
      $genre =  Genres::all();
      $studio =  Studios::all();
      return view('order',
             compact('order',
                     'genre',
                     'film',
                     'studio',
                     'user',
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
            'user_id'        => 'required|numeric',
            'film_id'        => 'required|numeric',
            'qty'            => 'required',
      ]);

      $checkfilm = Films::where('id', $request->film_id)->first();
      $checkharga = Studios::where('id', $checkfilm->studio_id)->first();

      $checkquota = $checkharga->quota - $request->qty;

      if($checkquota <= 0){
        Session::flash('gagal', 'Quota Film Sudah Tidak Mencukupi');
      }
      else{
      $KurangiQuota = $checkquota;
      $dataStudio = Studios::find($checkfilm->studio_id);
      $dataStudio->quota = $KurangiQuota;
      $dataStudio->save();

      $response = new Orders($request->except("_token"));
      $response->total_price = ($request->qty * $checkharga->price);
      $response->save();
      }

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
      $user =  User::all();
      $film =  Films::all();
      $order = Orders::findOrFail($id);
      return view('order_detail',
             compact('film',
                     'genre',
                     'studio',
                     'user',
                     'order'
                    ));
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
      $checkorder = Orders::where('id', $id)->first();
      $checkfilm = Films::where('id', $checkorder->film_id)->first();
      $studiofilm = Studios::where('id', $checkfilm->studio_id)->first();
      $TambahQuota =  $checkorder->qty + $studiofilm->quota;

      $dataStudio = Studios::find($checkfilm->studio_id);
      $dataStudio->quota = $TambahQuota;
      $dataStudio->save();

      Orders::where('id',$id)->delete();
      Session::flash('sukses', 'Data Berhasil dihapus');
      return redirect()->back();
    }
}
