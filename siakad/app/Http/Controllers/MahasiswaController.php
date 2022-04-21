<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;
use App\Models\Mahasiswa_MataKuliah;
use Illuminate\Support\Facades\Storage;
use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // yang semula Mahasiswa::all() dibuah menjadi with() yang menyatakan relasi
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(5);
        return view('mahasiswa.index', ['mahasiswa' => $paginate]);
    }
    public function create()
    {
        $kelas = Kelas::all(); // mendapatkan data dari tabel kelas
        return view('mahasiswa.create', ['kelas' => $kelas]);
    }
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Jenis_Kelamin' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);

        $image_name = '';
        if ($request->file('Image')) {
            $image_name = $request->file('Image')->store('images', 'public');
        }
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->jenis_kelamin = $request->get('Jenis_Kelamin');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggal_lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->image = $image_name;

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }
    public function show($nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
    }
    public function edit($nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        //$Mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $kelas = Kelas::all(); // mendapatkan data dari tabel kelas
        return view('mahasiswa.edit', compact('Mahasiswa', 'kelas'));
    }
    public function update(Request $request, $nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Jenis_Kelamin' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        if ($mahasiswa->image && file_exists(storage_path('app/public/' . $mahasiswa->image))) {
            Storage::delete('public/' . $mahasiswa->image);
        }
        $image_name = $request->file('Image')->store('images', 'public');
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->jenis_kelamin = $request->get('Jenis_Kelamin');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggal_lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->image = $image_name;
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk mengupdate data inputan kita
        // Mahasiswa::where('nim', $nim)
        //     ->update([
        //         'nim' => $request->Nim,
        //         'nama' => $request->Nama,
        //         'kelas' => $request->Kelas,
        //         'jurusan' => $request->Jurusan,
        //         'jenis_kelamin' => $request->Jenis_Kelamin,
        //         'email' => $request->Email,
        //         'alamat' => $request->Alamat,
        //         'tanggal_lahir' => $request->Tanggal_Lahir
        //     ]);
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }
    public function destroy($nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::where('nim', $nim)->delete();
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Dihapus');
    }
    public function search(Request $request) {
        $val = $request->input('search');
        $values = Mahasiswa::where('nim', 'LIKE', "%{$val}%")
                ->orWhere('nama', 'LIKE', "%{$val}%")
                // ->orWhere('id_kelas', 'LIKE', "%{$val}%")
                ->orWhere('jurusan', 'LIKE', "%{$val}%")
                ->orWhere('jenis_kelamin', 'LIKE', "%{$val}%")
                ->orWhere('email', 'LIKE', "%{$val}%")
                ->orWhere('alamat', 'LIKE', "%{$val}%")
                ->orWhere('tanggal_lahir', 'LIKE', "%{$val}%")
                ->paginate(5);
        return view('mahasiswa.index', ['mahasiswa' => $values]);
    }

    public function nilai($id) {
        $nilai = Mahasiswa_MataKuliah::where('mahasiswa_id', $id)
            ->with('matakuliah')->get();
        $nilai->mahasiswa = Mahasiswa::with('kelas')
            ->where('id_mahasiswa', $id)->first();

        return view('mahasiswa.nilai', compact('nilai'));
    }

    public function cetak_pdf($id) {
        $nilai = Mahasiswa_MataKuliah::where('mahasiswa_id', $id)
            ->with('matakuliah')->get();
        $nilai->mahasiswa = Mahasiswa::with('kelas')
            ->where('id_mahasiswa', $id)->first();
        $pdf = PDF::loadview('mahasiswa.mahasiswa_pdf', ['nilai'=>$nilai]);
        return $pdf->stream();
    }
};
