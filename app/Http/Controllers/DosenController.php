<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *   title="API Dokumentasi Dosen",
 *   version="1.0",
 *   description="Dokumentasi API untuk manajemen data dosen"
 * )
 *
 * @OA\Tag(
 *   name="Dosen",
 *   description="Operasi CRUD untuk data dosen"
 * )
 *
 * @OA\Schema(
 *   schema="Dosen",
 *   type="object",
 *   title="Dosen",
 *   required={"id", "nama_dosen", "nidn"},
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="nama_dosen", type="string", example="Dr. Ahmad"),
 *   @OA\Property(property="nidn", type="string", example="1234567890"),
 *   @OA\Property(property="created_at", type="string", format="date-time"),
 *   @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class DosenController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/dosen",
     *   tags={"Dosen"},
     *   summary="Ambil semua data dosen",
     *   @OA\Response(
     *     response=200,
     *     description="Daftar dosen",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Dosen"))
     *   )
     * )
     */
    public function index()
    {
        return Dosen::all();
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
     *   path="/api/dosen",
     *   tags={"Dosen"},
     *   summary="Tambah dosen baru",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"nama_dosen", "nidn"},
     *       @OA\Property(property="nama_dosen", type="string", example="Dr. Ahmad"),
     *       @OA\Property(property="nidn", type="string", example="1234567890")
     *     )
     *   ),
     *   @OA\Response(response=201, description="Dosen ditambahkan"),
     *   @OA\Response(response=400, description="Validasi gagal")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_dosen' => 'required|string',
            'nidn' => 'required|string|unique:dosens,nidn'
        ]);

        $dosen = Dosen::create($request->only(['nama_dosen', 'nidn']));
        return response()->json($dosen, 201);
    }

    /**
     * @OA\Get(
     *   path="/api/dosen/{id}",
     *   tags={"Dosen"},
     *   summary="Ambil data dosen berdasarkan ID",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Dosen ditemukan",
     *     @OA\JsonContent(ref="#/components/schemas/Dosen")
     *   ),
     *   @OA\Response(response=404, description="Dosen tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $dosen = Dosen::find($id);
        if (!$dosen) {
            return response()->json(['message' => 'Dosen tidak ditemukan'], 404);
        }
        return response()->json($dosen, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * @OA\Put(
     *   path="/api/dosen/{id}",
     *   tags={"Dosen"},
     *   summary="Update data dosen",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="nama", type="string", example="Dr. Budi"),
     *       @OA\Property(property="nidn", type="string", example="9876543210")
     *     )
     *   ),
     *   @OA\Response(response=200, description="Dosen diperbarui"),
     *   @OA\Response(response=404, description="Dosen tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $dosen = Dosen::find($id);
        if (!$dosen) {
            return response()->json(['message' => 'Dosen tidak ditemukan'], 404);
        }

        $dosen->update($request->only(['nama_dosen', 'nidn']));
        return response()->json($dosen, 200);
    }

    /**
     * @OA\Delete(
     *   path="/api/dosen/{id}",
     *   tags={"Dosen"},
     *   summary="Hapus dosen",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=204, description="Dosen dihapus"),
     *   @OA\Response(response=404, description="Dosen tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $dosen = Dosen::find($id);
        if (!$dosen) {
            return response()->json(['message' => 'Dosen tidak ditemukan'], 404);
        }

        $dosen->delete();
        return response()->json(null, 204);
    }
}
