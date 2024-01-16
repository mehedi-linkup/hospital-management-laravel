<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Bed;
use App\Models\Branch;
use App\Models\CompanyProfile;
use App\Models\Floor;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use File;

class AdministrationController extends Controller
{

    public function agentEntry()
    {
        return view('admin.agent_entry');
    }

    public function getAgentCode()
    {
        return response()->json(generateAgentCode());
    }

    public function agentStore(Request $request)
    {
        $request->validate([
            'agent_code'         => ['required', 'string', 'unique:agents'],
            'name'               => ['required', 'string', 'max:255'],
            'mobile'             => ['required', 'string', 'size:11'],
            'commission_percent' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $data = (array) $request->all();
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');

            Agent::create($data);

            DB::commit();
            return response()->json(['message' => 'Agent Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function agentUpdate(Request $request)
    {
        $request->validate([
            'id'                 => ['required', 'integer'],
            'agent_code'         => ['required', 'string', Rule::unique('agents')->ignore($request->id, 'id')],
            'name'               => ['required', 'string', 'max:255'],
            'mobile'             => ['required', 'string', 'size:11'],
            'commission_percent' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $data = (array) $request->all();
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            Agent::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Agent Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function agentDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();

        try {
            Agent::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Agent Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getBranchCode()
    {
        return response()->json(generateBranchCode());
    }
    public function getBranches(Request $request)
    {
        $branches = DB::table('branches as a')
            ->whereNull('a.deleted_at');

        if ($request->status) {
            $branches->where('a.status', $request->status);
        }

        if ($request->mobile) {
            $branches->where('a.mobile', $request->mobile);
        }

        if ($request->code) {
            $branches->where('a.code', $request->code);
        }

        $branches->selectRaw("a.*, concat_ws(' - ', a.code, a.name) as display_name");

        $branches =  $branches->orderBy('a.id', 'desc')->lazy();

        return response()->json($branches);
    }
    public function getAgents(Request $request)
    {
        $agents = DB::table('agents as a')
            ->whereNull('a.deleted_at');

        if ($request->status) {
            $agents->where('a.status', $request->status);
        }

        if ($request->mobile) {
            $agents->where('a.mobile', $request->mobile);
        }

        if ($request->agent_code) {
            $agents->where('a.agent_code', $request->agent_code);
        }

        $agents->selectRaw("a.*, concat_ws(' - ', a.agent_code, a.name) as display_name");

        $agents =  $agents->orderBy('a.id', 'desc')->lazy();

        return response()->json($agents);
    }
    public function companyProfile()
    {
        if (!in_array(auth()->user()->role, ['Admin', 'Super Admin']) || session('branch_id') != 1) {
            return redirect()->route('dashboard');
        }
        return view('admin.company_profile');
    }
    public function getCompanies()
    {
        $comapanys = DB::table('company_profiles')->first();

        return response()->json($comapanys);
    }

    public function companyProfileStore(Request $request)
    {
        $request->validate([
            'agent_code'         => ['required', 'string', 'unique:agents'],
            'name'               => ['required', 'string', 'max:255'],
            'mobile'             => ['required', 'string', 'size:11'],
            'commission_percent' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $data = (array) $request->all();
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');

            Agent::create($data);

            DB::commit();
            return response()->json(['message' => 'Agent Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function companyProfileUpdate(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = CompanyProfile::first();
            $logo = $data->logo;
            $path = public_path('images/company_profile_org');
            if (!File::exists($path)) {
                FIle::makeDirectory($path, 0777, true);
            }
            if ($request->hasFile('image')) {
                if (!empty($logo) && file_exists($logo))
                    unlink($logo);
                $data->logo = imageUpload($request, 'image', 'images/company_profile_org');
            }
            $data->name    = $request->name;
            $data->email   = $request->email;
            $data->phone   = $request->phone;
            $data->address = $request->address;
            $data->save();


            DB::commit();
            return response()->json(['message' => 'Company Profile Updated']);
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function branchUpdate(Request $request)
    {


        DB::beginTransaction();

        try {
            $data = Branch::where('id', $request->id)->where('status', 'a')->first();

            $data->name       = $request->name;
            $data->code       = $request->code;
            $data->address    = $request->address;
            $data->updated_by = auth()->user()->id;
            $data->ip_address = $request->ip();
            $data->save();


            DB::commit();
            return response()->json(['message' => 'Branch Update']);
        } catch (\Exception $e) {
            // return $e;
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function branchStore(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = new Branch();
            $data->name       = $request->name;
            $data->code       = $request->code;
            $data->address    = $request->address;
            $data->created_by = auth()->user()->id;
            $data->ip_address = $request->ip();
            $data->save();
            DB::commit();
            return response()->json(['message' => 'Branch Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function branchDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();

        try {
            Branch::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Branch Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    ////Floor Entry

    public function floorEntry()
    {
        return view('admin.floor_entry');
    }
    public function getFloorCode()
    {
        return response()->json(generateFloorCode());
    }


    public function floorStore(Request $request)
    {
        $request->validate([
            'floor_number' => ['required', 'string', 'unique:floors'],
            'floor_name'   => ['required', 'string'],
        ]);

        DB::beginTransaction();

        try {
            $data = (array) $request->all();
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');

            Floor::create($data);

            DB::commit();
            return response()->json(['message' => 'Floor Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function floorUpdate(Request $request)
    {

        $request->validate([
            'id'           => ['required', 'integer'],
            'floor_number' => ['required', 'string', Rule::unique('floors')->ignore($request->id, 'id')],
            'floor_name'   => ['required', 'string'],
        ]);

        DB::beginTransaction();

        try {
            $data = (array) $request->all();
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            Floor::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Floor Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function floorDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();

        try {
            Floor::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Floor Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getFloors(Request $request)
    {
        $floors = DB::table('floors as fr')
            ->selectRaw("fr.*,concat_ws(' - ', fr.floor_number , fr.floor_name) as floor")
            ->whereNull('fr.deleted_at');
            $floors= $floors->orderBy('fr.id', 'desc')
            ->lazy();

        return response()->json($floors);
    }



    /////Room Entry 
    public function roomEntry()
    {
        return view('admin.room_entry');
    }
    
    public function roomStore(Request $request)
    {
        $request->validate([
            'room_number'  => ['required', 'string', 'unique:rooms'],
            'floor_number' => ['required', 'integer'],
        ]);

        DB::beginTransaction();

        try {
            $data = (array) $request->all();
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');

            Room::create($data);

            DB::commit();
            return response()->json(['message' => 'Room Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function roomUpdate(Request $request)
    {
        $request->validate([
            'id'           => ['required', 'integer'],
            'room_number'  => ['required', 'string', Rule::unique('rooms')->ignore($request->id, 'id')],
            'floor_number' => ['required', 'integer']
        ]);

        DB::beginTransaction();

        try {
            $data = (array) $request->all();
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            Room::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Room Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function roomDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();

        try {
            Room::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Room Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getRooms(Request $request)
    {
        $rooms = DB::table('rooms as rm')
            ->selectRaw("rm.*,
                concat_ws(' - ', fr.floor_number , fr.floor_name) as floor,
                concat_ws(' - ',fr.floor_name , rm.room_number) as room_name
            ")
            ->leftJoin('floors as fr', 'fr.id', '=', 'rm.floor_number')
            ->whereNull('rm.deleted_at');
            if($request->is_operation == true && $request->is_operation != ''){
                $rooms = $rooms->where('rm.is_operation',1);
            }
            if($request->is_operation == false && $request->is_operation != ''){
                $rooms = $rooms->where('rm.is_operation',0);
            }
            $rooms= $rooms->orderBy('rm.id', 'desc')
            ->lazy();

        return response()->json($rooms);
    }
    public function seatEntry()
    {
        return view('admin.seat_entry');
    }
    public function seatStore(Request $request)
    {
        //dd($getId);
        
            $request->validate([
                'amount'  => ['required', 'numeric'],
            ]);
       
        
        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');
            
            $getRoomId= Bed::where('room_id',$request->room_id)->where('bed_number',trim($request->bed_number))->first();
            $getId= $getRoomId->id ?? '';
                if($getId == ''){
                    Bed::create($data);
                    DB::commit();
                    return response()->json(['message' => 'Seat Added','success' => '1']);
                }else{
                    DB::commit();
                    return response()->json(['message' => 'Seat Already Inserted','success' => '0']);
                }

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function seatUpdate(Request $request)
    {
        $request->validate([
            'id'         => ['required', 'integer'],
            'amount'     => ['required', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $data = (array) $request->all();
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            $getRoomId= Bed::where('room_id',$request->room_id)
            ->where('bed_number',trim($request->bed_number))
            ->first();
            $getId= $getRoomId->id ?? '';
                if($getId == ''){
                    Bed::where('id', $request->id)->update($data);
                    DB::commit();
                    return response()->json(['message' => 'Seat Updated','success' => '1']);
                }else{
                    Bed::where('id', $request->id)->update([
                        'amount' => $request->amount,
                        'remark' => $request->remark
                    ]);
                    DB::commit();
                    return response()->json(['message' => 'Seat No already Inserted. Data Updated','success' => '1']);
                }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function seatDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();

        try {
            Bed::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Seat Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getSeats(Request $request)
    {
        $seats = DB::table('beds as b')
            ->whereNull('b.deleted_at');
            if($request->id && $request->id !=null){
                $seats->where('b.id', $request->id);
            }
            if($request->roomId && $request->roomId !=null){
                $seats->where('b.room_id', $request->roomId);
            }
            if($request->is_book){
                $seats->where('b.is_book', 0);
            }
            $seats =  $seats->select(DB::raw("b.*, rm.room_number,
            concat_ws(' - ',fr.floor_name , rm.room_number) as room_name,
            concat_ws(' - ',rm.room_number,b.bed_number) as seat_name
            "))
            ->leftJoin('rooms as rm', 'rm.id', '=', 'b.room_id')
            ->leftJoin('floors as fr', 'fr.id', '=', 'rm.floor_number')
            ->orderBy('b.id', 'desc')
            ->lazy();

        return response()->json($seats);
    }

}
