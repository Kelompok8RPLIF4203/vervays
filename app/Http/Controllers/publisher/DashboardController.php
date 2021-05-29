<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Publisher;
use App\Book;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "publisher" => Publisher::getPublisherData(session('id')),
            "books" => Book::getBookDataForDashboardPublisher(),
        ];
        return view('pages.publisher.dashboard', $data);
    }

    public function bePublisher()
    {
        $id = session('id');
        Publisher::bePublisher($id);
        return true;
    }

    public function editDataPublisher()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "publisher" => Publisher::getPublisherData(session('id')),
        ];
        return view('pages.publisher.edit', $data);
    }

    public function updateDataPublisher(Request $request)
    {
        $this->validate($request, [
            'foto' => 'file|image|mimes:jpeg,png,jpg',
            'nama' => '',
            'deskripsi' => '',
        ]);
        $id = session('id');
        $foto = $request->foto;
        $nama = $request->nama;
        $deskripsi = $request->deskripsi;

        if ($foto != null) { //Jika publisher mengupdate foto
            $newId = Publisher::getNewProfilePhotoId();
            $file = $request->file('foto');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'image/profile_photos/'.$newId;
            $file->move($tujuan_upload,$nama_file);
            Publisher::updateFoto($nama_file, $id, $newId);
        }
        if ($nama != null) {
            Publisher::updateNama($nama, $id);
        }
        if ($deskripsi != null) {
            Publisher::updateDeskripsi($deskripsi, $id);
        }
        return redirect()->route('dashboard-publisher');
    }
}
