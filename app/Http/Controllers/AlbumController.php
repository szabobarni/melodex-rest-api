<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Http\Requests\AlbumRequest;

class AlbumController extends Controller
{

   /**
    * @api {get} /album Get all albums
    * @apiName GetAlbums
    * @apiGroup Album
    * @apiVersion 1.0.0
    *
    * @apiSuccess {Object[]} album List of album objects.
    * @apiSuccess {Number} album.id Album ID.
    * @apiSuccess {String} album.title Album title.
    * @apiSuccess {String} album.artist Album artist.
    * @apiSuccess {String} album.release_date Album release date.
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "album": [
    *         {
    *           "id": 1,
    *           "title": "The Life of a Showgirl",
    *           "cover": "https://upload.wikimedia.org/wikipedia/en/thumb/f/...",
    *           "genre": "POP"
    *           "artist_id": "1"
    *           "year": "2025"
    *         }
    *       ]
    *     }
    */

    public function index()
    {
        $album = Album::all();
        return response()->json([
            'album' => $album,
        ]);
    }

   /**
    * @api {post} /album Create a new album
    * @apiName CreateAlbum
    * @apiGroup Album
    * @apiVersion 1.0.0
    *
    * @apiBody {String} title Album title.
    * @apiBody {String} cover Album cover image URL.
    * @apiBody {String} genre Album genre.
    * @apiBody {Number} artist_id Artist ID.
    * @apiBody {String} year Release year.
    *
    * @apiSuccess {Object} album Created album object.
    * @apiSuccess {Number} album.id Album ID.
    * @apiSuccess {String} album.title Album title.
    * @apiSuccess {String} album.cover Album cover image URL.
    * @apiSuccess {String} album.genre Album genre.
    * @apiSuccess {Number} album.artist_id Artist ID.
    * @apiSuccess {String} album.year Release year.
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 201 Created
    *     {
    *       "album": {
    *         "id": 2,
    *         "title": "Thriller",
    *         "cover": "https://example.com/thriller.jpg",
    *         "genre": "Pop",
    *         "artist_id": 1,
    *         "year": "1982"
    *       }
    *     }
    */
    public function store(AlbumRequest $request)
    {
        $album = Album::create($request->all());

        return response()->json([
            'album' => $album,
        ]);
    }

    /**
     * @api {patch} /album/:id Update an album
     * @apiName UpdateAlbum
     * @apiGroup Album
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Album ID.
     * @apiBody {String} title Album title.
     * @apiBody {String} cover Album cover image URL.
     * @apiBody {String} genre Album genre.
     * @apiBody {Number} artist_id Artist ID.
     * @apiBody {String} year Release year.
     *
     * @apiSuccess {Object} album Updated album object.
     * @apiSuccess {Number} album.id Album ID.
     * @apiSuccess {String} album.title Album title.
     * @apiSuccess {String} album.cover Album cover image URL.
     * @apiSuccess {String} album.genre Album genre.
     * @apiSuccess {Number} album.artist_id Artist ID.
     * @apiSuccess {String} album.year Release year.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "album": {
     *         "id": 2,
     *         "title": "Updated Title",
     *         "cover": "https://example.com/updated.jpg",
     *         "genre": "Rock",
     *         "artist_id": 2,
     *         "year": "2025"
     *       }
     *     }
     */

    public function update(AlbumRequest $request, $id)
	{
		$album = Album::findOrFail($id);
		$album->update($request->all());

		return response()->json([
			'album' => $album,
		]);
	} 

    /**
     * @api {delete} /album/:id Delete an album
     * @apiName DeleteAlbum
     * @apiGroup Album
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Album ID.
     *
     * @apiSuccess {String} message Confirmation message.
     * @apiSuccess {Number} id Deleted album ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Album deleted successfully",
     *       "id": 2
     *     }
     */

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
