<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\MemberRequest;

class MemberController extends Controller
{
        
    /**
     * @api {get} /member Get all members
     * @apiName GetMembers
     * @apiGroup Member
     * @apiVersion 1.0.0
     *
     * @apiSuccess {Object[]} member List of member objects.
     * @apiSuccess {Number} member.id Member ID.
     * @apiSuccess {String} member.name Member name.
     * @apiSuccess {String} member.instrument Member instrument.
     * @apiSuccess {String} member.year Year joined or active.
     * @apiSuccess {Number} member.artist_id Associated artist ID.
     * @apiSuccess {String} member.image Member image URL.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "member": [
     *         {
     *           "id": 1,
     *           "name": "Alex Turner",
     *           "instrument": "Vocals",
     *           "year": "1986",
     *           "artist_id": 1,
     *           "image": "https://upload.wikimedia.org/wikipedia/commons/thu..."
     *         }
     *       ]
     *     }
     */

    public function index()
    {
        $member = Member::all();
        return response()->json([
            'members' => $member,
        ]);
    }
        
    /**
     * @api {post} /member Create a new member
     * @apiName CreateMember
     * @apiGroup Member
     * @apiVersion 1.0.0
     *
     * @apiBody {String} name Member name.
     * @apiBody {String} instrument Member instrument.
     * @apiBody {String} year Year joined or active.
     * @apiBody {Number} artist_id Associated artist ID.
     * @apiBody {String} image Member image URL.
     *
     * @apiSuccess {Object} member Created member object.
     * @apiSuccess {Number} member.id Member ID.
     * @apiSuccess {String} member.name Member name.
     * @apiSuccess {String} member.instrument Member instrument.
     * @apiSuccess {String} member.year Year joined or active.
     * @apiSuccess {Number} member.artist_id Associated artist ID.
     * @apiSuccess {String} member.image Member image URL.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 201 Created
     *     {
     *       "member": {
     *         "id": 2,
     *         "name": "Freddie Mercury",
     *         "instrument": "Vocals",
     *         "year": "1970",
     *         "artist_id": 1,
     *         "image": "https://example.com/freddie.jpg"
     *       }
     *     }
     */

    public function store(MemberRequest $request)
    {
        $member = Member::create($request->all());

        return response()->json([
            'message' => 'Member created successfully',
            'member' => $member,
        ],201);
    }
        
    /**
     * @api {patch} /member/:id Update a member
     * @apiName UpdateMember
     * @apiGroup Member
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Member ID.
     * @apiBody {String} name Member name.
     * @apiBody {String} instrument Member instrument.
     * @apiBody {String} year Year joined or active.
     * @apiBody {Number} artist_id Associated artist ID.
     * @apiBody {String} image Member image URL.
     *
     * @apiSuccess {Object} member Updated member object.
     * @apiSuccess {Number} member.id Member ID.
     * @apiSuccess {String} member.name Member name.
     * @apiSuccess {String} member.instrument Member instrument.
     * @apiSuccess {String} member.year Year joined or active.
     * @apiSuccess {Number} member.artist_id Associated artist ID.
     * @apiSuccess {String} member.image Member image URL.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "member": {
     *         "id": 2,
     *         "name": "Updated Name",
     *         "instrument": "Updated Instrument",
     *         "year": "2025",
     *         "artist_id": 1,
     *         "image": "https://example.com/updated.jpg"
     *       }
     *     }
     */

    public function update(MemberRequest $request, $id)
	{
		$member = Member::find($id);
        if(empty($member)){
            return response(json_encode(['message'=>"Member not found!"]),404);
        };
		$member->update($request->all());

		return response()->json([
            'message' => 'Member updated successfully',
			'member' => $member,
		]);
	}
        
    /**
     * @api {delete} /member/:id Delete a member
     * @apiName DeleteMember
     * @apiGroup Member
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Member ID.
     *
     * @apiSuccess {String} message Confirmation message.
     * @apiSuccess {Number} id Deleted member ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Member deleted successfully",
     *       "id": 2
     *     }
     */

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        return response()->json([
            'message' => 'Member deleted successfully',
            'id' => $id
        ],410);
    }
}
