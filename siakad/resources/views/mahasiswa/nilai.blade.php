@extends('mahasiswa.layout')

@section('content')
<div class="container mt-3">
    <div class="text-center">
        <h2 style="font-size: 20px">JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
    </div>
    <h3 class="text-center mt-4 mb-5">KARTU HASIL STUDI</h3>
    <strong>Name: </strong> {{$nilai->mahasiswa->nama}}<br>
    <strong>NIM: </strong> {{$nilai->mahasiswa->nim}}<br>
    <strong>Class: </strong> {{$nilai->mahasiswa->kelas->nama_kelas}}<br><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Mata Kuliah</th>
                <th scope="col">SKS</th>
                <th scope="col">Semester</th>
                <th scope="col">Nilai Angka</th>
                <th scope="col">Nilai Huruf</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilai as $mk)
            <tr>
                <td>{{$mk->matakuliah->nama_matkul}}</td>
                <td>{{$mk->matakuliah->sks}}</td>
                <td>{{$mk->matakuliah->semester}}</td>
                <td>{{$mk->nilai_angka}}</td>
                <td>{{$mk->nilai_huruf}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('mahasiswa.index') }}" class="btn btn-success">Kembali</a>
</div>
@endsection
