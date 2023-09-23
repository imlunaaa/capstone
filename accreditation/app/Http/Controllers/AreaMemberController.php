<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaMember;
use DB;

class AreaMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $acc_members = $request->input('members');
        $acc_id = $request->input('acc_id');
        $area_id = $request->input('area_id');
        $type = $request->input('member_type');

        $members = new AreaMember();
        foreach($acc_members AS $member)
        {
            $members = DB::insert('INSERT INTO `area_members` (`id`, `accreditation_id`, `user_id`, `area_id`, `member_type`, `created_at`, `updated_at`) VALUES (NULL, ?, ?, ?, ?, ?, ?)', [ $acc_id, $member, $area_id, $type, NOW(), NOW()]);
        }
        if ($members) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Member/s added successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->route('admin.manage_member.show', ['id'=>$acc_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
