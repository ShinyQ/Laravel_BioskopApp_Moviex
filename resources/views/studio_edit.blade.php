@extends('base/template')

@section('konten')

      <div class="card">
         <div class="card-body">
           @if (Session::has('sukses'))
              <div class="alert alert-success">
                  {{ Session::get('sukses') }}
              </div>
           @endif

           @if($errors->has('name'))
              <h5><strong><font color="red">{{ $errors->first('name')}}</font></strong></h5>
           @endif

           @if($errors->has('quota'))
              <h5><strong><font color="red">{{ $errors->first('quota')}}</font></strong></h5>
           @endif

           @if($errors->has('price'))
              <h5><strong><font color="red">{{ $errors->first('price')}}</font></strong></h5>
           @endif
           <form action="/studio/{{ $studio->id }}" method="post">
             <table class="table table-bordered">
                <tr>
                   <td>Id Studios</td>
                   <td>:</td>
                   <td><input type="text" value="{{ $studio->id }}" class="form-control" disabled /></td>
                 </tr>
                 <br />
                <tr>
                   <td>Nama Studio</td>
                   <td>:</td>
                   <td><input type="text" name="name" value="{{ $studio->name }}" class="form-control" ></td>
                </tr>

                <tr>
                   <td>Quota Studio</td>
                   <td>:</td>
                   <td><input type="text" name="quota" value="{{ $studio->quota }}" class="form-control" ></td>
                </tr>

                <tr>
                   <td>Price Studio</td>
                   <td>:</td>
                   <td><input type="text" name="price" value="{{ $studio->price }}" class="form-control" ></td>
                </tr>

                <input type="hidden" name="_method" value="PUT">
                 {{ csrf_field() }}
               </table>
               <br />
               <a class="btn btn-primary" href="/studio">Kembali</a> <input type="submit" class="btn btn-warning" style="color:white;" value="Edit Data" />
            </form>
         </div>
      </div>
    </div>

@endsection
