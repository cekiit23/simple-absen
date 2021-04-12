@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $info['status'] }}</div>

                <div class="panel-body">
                 <form action="/absen" method="post">
                    {{ csrf_field() }}

                    <table class="table table-responsive"> 
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="note" id="note" placeholder="Keterangan.....">
                            </td>
                        
                            <td>
                                <button type="submit" name="masuk" value="0" class="btn btn-primary" {{ $info['masuk'] }} onclick="alert('berhasil absen masuk')">Masuk</button>
                            </td>
                            <td>
                                <button type="submit" name="keluar" value="0" class="btn btn-warning" {{ $info['keluar'] }} onclick="alert('berhasil absen pulang')">Pulang</button>
                            </td>
                        </tr>
                    </table>
                </form>
                    
                </div> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Riwayat Absensi</div>

                <div class="panel-body">
                    

                    <table class="table table-responsive table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($data_absen as $absen)
                               <tr>
                                   <td>{{ $absen->date }}</td>
                                   <td>{{ $absen->time_in }}</td>
                                   <td>{{ $absen->time_out }}</td>
                                   <td>{{ $absen->note }}</td>
                               </tr>
                           @empty
                               <tr>
                                   <td colspan="4" align="center"><b><i>TIDAK ADA DATA YANG DAPAT DITAMPILKAN</i></b></td>
                               </tr>
                           @endforelse
                        </tbody>
                    </table>
                    {!! $data_absen->links() !!}
                 

                    
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
