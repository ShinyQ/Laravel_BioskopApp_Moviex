@extends('base/template')

@section('konten')

      <div class="card">
         <div class="card-body">
           <form action="/order" method="post">
             @if (Session::has('sukses_tambah'))
                <div class="alert alert-success">
                    {{ Session::get('sukses_tambah') }}
                </div>
             @endif
             <div class="row">
               <div class="col-md-6">
                 @if($errors->has('user_id'))
                    <h5><strong><font color="red">{{ $errors->first('user_id')}}</font></strong></h5>
                 @endif
                 <div class="form-group">
                    <label for="inputText3" class="col-form-label">Pengguna :</label>
                    <select type="text" class="form-control" name="user_id">
                      <option>-- Pilih Genre --</option>
                      @foreach ($user as $data)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                      @endforeach
                    </select>
                 </div>
               </div>

               <div class="col-md-6">
                 @if($errors->has('film_id'))
                    <h5><strong><font color="red">{{ $errors->first('film_id')}}</font></strong></h5>
                 @endif
                 <div class="form-group">
                    <label for="inputText3" class="col-form-label">Film :</label>
                    <select type="text" class="form-control" name="film_id">
                      <option>-- Pilih Film --</option>
                      @foreach ($film as $data)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                      @endforeach
                    </select>
                 </div>
               </div>

               <div class="col-md-12">
                 @if($errors->has('qty'))
                    <h5><strong><font color="red">{{ $errors->first('qty')}}</font></strong></h5>
                 @endif
                 <div class="form-group">
                    <label for="inputText3" class="col-form-label">Jumlah :</label>
                      <input name="qty" type="number" class="form-control">
                 </div>
               </div>
            </div>
             {{ csrf_field() }}

              <input type="submit" class="btn btn-primary" value="Tambah Order" />
           </form>
         </div>
      </div>

      <div class="card">
         <div class="card-body">
           @if (Session::has('sukses'))
              <div class="alert alert-success">
                  {{ Session::get('sukses') }}
              </div>
           @endif
           @if(Session::has('gagal'))
             <div class="alert alert-danger">
                  {{ Session::get('gagal') }}
             </div>
           @endif
           <label for="inputText3" class="col-form-label">List Genre Order</label>

           <div class="row">
             <div class="col-md-3 pull-right">
               <form action="/order" method="GET">
                  <span class="pull-right">
                    <input type="text" name="search" class="form-control" placeholder="Search here..">
                  </span>
                </form>
             </div>
           </div><br />

               <table class="table table-striped">
                 <thead>
                     <tr>
                         <th scope="col">No</th>
                         <th scope="col">Nama User</th>
                         <th scope="col">Nama Film</th>
                         <th scope="col">Jumlah</th>
                         <th scope="col">Harga Satuan</th>
                         <th scope="col">Total</th>
                         <th scope="col">Action</th>
                     </tr>
                 </thead>
                 <tbody>
                    @foreach ($order as $item)
                      <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->film->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp{{ number_format($item->film->studio->price,2,',','.')}}</td>
                        <td>Rp{{ number_format( $item->total_price,2,',','.')}}</td>
                        <td>
                           <a class="btn btn-info" style="color:white!important" href="order/detail/{{ $item->id }}"><i class="fa fa-eye"></i></a>
                           <a class="btn btn-warning" style="color:white!important" href="/film/{{ $item->id }}"><i class="fa fa-edit"></i></a>
                           <a class="btn btn-danger" href="/order/delete/{{ $item->id }}"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                    @endforeach
                 </tbody>
             </table>
            </div>
          <div class="col-md-12" style="margin:0; text-align:center;">
              <center>
                  {!! $order->appends(request()->all())->links() !!}
              </center>
          </div>
         </div

@endsection
