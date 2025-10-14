<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\MemberRequest;

class MemberController extends Controller
{
    public function index()
    {
        $member = Member::all();
        return response()->json([
            'member' => $member,
        ]);
    }
    public function store(MemberRequest $request)
    {
        $member = Member::create($request->all());

        return response()->json([
            'member' => $member,
        ]);
    }
    public function update(MemberRequest $request, $id)
	{
		$member = Member::findOrFail($id);
		$member->update($request->all());

		return response()->json([
			'member' => $member,
		]);
	} 
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        return response()->json([
            'message' => 'Member deleted successfully',
            'id' => $id
        ]);
    }
}
