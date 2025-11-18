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

    public function store_album(AlbumRequest $request, $id)
    {
        $artist = Artist::find($id);

        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $album = $artist->album()->create($request->all());

        return response()->json(['message' => 'Album created successfully', 'album' => $album], 201);
    }

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
        
	}public function update_member(MemberRequest $request, $artist_id, $id)
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
