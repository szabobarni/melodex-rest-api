<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Http\Requests\AlbumRequest;
use App\Http\Requests\SongRequest;

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
            'albums' => $album,
        ]);
    }

    /**
     * @api {get} /album/:id/songs Get songs for an album
     * @apiName GetAlbumSongs
     * @apiGroup Album
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Album ID.
     *
     * @apiSuccess {String} album Album name.
     * @apiSuccess {Object[]} songs List of songs for the album.
     * @apiSuccess {Number} songs.id Song ID.
     * @apiSuccess {String} songs.name Song name.
     * @apiSuccess {String} songs.lyrics Song lyrics.
     * @apiSuccess {String} songs.songwriter Songwriter name.
     * @apiSuccess {Number} songs.album_id Associated album ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "album": "The Life of a Showgirl",
     *       "songs": [
     *         {
     *           "id": 1,
     *           "name": "Nikes",
     *           "lyrics": "",
     *           "songwriter": "Christopher Breaux",
     *           "album_id": 27
     *         }
     *       ]
     *     }
     *
     * @apiError (404) AlbumNotFound The specified album was not found.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "Album not found"
     *     }
     */
    public function index_song($id) {
        $album = Album::find($id);

        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        return response()->json([
            'album' => $album->name,
            'songs' => $album->song
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

        return response()->json(['message' => 'Album created successfully', 'album' => $album], 201);
    }
    /**
     * @api {post} /album/:id/song Create a new song for an album
     * @apiName CreateAlbumSong
     * @apiGroup Album
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Album ID.
     *
     * @apiBody {String} name Song name.
     * @apiBody {String} [lyrics] Song lyrics.
     * @apiBody {String} [songwriter] Songwriter name.
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
     *       "message": "Song created successfully",
     *       "song": {
     *         "id": 12,
     *         "name": "Imagine",
     *         "lyrics": "Imagine there's no heaven...",
     *         "songwriter": "John Lennon",
     *         "album_id": 2
     *       }
     *     }
     *
     * @apiError (404) AlbumNotFound The specified album was not found.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "Album not found"
     *     }
     */
    public function store_song(SongRequest $request, $id)
    {
        $album = Album::find($id);

        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        $song = $album->song()->create($request->all());

        return response()->json(['message' => 'Song created successfully', 'song' => $song], 201);
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
		$album = Album::find($id);
        if(empty($album)){
            return response(json_encode(['message'=>"Album not found!"]),404);
        };
		$album->update($request->all());

		return response()->json([
			'album' => $album,
		]);
	} 
    /**
     * @api {patch} /album/:album_id/song/:id Update a song for an album
     * @apiName UpdateAlbumSong
     * @apiGroup Album
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} album_id Album ID.
     * @apiParam {Number} id Song ID.
     *
     * @apiBody {String} [name] Song name.
     * @apiBody {String} [lyrics] Song lyrics.
     * @apiBody {String} [songwriter] Songwriter name.
     *
     * @apiSuccess {String} message Confirmation message.
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
     *       "message": "Song updated successfully",
     *       "song": {
     *         "id": 3,
     *         "name": "Updated Song",
     *         "lyrics": "Updated lyrics...",
     *         "songwriter": "Updated Writer",
     *         "album_id": 2
     *       }
     *     }
     *
     * @apiError (404) AlbumNotFound The specified album was not found.
     * @apiError (404) SongNotFound The specified song was not found for this album.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "Song not found for this album"
     *     }
     */
    public function update_song(SongRequest $request, $album_id, $id)
    {

        $album = Album::find($album_id);

        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        $song = $album->song()->find($id);

        if (!$song) {
            return response()->json(['message' => 'Song not found for this album'], 404);
        }

        $song->update($request->all());

        return response()->json(['message' => 'Song updated successfully', 'song' => $song]);
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
    ], 410);
    }

    /**
     * @api {delete} /album/:album_id/song/:id Delete a song from an album
     * @apiName DeleteAlbumSong
     * @apiGroup Album
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} album_id Album ID.
     * @apiParam {Number} id Song ID.
     *
     * @apiSuccess {String} message Confirmation message.
     * @apiSuccess {Number} id Deleted song ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Song deleted successfully",
     *       "id": 5
     *     }
     *
     * @apiError (404) AlbumNotFound The specified album was not found.
     * @apiError (404) SongNotFound The specified song was not found for this album.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "Song not found for this album"
     *     }
     */
    public function destroy_song($album_id, $id)
    {
        $album = Album::find($album_id);

        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        $song = $album->song()->find($id);

        if (!$song) {
            return response()->json(['message' => 'Song not found for this album'], 404);
        }

        $song->delete();
        return response()->json(['message' => 'Song deleted successfully', 'id' => $id], 410);
    }
}
