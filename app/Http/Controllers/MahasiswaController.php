<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return response()->json([
            'mahasiswa'=>$mahasiswa,
            'message' => 'success'
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        if ($request->file('image')) {
            $fileName = uniqid() . '-' . $request->file('image')->getClientOriginalName();
            $simpan_foto = $request->file('image')->move(public_path('img'), $fileName);
            
            if($simpan_foto){
                $mahasiswa = Mahasiswa::create([
                    'name' => $request->input('name'),
                    'nim' => $request->input('nim'),
                    'semester' => $request->input('semester'),
                    'jabatan' => $request->input('jabatan'),
                    'image' => $fileName,
                    // 'file_name' => $fileName,
                ]);
                if($mahasiswa){
                    return response()->json(["message", "Successs Create Data and Foto"], 201);
                } else {
                    return response()->json(["message", "Foto Tersimpan, data tidak"], 301);
                }
            } else {
                return response()->json(["message", "Foto dan data tidak Tersimpan"], 401);
            }
        } else {
            return response()->json(["message", "Tidak ada foto yang dikirim"], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    public function update(Request $request)
    {
        $id = $request->input("id");
        
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found'], 404);
        }

        if ($request->file('image')) {
            $fileName = uniqid() . '-' . $request->file('image')->getClientOriginalName();

            $request->file('image')->move(public_path('img'), $fileName);

            if ($mahasiswa->image !== "default.jpg") {
                unlink(public_path('img/').$mahasiswa->image);
            }
            
            $mahasiswa->update([
                'image' => $fileName,
            ]);
        }

        $mahasiswa->update([
            'name' => $request->input('name'),
            'nim' => $request->input("nim"),
            'semester' => $request->input("semester"),
            'jabatan' => $request->input("jabatan"),
        ]);

        return response()->json(["message" => "successs"], 201);
    }


    public function destroy(Request $request)
{
    if ($request->user()) {
        $id = $request->json()->get('id');
        $mahasiswa = Mahasiswa::find($id);

        if ($mahasiswa) {
            $mahasiswa->delete();
            return response()->json(["message" => "Data Mahasiswa Berhasil Dihapus!", "id" => $id], 200);
        } else {
            return response()->json(["message" => "Data Mahasiswa Tidak Ditemukan! id : $id"], 404);
        }
    } else {
        return response()->json(["message" => "Unauthorized"], 401);
    }
}

}