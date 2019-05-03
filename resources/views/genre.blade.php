@extends('base/template')

@section('konten')

  <div class="row">
    <div class="col-md-6">
      <div class="card">
         <div class="card-body">
           <form action="/genre" method="post">
             @if (Session::has('sukses_tambah'))
                <div class="alert alert-success">
                    {{ Session::get('sukses_tambah') }}
                </div>
             @endif

              @if($errors->has('name'))
                  <h5><strong><font color="red">{{ $errors->first('name')}}</font></strong></h5>
              @endif
             <div class="form-group">
                <label for="inputText3" class="col-form-label">Nama Genre :</label>
                <input name="name" type="text" class="form-control">
            </div>
               {{ csrf_field() }}
              <input type="submit" class="btn btn-primary" value="Tambah Genre" />
           </form>
         </div>
      </div>
    </div>

    <div class="col-md-6">
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
               <table class="table table-striped">
                 <thead>
                     <tr>
                         <th scope="col">No</th>
                         <th scope="col">Nama Genre</th>
                         <th scope="col">Aksi</th
                     </tr>
                 </thead>
                 <tbody>
                    @foreach ($genre as $item)
                      <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        <td>{{ $item->name }}</td>
                        <td>
                           <a class="btn btn-warning" style="color:white!important" href="/genre/{{ $item->id }}"><i class="fa fa-edit"></i></a>
                           <a class="btn btn-danger" href="/genre/delete/{{ $item->id }}"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                    @endforeach
                 </tbody>
             </table>
            </div>
         </div>
    </div>
  </div>

@endsection
