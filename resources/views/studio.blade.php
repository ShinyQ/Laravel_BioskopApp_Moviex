@extends('base/template')

@section('konten')

      <div class="card">
         <div class="card-body">
           <form action="/studio" method="post">
             @if (Session::has('sukses_tambah'))
                <div class="alert alert-success">
                    {{ Session::get('sukses_tambah') }}
                </div>
             @endif

             @if($errors->has('name'))
                <h5><strong><font color="red">{{ $errors->first('name')}}</font></strong></h5>
             @endif
             <div class="form-group">
                <label for="inputText3" class="col-form-label">Nama Studio :</label>
                <input name="name" type="text" class="form-control">
             </div>

             @if($errors->has('quota'))
                <h5><strong><font color="red">{{ $errors->first('quota')}}</font></strong></h5>
             @endif
             <div class="form-group">
                <label for="inputText3" class="col-form-label">Quota Studio :</label>
                <input name="quota" type="number" class="form-control">
             </div>

             @if($errors->has('price'))
                <h5><strong><font color="red">{{ $errors->first('price')}}</font></strong></h5>
             @endif
             <div class="form-group">
                <label for="inputText3" class="col-form-label">Price Studio :</label>
                <input name="price" type="number" class="form-control">
             </div>

             {{ csrf_field() }}

              <input type="submit" class="btn btn-primary" value="Tambah Studio" />
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
               <table class="table table-striped">
                 <thead>
                     <tr>
                         <th scope="col">No</th>
                         <th scope="col">Nama Studio</th>
                         <th scope="col">Quota Studio</th>
                         <th scope="col">Price Studio</th>
                         <th scope="col">Aksi</th
                     </tr>
                 </thead>
                 <tbody>
                    @foreach ($studio as $item)
                      <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quota }}</td>
                        <td>Rp{{ number_format($item->price,2,',','.')}}</td>
                        <td>
                           <a class="btn btn-warning" style="color:white!important" href="/studio/{{ $item->id }}"><i class="fa fa-edit"></i></a>
                           <a class="btn btn-danger" href="/studio/delete/{{ $item->id }}"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                    @endforeach
                 </tbody>
             </table>
            </div>
         </div

@endsection
