<?php

namespace App\Http\Controllers;
use App\User;
use App\Orders;
use App\Studios;
use App\Genres;
use App\Films;
use Session;
use Exception;
use Illuminate\Support\Facades\DB;
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
        $order = Orders::all();
        $checkOrder = Orders::where('user_id', $request->user_id)->where('film_id', $request->film_id)->first();
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

          Session::flash('sukses', 'Sukses Menambahkan Order');
        }

        else{
          $KurangiQuota = $checkquota;
          $dataStudio = Studios::find($checkfilm->studio_id);
          $dataStudio->quota = $KurangiQuota;
          $dataStudio->save();

          $response = new Orders($request->except("_token"));
          $response->total_price = ($request->qty * $checkharga->price);
          $response->save();

          Session::flash('sukses', 'Sukses Menambahkan Order Baru');
        }
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
      $genre =  Genres::all();
      $studio =  Studios::all();
      $user =  User::all();
      $film =  Films::all();
      $order = Orders::findOrFail($id);
      return view('order_edit',
             compact('film',
                     'genre',
                     'studio',
                     'user',
                     'order'
                    ));
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

        $order = Orders::findOrFail($id);
        $order->qty = $request->qty;
        $order->total_price = $dataStudio * $order->qty;
        $order->save();
        Session::flash('Sukses', 'Jumlah Order Berhasil Diubah');
      }
      elseif($checkquotasekarang->qty > $request->qty){
        $checkquota = $checkharga->quota - $request->qty;
        if($checkquota <= 0){
          Session::flash('gagal', 'Quota Film Sudah Tidak Mencukupi');
        }
        else{
          $TambahQuota =  $checkquotasekarang->qty - $request->qty;
          $dataStudio = Studios::find($checkfilm->studio_id);
          $dataStudio->quota = $dataStudio->quota + $TambahQuota;
          $dataStudio->save();

          $order = Orders::findOrFail($id);
          $order->qty = $request->qty;
          $order->total_price = $dataStudio->price * $request->qty;
          $order->save();

          Session::flash('Sukses', 'Jumlah Order Berhasil Diubah');
        }
      }

      else{
        $order = Orders::findOrFail($id);
        $order->qty = $request->qty;
        $order->save();
        Session::flash('Sukses', 'Quota Film Berhasil Diubah');
      }
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
