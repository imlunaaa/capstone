<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Accreditation;
use App\Models\Member;
use App\Models\AreaMember;
use App\Models\User;
use App\Models\Area;
use DB;

class Roles
{
    public $isCoordinator;
    public $isAreachair;
    public $isAreamember;
    public $isExternal;
    public $isInternal;
}

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        // $members = Member::join()->select()->where('accreditation_id', $id);
        // return view('admin.manage_user')->with('members', $members)->with('id', $id);
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
        $rules = [
            'members'=>'required',
        ];

        $customMessage = [
            'required'=>'select a user to add',
        ];

        $this->validate($request, $rules, $customMessage);

        $acc_members = $request->input('members');
        $acc_id = $request->input('acc_id');

        $members = new Member();
        foreach($acc_members AS $member)
        {
            $members = DB::insert('INSERT INTO `members` (`accreditation_id`, `user_id`, `created_at`, `updated_at`) VALUES ( ?, ?, ?, ?)', [ $acc_id, $member, NOW(), NOW()]);
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
        $uid = Auth::id();
        $members = Member::join('users', 'members.user_id',  '=', 'users.id')->select('users.firstname AS fname', 'users.lastname AS lname', 'members.user_id AS uid', 'members.id AS mid', 'users.*', 'members.*')->where('accreditation_id', $id)->OrderBy('lastname')->get();
        $users = DB::select("SELECT users.*, users.id as user_id, campuses.id as campus_id, campuses.name as campus_name, programs.program as program
        FROM users
        INNER JOIN campuses ON users.campus_id = campuses.id
        INNER JOIN programs ON users.program_id = programs.id
        WHERE user_type != 'admin'
        AND NOT EXISTS (
            SELECT * FROM members
            WHERE accreditation_id = ?
            AND members.user_id = users.id
        )
        ORDER BY lastname ASC;
        ", [$id]);

        $program_id = Accreditation::join('program_levels', 'accreditations.program_level_id', '=', 'program_levels.id')->join('programs', 'program_levels.program_id', '=', 'programs.id')->select('programs.id as prog_id')->where('accreditations.id', $id)->first();

        $areas = Area::join('instruments', 'areas.instrument_id', '=', 'instruments.id')->join('programs', 'instruments.program_id', '=', 'programs.id')->select('areas.*', 'areas.id as aid', 'instruments.*')->where('instruments.program_id', $program_id->prog_id)->OrderBy('areas.area_name')->get();

        $roles = new Roles();
        if(Auth::user()->user_type == 'user'){
            $member = Member::select('*')->where('user_id', $uid)->first();
            $roles->isCoordinator= $member->isCoordination;
            $roles->isAreachair = $member->isAreachair;
            $roles->isAreamember = $member->isAreamember;
            $roles->isExternal = $member->isExternal;
            $roles->isInternal = $member->isInternal;
        }

        $area_members = $result = DB::table('area_members')
        ->join('users', 'area_members.user_id', '=', 'users.id')
        ->select('users.firstname AS fname', 'users.lastname AS lname', 'users.*', 'area_members.*')
        ->where('area_members.accreditation_id', $id)
        ->get();


        $unfilteredUser = User::join('campuses', 'users.campus_id', '=', 'campuses.id')->join('programs', 'users.program_id', '=', 'programs.id')->select('users.*', 'users.id as user_id', 'campuses.id as campus_id', 'campuses.name as campus_name', 'programs.program as program')->where('user_type', '!=', 'admin')->get();
        return view('admin.manage_member')->with('members', $members)->with('id', $id)->with('users', $users)->with('roles', $roles)->with('areas', $areas)->with('unfilteredUser', $unfilteredUser)->with('area_members',$area_members);
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
        $mid = $request->input('id');
        $member = Member::where('id', $id)->update([
            'isAreachair' => $request->input('areachair') == 0 ? 1 : 0,
            'isAreamember' => $request->input('areachair') == 1 ? 1 : 0,
            'isExternal' => $request->has('external') ? 1 : 0,
            'isInternal' => $request->has('internal') ? 1 : 0,
            'isCoordinator' => $request->has('coordinator') ? 1 : 0,
        ]);

        if ($member) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Role updated successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->route('admin.manage_member.show', ['id' => $mid]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($action, $id)
    {
        //
        $member = Member::find($id);
        if($member){
            $member->delete();
            session()->flash('success', 'Member removed successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->back();

    }
}
