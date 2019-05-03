@extends('base/template')

@section('konten')

      <div class="card">
         <div class="card-body">
           <form action="/film" method="post">
             @if (Session::has('sukses_tambah'))
                <div class="alert alert-success">
                    {{ Session::get('sukses_tambah') }}
                </div>
             @endif
             <div class="row">
               <div class="col-md-6">
                 @if($errors->has('name'))
                    <h5><strong><font color="red">{{ $errors->first('name')}}</font></strong></h5>
                 @endif
                 <div class="form-group">
                    <label for="inputText3" class="col-form-label">Nama Film :</label>
                    <input name="name" type="text" class="form-control">
                 </div>
               </div>

               <div class="col-md-6">
                 @if($errors->has('deskripsi'))
                    <h5><strong><font color="red">{{ $errors->first('deskripsi')}}</font></strong></h5>
                 @endif
                 <div class="form-group">
                    <label for="inputText3" class="col-form-label">Deskripsi Film :</label>
                    <input name="deskripsi" type="text" class="form-control">
                 </div>
               </div>

               <div class="col-md-6">
                 @if($errors->has('genre_id'))
                    <h5><strong><font color="red">{{ $errors->first('genre_id')}}</font></strong></h5>
                 @endif
                 <div class="form-group">
                    <label for="inputText3" class="col-form-label">Genre :</label>
                    <select type="text" class="form-control" name="genre_id">
                      <option>-- Pilih Genre --</option>
                      @foreach ($genre as $data)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                      @endforeach
                    </select>
                 </div>
               </div>

               <div class="col-md-6">
                 @if($errors->has('studio_id'))
                    <h5><strong><font color="red">{{ $errors->first('studio_id')}}</font></strong></h5>
                 @endif
                 <div class="form-group">
                    <label for="inputText3" class="col-form-label">Studio :</label>
                    <select type="text" class="form-control" name="studio_id">
                      <option>-- Pilih Studio --</option>
                      @foreach ($studio as $data)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                      @endforeach
                    </select>
                 </div>
               </div>

               <div class="col-md-6">
                 @if($errors->has('start_at'))
                    <h5><strong><font color="red">{{ $errors->first('start_at')}}</font></strong></h5>
                 @endif
                 <div class="form-group">
                    <label for="inputText3" class="col-form-label">Waktu Mulai :</label>
                    <input name="start_at" type="time" class="form-control">
                 </div>
               </div>

               <div class="col-md-6">
                 @if($errors->has('end_at'))
                    <h5><strong><font color="red">{{ $errors->first('end_at')}}</font></strong></h5>
                 @endif
                 <div class="form-group">
                    <label for="inputText3" class="col-form-label">Waktu Selesai :</label>
                    <input name="end_at" type="time" class="form-control">
                 </div>
               </div>

            </div>
             {{ csrf_field() }}

              <input type="submit" class="btn btn-primary" value="Tambah Film" />
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
           <label for="inputText3" class="col-form-label">List Genre Film</label>

           <div class="row">
             <div class="col-md-3 pull-right">
               <form action="/film" method="GET">
                  <span class="pull-right">
                    <input type="text" name="search" class="form-control" placeholder="Search here ..">
                  </span>
                </form>
             </div>
           </div><br />

               <table class="table table-striped">
                 <thead>
                     <tr>
                         <th scope="col">No</th>
                         <th scope="col">Nama Film</th>
                         <th scope="col">Deskripsi Film</th>
                         <th scope="col">Genre</th>
                         <th scope="col">Studio</th>
                         <th scope="col">Waktu Mulai</th>
                         <th scope="col">Waktu Selesai</th>
                         <th scope="col">Action</th>
                     </tr>
                 </thead>
                 <tbody>
                    @foreach ($film as $item)
                      <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>{{ $item->genre->name }}</td>
                        <td>{{ $item->studio->name }}</td>
                        <td>{{ $item->start_at }}</td>
                        <td>{{ $item->end_at }}</td>
                        <td>
                           <a class="btn btn-warning" style="color:white!important" href="/film/{{ $item->id }}"><i class="fa fa-edit"></i></a>
                           <a class="btn btn-danger" href="/film/delete/{{ $item->id }}"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                    @endforeach
                 </tbody>
             </table>
            </div>
          <div class="col-md-12" style="margin:0; text-align:center;">
              <center>
                  {!! $film->appends(request()->all())->links() !!}
              </center>
          </div>
         </div

@endsection
