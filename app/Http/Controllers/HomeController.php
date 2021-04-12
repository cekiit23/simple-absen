<?php

namespace App\Http\Controllers;

use App\Absen;
use Illuminate\Http\Request;

use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    // Time Zone asia/jakarta
    public function timeZone($location)
    {
        return date_default_timezone_set($location);
    }
    public function index()
    {
        $this->timeZone('Asia/Jakarta');

        $absen = new Absen;
        $user_id = Auth::user()->id;
        $date = date("Y-m-d");
        $cek_absen = Absen::where(['user_id' => $user_id,'date' => $date])
                    -> get()
                    ->first();

        // cek apakah sudah absen atau belum agar kita bisa menonaktifkan tombolnya sesuai kebutuhan
        if(is_null($cek_absen))
        {
            $info = array(
                'status' => 'Anda belum mengisi absen hari ini',
                'masuk' => '',
                'keluar' => 'disabled'
            );
        } elseif ($cek_absen->time_out == NULL)
        {
            $info = array(
                'status' => 'Sebelum pulang jangan lupa absen dulu',
                'masuk' => 'disabled',
                'keluar' => ''
            );
        } else {
            $info = array(
                'status' => 'Terimakasih anda sudah absen hari ini',
                'masuk' => 'disabled',
                'keluar' => 'disabled'
            );
        }
        // return $info;

        $data_absen = $absen->where('user_id',$user_id)->orderBy('date', 'desc')->paginate(20);
        return view('home',compact('data_absen','info'));
    }

    public function absen(Request $request)
    {
        // inisialisasi timezone asia/jakarta
        $this->timeZone('Asia/Jakarta');

        // variable untuk diinput ke database
        $user_id = Auth::user()->id;
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $note = $request->note;

        $absen = new Absen;
        $cek_absen = $absen->where(['date'=>$date, 'user_id'=> $user_id])->count();

        // Absen Masuk
        if (isset($request->masuk)) {
            if ($cek_absen > 0) {
                return redirect()->back();
            }
            $absen->create([
                'user_id' => $user_id,
                'date' => $date,
                'time_in' => $time,
                'note' => $note
            ]);
            return redirect()->back();
        }
        
        // Absen Keluar
        elseif (isset($request->keluar)) {
            $absen->where(['date' => $date, 'user_id' => $user_id])
            ->update([
                'time_out' => $time
            ]);

            return redirect()->back();
        }
        

    }
}
