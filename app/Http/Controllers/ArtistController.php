<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Http\Requests\ArtistRequest;

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
            'artist' => $artist,
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

        return response()->json([
            'artist' => $artist,
        ]);
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
		$artist = Artist::findOrFail($id);
		$artist->update($request->all());

		return response()->json([
			'artist' => $artist,
		]);
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
        ]);
    }
}
