<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Http\Requests\ArtistRequest;
use App\Http\Requests\MemberRequest;
use App\Http\Requests\AlbumRequest;
use App\Http\Requests\SongRequest;

class ArtistController extends Controller
{
    /**
     * @api {get} /artist Get all artists
     * @apiName GetArtists
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiSuccess {Object[]} artist List of artist objects.
     * @apiSuccess {Number} artist.id Artist ID.
     * @apiSuccess {String} artist.name Artist name.
     * @apiSuccess {String} artist.nationality Artist nationality.
     * @apiSuccess {String} artist.image Artist image URL.
     * @apiSuccess {String} artist.description Artist description.
     * @apiSuccess {String} artist.is_band Whether the artist is a band.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "artist": [
     *         {
     *           "id": 1,
     *           "name": "Taylor Swift",
     *           "nationality": "American",
     *           "image": "https://m.media-amazon.com/images/M/MV5BYWYwYzYzMj...",
     *           "description": "aylor Swift began her career as a teenage country...",
     *           "is_band": "no"
     *         }
     *       ]
     *     }
     */

    public function index()
    {
        $artist = Artist::all();
        return response()->json([
            'artists' => $artist,
        ]);
    }


    public function index_member($id)
    {
        $artist = Artist::find($id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        if ($artist->is_band == "no") {
            return response()->json(['message' => 'Artist is not a band'], 400);
        }

        return response()->json([
            'artist' => $artist->name,
            'members' => $artist->member
        ]);
    }

    /**
     * @api {get} /artist/:id/albums Get albums for an artist
     * @apiName GetArtistAlbums
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Artist ID.
     *
     * @apiSuccess {String} artist Artist name.
     * @apiSuccess {Object[]} albums List of albums for the artist.
     * @apiSuccess {Number} albums.id Album ID.
     * @apiSuccess {String} albums.name Album name.
     * @apiSuccess {String} albums.cover Album cover URL.
     * @apiSuccess {String} albums.genre Album genre.
     * @apiSuccess {Number} albums.artist_id Associated artist ID.
     * @apiSuccess {String} albums.year Release year.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "artist": "Taylor Swift",
     *       "albums": [
     *         {
     *           "id": 1,
     *           "name": "1989",
     *           "cover": "https://...",
     *           "genre": "Pop",
     *           "artist_id": 1,
     *           "year": "2014"
     *         }
     *       ]
     *     }
     *
     * @apiError (404) ArtistNotFound The specified artist was not found.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "Artist not found"
     *     }
     */
    public function index_album($id)
    {
        $artist = Artist::find($id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        return response()->json([
            'artist' => $artist->name,
            'albums' => $artist->album
        ]);
    }

     /**
     * @api {get} /artist/:id Get an artist by ID
     * @apiName GetArtist
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Artist ID.
     *
     * @apiSuccess {Object} artist Artist object.
     * @apiSuccess {Number} artist.id Artist ID.
     * @apiSuccess {String} artist.name Artist name.
     * @apiSuccess {String} artist.nationality Artist nationality.
     * @apiSuccess {String} artist.image Artist image URL.
     * @apiSuccess {String} artist.description Artist description.
     * @apiSuccess {String} artist.is_band Whether the artist is a band.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "artist": {
     *         "id": 1,
     *         "name": "Taylor Swift",
     *         "nationality": "American",
     *         "image": "https://m.media-amazon.com/images/M/MV5BYWYwYzYzMj...",
     *         "description": "Taylor Swift began her career as a teenage country...",
     *         "is_band": "no"
     *       }
     *     }
     *
     * @apiError (404) ArtistNotFound The specified artist was not found.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "Artist not found"
     *     }
     */
    public function show($id)
    {
        $artist = Artist::find($id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        return response()->json([
            'artist' => $artist,
        ]);
    }

    /**
     * @api {get} /artist/:artist_id/album/:id/songs Get songs for an artist's album
     * @apiName GetArtistAlbumSongs
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} artist_id Artist ID.
     * @apiParam {Number} id Album ID.
     *
     * @apiSuccess {String} artist Artist name.
     * @apiSuccess {String} album Album name.
     * @apiSuccess {Object[]} songs List of songs for the album.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "artist": "Artist Name",
     *       "album": "Album Name",
     *       "songs": [
     *         { "id": 1, "name": "Track 1", "album_id": 2 }
     *       ]
     *     }
     *
     * @apiError (404) ArtistNotFound The specified artist was not found.
     * @apiError (404) AlbumNotFound The specified album was not found for this artist.
     */
    public function index_song($artist_id,$id)
    {
        $artist = Artist::find($artist_id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $album = $artist->album()->find($id);

        if (!$album) {
            return response()->json(['message' => 'Album not found for this artist'], 404);
        }

        return response()->json([
            'artist' => $artist->name,
            'album' => $album->name,
            'songs' => $album->song
        ]);
    }
    

        
    /**
     * @api {post} /artist Create a new artist
     * @apiName CreateArtist
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiBody {String} name Artist name.
     * @apiBody {String} nationality Artist nationality.
     * @apiBody {String} image Artist image URL.
     * @apiBody {String} description Artist description.
     * @apiBody {String} is_band Whether the artist is a band.
     *
     * @apiSuccess {Object} artist Created artist object.
     * @apiSuccess {Number} artist.id Artist ID.
     * @apiSuccess {String} artist.name Artist name.
     * @apiSuccess {String} artist.nationality Artist nationality.
     * @apiSuccess {String} artist.image Artist image URL.
     * @apiSuccess {String} artist.description Artist description.
     * @apiSuccess {String} artist.is_band Whether the artist is a band.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 201 Created
     *     {
     *       "artist": {
     *         "id": 2,
     *         "name": "Adele",
     *         "nationality": "British",
     *         "image": "https://example.com/adele.jpg",
     *         "description": "Award-winning solo singer.",
     *         "is_band": "no"
     *       }
     *     }
     */

    public function store(ArtistRequest $request)
    {
        $artist = Artist::create($request->all());

        return response(json_encode(['artist' => $artist,]),201);
    }
    /**
     * @api {post} /artist/:id/member Create a new member for a band
     * @apiName CreateArtistMember
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Artist ID.
     *
     * @apiBody {String} name Member name.
     * @apiBody {String} instrument Member instrument.
     * @apiBody {String} year Year joined or active.
     * @apiBody {String} image Member image URL.
     *
     * @apiSuccess {Object} member Created member object.
     *
     * @apiError (404) ArtistNotFound The specified artist was not found.
     * @apiError (400) NotABand The artist is not a band.
     */
    public function store_member(MemberRequest $request, $id)
    {
        $artist = Artist::find($id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        if ($artist->is_band == "no") {
            return response()->json(['message' => 'Artist is not a band'], 400);
        }

        $member = $artist->member()->create($request->all());

        return response()->json(['message' => 'Member created successfully', 'member' => $member], 201);
    }

    /**
     * @api {post} /artist/:id/album Create a new album for an artist
     * @apiName CreateArtistAlbum
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Artist ID.
     *
     * @apiBody {String} name Album name.
     * @apiBody {String} cover Album cover URL.
     * @apiBody {String} genre Album genre.
     * @apiBody {String} year Release year.
     *
     * @apiSuccess {Object} album Created album object.
     *
     * @apiError (404) ArtistNotFound The specified artist was not found.
     */
    public function store_album(AlbumRequest $request, $id)
    {
        $artist = Artist::find($id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $album = $artist->album()->create($request->all());

        return response()->json(['message' => 'Album created successfully', 'album' => $album], 201);
    }

    /**
     * @api {post} /artist/:artist_id/album/:id/song Create a new song for an album
     * @apiName CreateArtistAlbumSong
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} artist_id Artist ID.
     * @apiParam {Number} id Album ID.
     *
     * @apiBody {String} name Song name.
     * @apiBody {String} [lyrics] Song lyrics.
     * @apiBody {String} [songwriter] Songwriter name.
     *
     * @apiSuccess {Object} song Created song object.
     *
     * @apiError (404) ArtistNotFound The specified artist was not found.
     * @apiError (404) AlbumNotFound The specified album was not found for this artist.
     */
    public function store_song(SongRequest $request, $artist_id, $id)
    {
        $artist = Artist::find($artist_id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $album = $artist->album()->find($id);

        if (!$album) {
            return response()->json(['message' => 'Album not found for this artist'], 404);
        }

        $song = $album->song()->create($request->all());

        return response()->json(['message' => 'Song created successfully', 'song' => $song], 201);
    }
        
    /**
     * @api {patch} /artist/:id Update an artist
     * @apiName UpdateArtist
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Artist ID.
     * @apiBody {String} name Artist name.
     * @apiBody {String} nationality Artist nationality.
     * @apiBody {String} image Artist image URL.
     * @apiBody {String} description Artist description.
     * @apiBody {String} is_band Whether the artist is a band.
     *
     * @apiSuccess {Object} artist Updated artist object.
     * @apiSuccess {Number} artist.id Artist ID.
     * @apiSuccess {String} artist.name Artist name.
     * @apiSuccess {String} artist.nationality Artist nationality.
     * @apiSuccess {String} artist.image Artist image URL.
     * @apiSuccess {String} artist.description Artist description.
     * @apiSuccess {String} artist.is_band Whether the artist is a band.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "artist": {
     *         "id": 2,
     *         "name": "Updated Name",
     *         "nationality": "Updated Nationality",
     *         "image": "https://example.com/updated.jpg",
     *         "description": "Updated description.",
     *         "is_band": "no"
     *       }
     *     }
     */

    public function update(ArtistRequest $request, $id)
	{
		$artist = Artist::find($id);
        if(empty($artist)){
            return response(json_encode(['message'=>"Artist ({$id}) not found!"]),404);
        };
		$artist->update($request->all());

		return response()->json([
			'artist' => $artist,
		]);
        
    }
    /**
     * @api {patch} /artist/:artist_id/member/:id Update a member for an artist
     * @apiName UpdateArtistMember
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} artist_id Artist ID.
     * @apiParam {Number} id Member ID.
     *
     * @apiBody {String} [name] Member name.
     * @apiBody {String} [instrument] Member instrument.
     * @apiBody {String} [year] Year joined or active.
     *
     * @apiSuccess {Object} member Updated member object.
     *
     * @apiError (404) ArtistNotFound The specified artist was not found.
     * @apiError (404) MemberNotFound The specified member was not found for this artist.
     */
    public function update_member(MemberRequest $request, $artist_id, $id)
    {

        $artist = Artist::find($artist_id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        if ($artist->is_band == "no") {
            return response()->json(['message' => 'Artist is not a band'], 400);
        }

        $member = $artist->member()->find($id);

        if (!$member) {
            return response()->json(['message' => 'Member not found for this artist'], 404);
        }

        $member->update($request->all());

        return response()->json(['message' => 'Member updated successfully', 'member' => $member]);
    }

    /**
     * @api {patch} /artist/:artist_id/album/:id Update an album for an artist
     * @apiName UpdateArtistAlbum
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} artist_id Artist ID.
     * @apiParam {Number} id Album ID.
     *
     * @apiBody {String} [name] Album name.
     * @apiBody {String} [cover] Album cover URL.
     * @apiBody {String} [genre] Album genre.
     * @apiBody {String} [year] Release year.
     *
     * @apiSuccess {Object} album Updated album object.
     *
     * @apiError (404) ArtistNotFound The specified artist was not found.
     * @apiError (404) AlbumNotFound The specified album was not found for this artist.
     */
    public function update_album(AlbumRequest $request, $artist_id, $id)
    {

        $artist = Artist::find($artist_id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $album = $artist->album()->find($id);

        if (!$album) {
            return response()->json(['message' => 'Album not found for this artist'], 404);
        }

        $album->update($request->all());

        return response()->json(['message' => 'Album updated successfully', 'album' => $album]);
    }

    /**
     * @api {patch} /artist/:artist_id/album/:album_id/song/:id Update a song for an artist's album
     * @apiName UpdateArtistAlbumSong
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} artist_id Artist ID.
     * @apiParam {Number} album_id Album ID.
     * @apiParam {Number} id Song ID.
     *
     * @apiBody {String} [name] Song name.
     * @apiBody {String} [lyrics] Song lyrics.
     * @apiBody {String} [songwriter] Songwriter name.
     *
     * @apiSuccess {Object} song Updated song object.
     *
     * @apiError (404) ArtistNotFound The specified artist was not found.
     * @apiError (404) AlbumNotFound The specified album was not found for this artist.
     * @apiError (404) SongNotFound The specified song was not found for this album.
     */
    public function update_song(SongRequest $request, $artist_id, $album_id, $id)
    {

        $artist = Artist::find($artist_id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $album = $artist->album()->find($album_id);

        if (!$album) {
            return response()->json(['message' => 'Album not found for this artist'], 404);
        }

        $song = $album->song()->find($id);

        if (!$song) {
            return response()->json(['message' => 'Song not found for this album'], 404);
        }

        $song->update($request->all());

        return response()->json(['message' => 'Song updated successfully', 'song' => $song]);
    }
     
    /**
     * @api {delete} /artist/:id Delete an artist
     * @apiName DeleteArtist
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Artist ID.
     *
     * @apiSuccess {String} message Confirmation message.
     * @apiSuccess {Number} id Deleted artist ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Artist deleted successfully",
     *       "id": 2
     *     }
     */

    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->delete();
        return response()->json([
        'message' => 'Artist deleted successfully',
        'id' => $id
    ], 410);

    }
    /**
    * @api {delete} /artist/:artist_id/member/:id Delete a member from an artist
    * @apiName DeleteArtistMember
    * @apiGroup Artist
    * @apiVersion 1.0.0
    *
    * @apiParam {Number} artist_id Artist ID.
    * @apiParam {Number} id Member ID.
    *
    * @apiSuccess {String} message Confirmation message.
    * @apiSuccess {Number} id Deleted member ID.
    *
    * @apiError (404) ArtistNotFound The specified artist was not found.
    * @apiError (404) MemberNotFound The specified member was not found for this artist.
    */
    public function destroy_member($artist_id, $id)
    {
        $artist = Artist::find($artist_id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        if ($artist->is_band == "no") {
            return response()->json(['message' => 'Artist is not a band'], 400);
        }

        $member = $artist->member()->find($id);

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        $member->delete();

        return response()->json(['message' => 'Member deleted successfully', 'id' => $id], 410);
    }

    /**
     * @api {delete} /artist/:artist_id/album/:id Delete an album from an artist
     * @apiName DeleteArtistAlbum
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} artist_id Artist ID.
     * @apiParam {Number} id Album ID.
     *
     * @apiSuccess {String} message Confirmation message.
     * @apiSuccess {Number} id Deleted album ID.
     *
     * @apiError (404) ArtistNotFound The specified artist was not found.
     * @apiError (404) AlbumNotFound The specified album was not found for this artist.
     */
    public function destroy_album($artist_id, $id)
    {
        $artist = Artist::find($artist_id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }


        $album = $artist->album()->find($id);

        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        $album->delete();

        return response()->json(['message' => 'Album deleted successfully', 'id' => $id], 410);
    }

    /**
     * @api {delete} /artist/:artist_id/album/:album_id/song/:id Delete a song from an artist's album
     * @apiName DeleteArtistAlbumSong
     * @apiGroup Artist
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} artist_id Artist ID.
     * @apiParam {Number} album_id Album ID.
     * @apiParam {Number} id Song ID.
     *
     * @apiSuccess {String} message Confirmation message.
     * @apiSuccess {Number} id Deleted song ID.
     *
     * @apiError (404) ArtistNotFound The specified artist was not found.
     * @apiError (404) AlbumNotFound The specified album was not found for this artist.
     * @apiError (404) SongNotFound The specified song was not found for this album.
     */
    public function destroy_song($artist_id, $album_id, $id)
    {
        $artist = Artist::find($artist_id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $album = $artist->album()->find($album_id);

        if (!$album) {
            return response()->json(['message' => 'Album not found for this artist'], 404);
        }

        $song = $album->song()->find($id);

        if (!$song) {
            return response()->json(['message' => 'Song not found for this album'], 404);
        }

        $song->delete();

        return response()->json(['message' => 'Song deleted successfully', 'id' => $id], 410);
    }
}
