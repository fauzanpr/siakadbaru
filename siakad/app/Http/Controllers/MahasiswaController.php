<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        $mahasiswa = Mahasiswa::all(); // Mengambil semua isi tabel
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(5);
        return view('mahasiswa.index', ['mahasiswa' => $paginate]);
    }
    public function create()
    {
        return view('mahasiswa.create');
    }
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
        ]);
        //fungsi eloquent untuk menambah data
        Mahasiswa::create($request->all());
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }
    public function show($nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::where('nim', $nim)->first();
        return view('mahasiswa.detail', compact('Mahasiswa'));
    }
    public function edit($nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
        return view('mahasiswa.edit', compact('Mahasiswa'));
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
            'Tanggal_Lahir' => 'required'
        ]);
        //fungsi eloquent untuk mengupdate data inputan kita
        Mahasiswa::where('nim', $nim)
            ->update([
                'nim' => $request->Nim,
                'nama' => $request->Nama,
                'kelas' => $request->Kelas,
                'jurusan' => $request->Jurusan,
                'jenis_kelamin' => $request->Jenis_Kelamin,
                'email' => $request->Email,
                'alamat' => $request->Alamat,
                'tanggal_lahir' => $request->Tanggal_Lahir
            ]);
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
                ->orWhere('kelas', 'LIKE', "%{$val}%")
                ->orWhere('jurusan', 'LIKE', "%{$val}%")
                ->orWhere('jenis_kelamin', 'LIKE', "%{$val}%")
                ->orWhere('email', 'LIKE', "%{$val}%")
                ->orWhere('alamat', 'LIKE', "%{$val}%")
                ->orWhere('tanggal_lahir', 'LIKE', "%{$val}%")
                ->paginate(5);
        return view('mahasiswa.index', ['mahasiswa' => $values]);
    }
};
