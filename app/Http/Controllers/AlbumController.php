<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Http\Requests\AlbumRequest;

class AlbumController extends Controller
{
    public function index()
    {
        $album = Album::all();
        return response()->json([
            'album' => $album,
        ]);
    }
    public function store(AlbumRequest $request)
    {
        $album = Album::create($request->all());

        return response()->json([
            'album' => $album,
        ]);
    }
    public function update(AlbumRequest $request, $id)
	{
		$album = Album::findOrFail($id);
		$album->update($request->all());

		return response()->json([
			'album' => $album,
		]);
	} 
    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();
        return response()->json([
            'message' => 'Album deleted successfully',
            'id' => $id
        ]);
    }
}
