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
           <form action="/film/{{ $film->id }}" method="post">
             <table class="table table-bordered">
                <tr>
                   <td>Id Film</td>
                   <td>:</td>
                   <td><input type="text" value="{{ $film->id }}" class="form-control" disabled /></td>
                 </tr>
                 <br />
                <tr>
                   <td>Nama Film</td>
                   <td>:</td>
                   <td><input type="text" name="name" value="{{ $film->name }}" class="form-control" ></td>
                </tr>

                <tr>
                   <td>Deskripsi Film</td>
                   <td>:</td>
                   <td><input type="text" name="deskripsi" value="{{ $film->deskripsi }}" class="form-control" ></td>
                </tr>

                <tr>
                   <td>Genre Film</td>
                   <td>:</td>
                   <td>
                     <select id="genre_id" type="text" class="form-control" name="genre_id">
                       <option>-- Pilih Genre --</option>
                       @foreach ($genre as $data)
                         <option value="{{ $data->id }}">{{ $data->name }}</option>
                       @endforeach
                    </select>
                  </td>
                </tr>

                <tr>
                   <td>Studio</td>
                   <td>:</td>
                   <td>
                     <select id="studio_id" type="text" class="form-control" name="studio_id">
                       <option>-- Pilih Studio --</option>
                       @foreach ($studio as $data)
                         <option value="{{ $data->id }}">{{ $data->name }}</option>
                       @endforeach
                     </select>
                  </td>
                </tr>

                <tr>
                   <td>Deskripsi Film</td>
                   <td>:</td>
                   <td><input type="time" name="start_at" value="{{ $film->start_at }}" class="form-control" ></td>
                </tr>

                <tr>
                   <td>Deskripsi Film</td>
                   <td>:</td>
                   <td><input type="time" name="end_at" value="{{ $film->end_at }}" class="form-control" ></td>
                </tr>

                <input type="hidden" name="_method" value="PUT">
                 {{ csrf_field() }}
               </table>
               <br />
               <a class="btn btn-primary" href="/film">Kembali</a> <input type="submit" class="btn btn-warning" style="color:white;" value="Edit Data" />
            </form>
         </div>
      </div>

      <script type="text/javascript">
        $('#genre_id').val("{{$film->genre_id}}");
        $('#studio_id').val("{{$film->studio_id}}");
      </script>

@endsection
