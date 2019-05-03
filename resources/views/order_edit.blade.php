@extends('base/template')

@section('konten')

      <div class="card">
         <div class="card-body">
           <form class="" action="/order/{{ $order->id }}" method="post">
             <table class="table table-bordered">
                <tr>
                  <input type=hidden name="film_id" value="{{ $order->film_id }}"/>
                  <input type=hidden name="user_id" value="{{ $order->user_id }}"/>

                   <td>Id Order</td>
                   <td>:</td>
                   <td><input type="text" disabled value="{{ $order->id }}" class="form-control"  /></td>

                 </tr>
                 <br />
                <tr>
                   <td>User</td>
                   <td>:</td>
                   <td>
                     <select disabled id="user_id" type="text" class="form-control" name="genre_id">
                       <option>-- Pilih User --</option>
                       @foreach ($user as $data)
                         <option value="{{ $data->id }}">{{ $data->name }}</option>
                       @endforeach
                    </select>
                   </td>
                </tr>

                <tr>
                   <td>Film</td>
                   <td>:</td>
                   <td>
                     <select disabled id="film_id" type="text" class="form-control" name="genre_id">
                       <option>-- Pilih Film --</option>
                       @foreach ($film as $data)
                         <option value="{{ $data->id }}">{{ $data->name }}</option>
                       @endforeach
                    </select>
                   </td>
                </tr>

                <tr>
                   <td>Jumlah</td>
                   <td>:</td>
                   <td><input type="text"  name="qty" value="{{ $order->qty }}" class="form-control" ></td>
                </tr>

                <tr>
                   <td>Total</td>
                   <td>:</td>
                   <td><input type="text" disabled value="Rp{{ number_format( $order->total_price,2,',','.')}}" class="form-control" ></td>
                </tr>

                <input type="hidden" name="_method" value="PUT">
                 {{ csrf_field() }}

               </table>
               <br />
               <a class="btn btn-primary" href="/order">Kembali</a> <input type="submit" class="btn btn-warning" style="color:white;" value="Edit Data" />
            </form>
            </form>
         </div>
      </div>
    </div>

    <script type="text/javascript">
      $('#film_id').val("{{$order->film_id}}");
      $('#user_id').val("{{$order->user_id}}");
    </script>
@endsection
