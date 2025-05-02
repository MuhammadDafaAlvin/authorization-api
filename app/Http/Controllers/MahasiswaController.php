<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *   schema="Mahasiswa",
 *   type="object",
 *   title="Mahasiswa",
 *   required={"id", "nama", "nim", "jurusan"},
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="nama", type="string", example="Budi Santoso"),
 *   @OA\Property(property="nim", type="string", example="20210001"),
 *   @OA\Property(property="jurusan", type="string", example="Teknik Informatika"),
 *   @OA\Property(property="created_at", type="string", format="date-time"),
 *   @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class MahasiswaController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/mahasiswa",
     *   tags={"Mahasiswa"},
     *   summary="Ambil semua data mahasiswa",
     *   @OA\Response(
     *     response=200,
     *     description="Daftar mahasiswa",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Mahasiswa"))
     *   )
     * )
     */
    public function index()
    {
        return response()->json(Mahasiswa::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *   path="/api/mahasiswa",
     *   tags={"Mahasiswa"},
     *   summary="Tambah mahasiswa baru",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"nama", "nim", "jurusan"},
     *       @OA\Property(property="nama", type="string", example="Budi Santoso"),
     *       @OA\Property(property="nim", type="string", example="20210001"),
     *       @OA\Property(property="jurusan", type="string", example="Teknik Informatika")
     *     )
     *   ),
     *   @OA\Response(response=201, description="Mahasiswa ditambahkan"),
     *   @OA\Response(response=400, description="Validasi gagal")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string|unique:mahasiswas,nim',
            'jurusan' => 'required|string',
        ]);

        $mahasiswa = Mahasiswa::create($request->only(['nama', 'nim', 'jurusan']));
        return response()->json($mahasiswa, 201);
    }

    /**
     * @OA\Get(
     *   path="/api/mahasiswa/{id}",
     *   tags={"Mahasiswa"},
     *   summary="Ambil data mahasiswa berdasarkan ID",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Mahasiswa ditemukan",
     *     @OA\JsonContent(ref="#/components/schemas/Mahasiswa")
     *   ),
     *   @OA\Response(
     *     response=404, 
     *     description="Mahasiswa tidak ditemukan"
     *   )
     * )
     */
    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }
        return response()->json($mahasiswa, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * @OA\Put(
     *   path="/api/mahasiswa/{id}",
     *   tags={"Mahasiswa"},
     *   summary="Update data mahasiswa",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="nama", type="string", example="Budi Santoso"),
     *       @OA\Property(property="nim", type="string", example="20210001"),
     *       @OA\Property(property="jurusan", type="string", example="Teknik Informatika")
     *     )
     *   ),
     *   @OA\Response(response=200, description="Mahasiswa diperbarui"),
     *   @OA\Response(response=404, description="Mahasiswa tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $mahasiswa->update($request->only(['nama', 'nim', 'jurusan']));
        return response()->json($mahasiswa, 200);
    }

    /**
     * @OA\Delete(
     *   path="/api/mahasiswa/{id}",
     *   tags={"Mahasiswa"},
     *   summary="Hapus mahasiswa",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=204, description="Mahasiswa dihapus"),
     *   @OA\Response(response=404, description="Mahasiswa tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $mahasiswa->delete();
        return response()->json(null, 204);
    }
}
