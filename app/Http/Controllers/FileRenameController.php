<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileRenameController extends Controller
{
    public function fileUploadRename()
    {
        return view('file-upload-rename');
    }

    public function prosesFileUploadRename(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'berkas' => 'required|file|image|max:2000'
        ]);

        $namaFile = $request->nama;
        $path = $request->berkas->move('gambar', $namaFile);

        $pathBaru = asset('gambar/' . $namaFile);
        echo "<div class='flex flex-col'>
        <p>Gambar berhasil di Upload ke <a href='$pathBaru'>$path</a></p>
        <img src='$pathBaru'>
        </div>";
    }
}