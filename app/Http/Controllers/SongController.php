<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Http\Requests\SongRequest;

class SongController extends Controller
{
        
    /**
     * @api {get} /song Get all songs
     * @apiName GetSongs
     * @apiGroup Song
     * @apiVersion 1.0.0
     *
     * @apiSuccess {Object[]} song List of song objects.
     * @apiSuccess {Number} song.id Song ID.
     * @apiSuccess {String} song.name Song name.
     * @apiSuccess {String} song.lyrics Song lyrics.
     * @apiSuccess {String} song.songwriter Songwriter name.
     * @apiSuccess {Number} song.album_id Associated album ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "song": [
     *         {
     *           "id": 1,
     *           "name": "Nikes",
     *           "lyrics": "",
     *           "songwriter": "Christopher Breaux",
     *           "album_id": 27
     *         }
     *       ]
     *     }
     */

    public function index()
    {
        $song = Song::all();
        return response()->json([
            'song' => $song,
        ]);
    }
        
    /**
     * @api {post} /song Create a new song
     * @apiName CreateSong
     * @apiGroup Song
     * @apiVersion 1.0.0
     *
     * @apiBody {String} name Song name.
     * @apiBody {String} lyrics Song lyrics.
     * @apiBody {String} songwriter Songwriter name.
     * @apiBody {Number} album_id Associated album ID.
     *
     * @apiSuccess {Object} song Created song object.
     * @apiSuccess {Number} song.id Song ID.
     * @apiSuccess {String} song.name Song name.
     * @apiSuccess {String} song.lyrics Song lyrics.
     * @apiSuccess {String} song.songwriter Songwriter name.
     * @apiSuccess {Number} song.album_id Associated album ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 201 Created
     *     {
     *       "song": {
     *         "id": 2,
     *         "name": "Imagine",
     *         "lyrics": "Imagine there's no heaven...",
     *         "songwriter": "John Lennon",
     *         "album_id": 2
     *       }
     *     }
     */

    public function store(SongRequest $request)
    {
        $song = Song::create($request->all());

        return response()->json([
            'song' => $song,
        ]);
    }
        
    /**
     * @api {patch} /song/:id Update a song
     * @apiName UpdateSong
     * @apiGroup Song
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Song ID.
     * @apiBody {String} name Song name.
     * @apiBody {String} lyrics Song lyrics.
     * @apiBody {String} songwriter Songwriter name.
     * @apiBody {Number} album_id Associated album ID.
     *
     * @apiSuccess {Object} song Updated song object.
     * @apiSuccess {Number} song.id Song ID.
     * @apiSuccess {String} song.name Song name.
     * @apiSuccess {String} song.lyrics Song lyrics.
     * @apiSuccess {String} song.songwriter Songwriter name.
     * @apiSuccess {Number} song.album_id Associated album ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "song": {
     *         "id": 2,
     *         "name": "Updated Song",
     *         "lyrics": "Updated lyrics...",
     *         "songwriter": "Updated Writer",
     *         "album_id": 3
     *       }
     *     }
     */

    public function update(SongRequest $request, $id)
	{
		$song = Song::findOrFail($id);
		$song->update($request->all());

		return response()->json([
			'song' => $song,
		]);
	} 
        
    /**
     * @api {delete} /song/:id Delete a song
     * @apiName DeleteSong
     * @apiGroup Song
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Song ID.
     *
     * @apiSuccess {String} message Confirmation message.
     * @apiSuccess {Number} id Deleted song ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Song deleted successfully",
     *       "id": 2
     *     }
     */

    public function destroy($id)
    {
        $song = Song::findOrFail($id);
        $song->delete();
        return response()->json([
            'message' => 'Song deleted successfully',
            'id' => $id
        ]);
    }
}
