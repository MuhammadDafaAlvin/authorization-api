<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *   schema="Mahasiswa",
 *   title="Mahasiswa",
 *   required={"id", "nim", "nama", "jenis_kelamin", "alamat", "tanggal_lahir", "program_studi", "angkatan", "email"},
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="nim", type="string", example="20210001"),
 *   @OA\Property(property="nama", type="string", example="Budi Santoso"),
 *   @OA\Property(property="jenis_kelamin", type="string", enum={"L", "P"}, example="L"),
 *   @OA\Property(property="alamat", type="string", example="Jl. Merdeka No.10"),
 *   @OA\Property(property="tanggal_lahir", type="string", format="date", example="2001-05-10"),
 *   @OA\Property(property="program_studi", type="string", example="Teknik Informatika"),
 *   @OA\Property(property="angkatan", type="integer", example=2021),
 *   @OA\Property(property="email", type="string", format="email", example="budi@example.com"),
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
     * @OA\Post(
     *   path="/api/mahasiswa",
     *   tags={"Mahasiswa"},
     *   summary="Tambah mahasiswa baru",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"nim", "nama", "jenis_kelamin", "alamat", "tanggal_lahir", "program_studi", "angkatan", "email"},
     *       @OA\Property(property="nim", type="string", example="20210001"),
     *       @OA\Property(property="nama", type="string", example="Budi Santoso"),
     *       @OA\Property(property="jenis_kelamin", type="string", example="L"),
     *       @OA\Property(property="alamat", type="string", example="Jl. Merdeka No.10"),
     *       @OA\Property(property="tanggal_lahir", type="string", format="date", example="2001-05-10"),
     *       @OA\Property(property="program_studi", type="string", example="Teknik Informatika"),
     *       @OA\Property(property="angkatan", type="integer", example=2021),
     *       @OA\Property(property="email", type="string", format="email", example="budi@example.com")
     *     )
     *   ),
     *   @OA\Response(response=201, description="Mahasiswa ditambahkan"),
     *   @OA\Response(response=400, description="Validasi gagal")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|unique:mahasiswa,nim',
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'program_studi' => 'required|string',
            'angkatan' => 'required|digits:4|integer',
            'email' => 'required|email|unique:mahasiswa,email',
        ]);

        $mahasiswa = Mahasiswa::create($validated);
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
     *   @OA\Response(response=404, description="Mahasiswa tidak ditemukan")
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
     *       @OA\Property(property="jenis_kelamin", type="string", example="L"),
     *       @OA\Property(property="alamat", type="string", example="Jl. Merdeka No.10"),
     *       @OA\Property(property="tanggal_lahir", type="string", format="date", example="2001-05-10"),
     *       @OA\Property(property="program_studi", type="string", example="Teknik Informatika"),
     *       @OA\Property(property="angkatan", type="integer", example=2021),
     *       @OA\Property(property="email", type="string", format="email", example="budi@example.com")
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

        $validated = $request->validate([
            'nim' => 'sometimes|string|unique:mahasiswa,nim,' . $id,
            'nama' => 'sometimes|string',
            'jenis_kelamin' => 'sometimes|in:L,P',
            'alamat' => 'sometimes|string',
            'tanggal_lahir' => 'sometimes|date',
            'program_studi' => 'sometimes|string',
            'angkatan' => 'sometimes|digits:4|integer',
            'email' => 'sometimes|email|unique:mahasiswa,email,' . $id,
        ]);

        $mahasiswa->update($validated);
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
