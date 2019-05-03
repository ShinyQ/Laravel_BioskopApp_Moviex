@extends('base/template')

@section('konten')

      <div class="card">
         <div class="card-body">

             <table class="table table-bordered">
                <tr>
                   <td>Id Order</td>
                   <td>:</td>
                   <td><input type="text" value="{{ $order->id }}" class="form-control" disabled /></td>
                 </tr>
                 <br />
                <tr>
                   <td>Nama User</td>
                   <td>:</td>
                   <td><input type="text" disabled name="name" value="{{ $order->user->name }}" class="form-control" ></td>
                </tr>

                <tr>
                   <td>Nama Film</td>
                   <td>:</td>
                   <td><input type="text" disabled name="quota" value="{{ $order->film->name }}" class="form-control" ></td>
                </tr>

                <tr>
                   <td>Studio</td>
                   <td>:</td>
                   <td><input type="text" disabled name="quota" value="{{ $order->film->studio->name }}" class="form-control" ></td>
                </tr>
                <?php  $jadwal = $order->film->start_at ?>
                <tr>
                   <td>Jadwal Tayang</td>
                   <td>:</td>
                   <td><input type="text" disabled name="quota" value="{{  date('H:i',strtotime($jadwal)) }}" class="form-control" ></td>
                </tr>

                <tr>
                   <td>Jumlah</td>
                   <td>:</td>
                   <td><input type="text" disabled name="quota" value="{{ $order->qty }}" class="form-control" ></td>
                </tr>

                <tr>
                   <td>Total</td>
                   <td>:</td>
                   <td><input type="text" disabled name="quota" value="Rp{{ number_format( $order->total_price,2,',','.')}}" class="form-control" ></td>
                </tr>


               </table>
               <br />
               <a class="btn btn-primary" href="/order">Kembali</a>
            </form>
         </div>
      </div>
    </div>

@endsection
