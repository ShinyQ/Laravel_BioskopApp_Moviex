@extends('base/template')

@section('konten')

      <div class="card">
         <div class="card-body">
           @if (Session::has('sukses'))
              <div class="alert alert-success">
                  {{ Session::get('sukses') }}
              </div>
           @endif
           <form action="/genre/{{ $genre->id }}" method="post">
             <table class="table table-bordered">
               @if($errors->has('name'))
                  <div style="padding-left:10px">
                    <h5><strong><font color="red">{{ $errors->first('category')}}</font></strong></h5>
                  </div>
                @endif
                <tr>
                   <td>Id Genre</td>
                   <td>:</td>
                   <td><input type="text" value="{{ $genre->id }}" class="form-control" disabled /></td>
                 </tr>
                 <br />
                <tr>
                   <td>Nama Genre</td>
                   <td>:</td>
                   <td><input type="text" name="name" value="{{ $genre->name }}" class="form-control" ></td>
                </tr>

                <input type="hidden" name="_method" value="PUT">
                 {{ csrf_field() }}
               </table>
               <br />
               <a class="btn btn-primary" href="/genre">Kembali</a> <input type="submit" class="btn btn-warning" style="color:white;" value="Edit Data" />
            </form>
         </div>
      </div>
    </div>

@endsection
