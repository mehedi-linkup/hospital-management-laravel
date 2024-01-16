<?php

namespace App\Http\Controllers;

use App\Models\Ambulance;
use App\Models\AmbulanceBill;
use App\Models\Driver;
use App\Models\OperationSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use File;

class OthersController extends Controller
{

    public function driverEntry()
    {
        return view('admin.others.driver_entry');
    }

    public function driverStore(Request $request)
    {
        $driver = json_decode($request->drivers);

        $validator = Validator::make((array) $driver, [
            'driver_code'    => 'required|string|unique:drivers',
            'name'           => 'required|string|max:255',
            'mobile'         => 'required|string|size:11'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            //dd($request->name);
            $path = public_path('images/driver');
            if ( ! File::exists($path) ) { FIle::makeDirectory($path,0777,true); }
            $data              = New Driver();
            $data->image       = imageUpload($request, 'image' , 'images/driver');
            $data->driver_code = $driver->driver_code;
            $data->name        = $driver->name;
            $data->mobile      = $driver->mobile;
            $data->address     = $driver->address;
            $data->remark      = $driver->remark;
            $data->created_by  = auth()->user()->id;
            $data->ip_address  = $request->ip();
            $data->branch_id   = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Driver Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function driverUpdate(Request $request)
    {
        $driver = json_decode($request->drivers);

        $validator = Validator::make((array) $driver, [
            'id'          => 'required|integer',
            'driver_code' => ['required','string',Rule::unique('drivers')->ignore($driver->id,'id')],
            'name'        => 'required|string|max:255',
            'mobile'      => 'required|string|size:11'
            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        
        try {
            $data=Driver::find($driver->id);
            $image = $data->image;
            $path = public_path('images/driver');
            if ( ! File::exists($path) ) { FIle::makeDirectory($path,0777,true); }
            if ($request->hasFile('image')) {
                if (!empty($image) && file_exists($image)) 
                    unlink($image);
                $data->image = imageUpload($request, 'image', 'images/driver');
            }
            $data->driver_code = $driver->driver_code;
            $data->name        = $driver->name;
            $data->mobile      = $driver->mobile;
            $data->address     = $driver->address;
            $data->remark      = $driver->remark;
            $data->updated_by  = auth()->user()->id;
            $data->ip_address  = $request->ip();
            $data->branch_id   = session('branch_id');
            $data->save(); 
            DB::commit();
            return response()->json(['message' => 'Driver Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function driverDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Driver::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Driver Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getDrivers(Request $request)
    {
        $getDriver = DB::table('drivers as d')
        ->whereNull('d.deleted_at')
        ->selectRaw("d.*,concat_ws(' - ', d.driver_code, d.name) as display_name")
        ->orderBy('d.id', 'desc')->lazy();
        return response()->json($getDriver);
    }
    public function getDriverCode()
    {
        return response()->json(generateDriverCode());
    }
    public function ambulanceEntry()
    {
        return view('admin.others.ambulance_entry');
    }
    public function ambulanceBillEntry()
    {
        $id = 0;
        $code = generateAmbulanceBillCode();
        return view('admin.others.ambulance_bill_entry',compact('code','id'));
    }
    public function ambulanceBillInvoice($id)
    {
        $id = $id;
        return view('admin.others.ambulance_bill_invoice',compact('id'));
    }

    public function ambulanceStore(Request $request)
    {
        $ambulance = json_decode($request->ambulances);

        $validator = Validator::make((array) $ambulance, [
            'vehicle_code' => 'required|string|unique:ambulances',
            'reg_no'       => 'required|string|unique:ambulances',
            'driver_id'    => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            //dd($request->name);
            
            $data              = New Ambulance();

            $data->vehicle_code = $ambulance->vehicle_code;
            $data->reg_no       = $ambulance->reg_no;
            $data->driver_id    = $ambulance->driver_id;
            $data->remark       = $ambulance->remark;
            $data->created_by   = auth()->user()->id;
            $data->ip_address   = $request->ip();
            $data->branch_id    = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Driver Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function ambulanceUpdate(Request $request)
    {
        $ambulance = json_decode($request->ambulances);

        $validator = Validator::make((array) $ambulance, [
            'id'           => 'required|integer',
            'vehicle_code' => ['required','string',Rule::unique('ambulances')->ignore($ambulance->id,'id')],
            'reg_no'       => ['required','string',Rule::unique('ambulances')->ignore($ambulance->id,'id')],
            'driver_id'    => 'required|integer'
            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        
        try {
            $data=Ambulance::find($ambulance->id);
           
            $data->vehicle_code = $ambulance->vehicle_code;
            $data->reg_no       = $ambulance->reg_no;
            $data->driver_id    = $ambulance->driver_id;
            $data->remark       = $ambulance->remark;
            $data->updated_by   = auth()->user()->id;
            $data->ip_address   = $request->ip();
            $data->branch_id    = session('branch_id');
            $data->save(); 
            DB::commit();
            return response()->json(['message' => 'Ambulance Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function ambulanceDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Ambulance::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Ambulance Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getAmbulances(Request $request)
    {

        
        $getAmbulance = DB::table('ambulances as am')
        ->whereNull('am.deleted_at')
        ->selectRaw("am.*,d.name as driver_name,concat_ws(' - ', d.driver_code, d.name) as display_name,concat_ws(' - ', am.vehicle_code, am.reg_no) as display_text")
        ->leftJoin('drivers as d', 'd.id', '=', 'am.driver_id');
        if($request->driverId && $request->driverId !=null){
            $getAmbulance->where('am.driver_id', $request->driverId);
        }
        $getAmbulance= $getAmbulance->orderBy('am.id', 'desc')->lazy();

        return response()->json($getAmbulance);
    }
    public function getAmbulancesbill(Request $request)
    {
        $getAmbulanceBill = DB::table('ambulance_bills as ab')
        ->whereNull('ab.deleted_at')
        ->selectRaw("
                ab.*,
                concat_ws(' - ', d.driver_code, d.name) as driver_name,
                concat_ws(' - ', pt.patient_code, pt.name) as patient_name,
                concat_ws(' - ', am.vehicle_code, am.reg_no) as ambulance_name,
                d.mobile as driver_mobile,
                pt.patient_code,
                pt.name as patient_name,
                pt.mobile as patient_mobile,
                pt.address as patient_address,
                d.address as driver_address,
                am.reg_no,
                u.name as user_name
        ")
        ->leftJoin('drivers as d', 'd.id', '=', 'ab.driver_id')
        ->leftJoin('patients as pt', 'pt.id', '=', 'ab.patient_id')
        ->leftJoin('ambulances as am', 'am.id', '=', 'ab.ambulance_id')
        ->leftJoin('users as u', 'u.id', '=', 'ab.created_by');
        if($request->id && $request->id !=null){
            $getAmbulanceBill->where('ab.id', $request->id);
        }
        if($request->driverId && $request->driverId !=null){
            $getAmbulanceBill->where('ab.driver_id', $request->driverId);
        }
        if($request->patientId && $request->patientId !=null){
            $getAmbulanceBill->where('ab.patient_id', $request->patientId);
        }
        if($request->ambulanceId && $request->ambulanceId !=null){
            $getAmbulanceBill->where('ab.ambulance_id', $request->ambulanceId);
        }
        if($request->date && $request->date != ''){
            $getAmbulanceBill->whereDate('ab.bill_date', $request->date);
        }
        $getAmbulanceBill= $getAmbulanceBill->orderBy('ab.id', 'desc')->lazy();

        return response()->json($getAmbulanceBill);
    }
    public function getAmbulanceCode()
    {
        return response()->json(generateAmbulanceCode());
    }


    public function ambulanceBillStore(Request $request)
    {
        $ambulancebill = $request->ambulancebill;

        $validator = Validator::make((array) $ambulancebill, [
            'invoice_number' => 'required|string|unique:ambulance_bills',
            'driver_id'      => 'required|integer',
            'ambulance_id'   => 'required|integer',
            'patient_id'     => 'required|integer',
            'bill_date'      => 'required|date',
            'bill_amount'    => 'required|numeric',
            'paid'           => 'required|numeric',
            'due'            => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data                 = New AmbulanceBill();
            $data->invoice_number = $ambulancebill['invoice_number'];
            $data->driver_id      = $ambulancebill['driver_id'];
            $data->ambulance_id   = $ambulancebill['ambulance_id'];
            $data->patient_id     = $ambulancebill['patient_id'];
            $data->bill_date      = $ambulancebill['bill_date'];
            $data->bill_amount    = $ambulancebill['bill_amount'];
            $data->paid           = $ambulancebill['paid'];
            $data->due            = $ambulancebill['due'];
            $data->destination    = $ambulancebill['destination'];
            $data->remark         = $ambulancebill['remark'];
            $data->created_by     = auth()->user()->id;
            $data->ip_address     = $request->ip();
            $data->branch_id      = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Ambulance Bill Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function ambulanceBillUpdate(Request $request)
    {
        $ambulancebill = $request->ambulancebill;

        $validator = Validator::make((array) $ambulancebill, [
            'id'             => 'required|integer',
            'invoice_number' => ['required','string',Rule::unique('ambulance_bills')->ignore($ambulancebill['id'],'id')],
            'driver_id'      => 'required|integer',
            'ambulance_id'   => 'required|integer',
            'patient_id'     => 'required|integer',
            'bill_date'      => 'required|date',
            'bill_amount'    => 'required|numeric',
            'paid'           => 'required|numeric',
            'due'            => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data                 = AmbulanceBill::find($ambulancebill['id']);
            $data->invoice_number = $ambulancebill['invoice_number'];
            $data->driver_id      = $ambulancebill['driver_id'];
            $data->ambulance_id   = $ambulancebill['ambulance_id'];
            $data->patient_id     = $ambulancebill['patient_id'];
            $data->bill_date      = $ambulancebill['bill_date'];
            $data->bill_amount    = $ambulancebill['bill_amount'];
            $data->paid           = $ambulancebill['paid'];
            $data->due            = $ambulancebill['due'];
            $data->destination    = $ambulancebill['destination'];
            $data->remark         = $ambulancebill['remark'];
            $data->created_by     = auth()->user()->id;
            $data->ip_address     = $request->ip();
            $data->branch_id      = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Ambulance Bill Updated','code'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function ambulanceBillDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            AmbulanceBill::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Ambulance Bill Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function otScheduleEntry()
    {
        $code = generateOtScheduleCode();
        return view('admin.others.ot_schedule_entry',compact('code'));
    }

    public function getOtRoomStatus(Request $request)
    {
        $date= \Carbon\Carbon::parse($request->fromdate);
        //dd($date);
        $roomAvaliable = checkOtRoom($request->roomId,$request->seatId,$request->fromdate,$request->todate);
        return response()->json($roomAvaliable);
    }

    public function otScheduleStore(Request $request)
    {
        $schedule = $request->schedules;

        $validator = Validator::make((array) $schedule, [
            'schedule_code' => 'required|string|unique:operation_schedules',
            'doctor_id'     => 'required|integer',
            'room_id'       => 'required|integer',
            'bed_id'        => 'required|integer',
            'patient_id'    => 'required|integer',
            'bill_date'     => 'required|date',
            'fromdate'      => 'required',
            'todate'        => 'required',
            'amount'        => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            

            $data                = New OperationSchedule();
            $data->schedule_code = $schedule['schedule_code'];
            $data->bill_date     = $schedule['bill_date'];
            $data->doctor_id     = $schedule['doctor_id'];
            $data->patient_id    = $schedule['patient_id'];
            $data->room_id       = $schedule['room_id'];
            $data->bed_id        = $schedule['bed_id'];
            $data->time_from     = $schedule['fromdate'];
            $data->time_to       = $schedule['todate'];
            $data->amount        = $schedule['amount'];
            $data->is_done       = $schedule['is_done'];
            $data->remark        = $schedule['remark'];
            $data->created_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 

            DB::commit();

            return response()->json(['message' => 'OT Schedule Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getOtSchedule(Request $request)
    {
        $getOtSchedule = DB::table('operation_schedules as ots')
        ->whereNull('ots.deleted_at')
        ->selectRaw("
                ots.*,
                b.id as bed_id,
                b.bed_number,
                concat_ws(' - ', d.doctor_code, d.name) as doctor_name,
                concat_ws(' - ', pt.patient_code, pt.name) as patient_name,
                concat_ws(' - ',fr.floor_name , rm.room_number) as room_name,
                u.name as user_name
        ")
        ->leftJoin('doctors as d', 'd.id', '=', 'ots.doctor_id')
        ->leftJoin('patients as pt', 'pt.id', '=', 'ots.patient_id')
        ->leftJoin('rooms as rm', 'rm.id', '=', 'ots.room_id')
        ->leftJoin('floors as fr', 'fr.id', '=', 'rm.floor_number')
        ->leftJoin('beds as b', 'b.id', '=', 'ots.bed_id')
        ->leftJoin('users as u', 'u.id', '=', 'ots.created_by');
        if($request->is_pending){
            $getOtSchedule->where('ots.is_done', 0);
        }
        if($request->is_complete){
            $getOtSchedule->where('ots.is_done', 1);
        }
        if($request->id && $request->id !=null){
            $getOtSchedule->where('ots.id', $request->id);
        }
        if($request->doctorId && $request->doctorId !=null){
            $getOtSchedule->where('ots.doctor_id', $request->doctorId);
        }
        if($request->patientId && $request->patientId !=null){
            $getOtSchedule->where('ots.patient_id', $request->patientId);
        }
        if($request->roomId && $request->roomId !=null){
            $getOtSchedule->where('ots.room_id', $request->roomId);
        }
        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $getOtSchedule->whereBetween('ots.bill_date', [$request->dateFrom,$request->dateTo]);
        }
        if($request->date && $request->date != ''){
            $getOtSchedule->whereDate('ots.bill_date', $request->date);
        }
        $getOtSchedule= $getOtSchedule->orderBy('ots.id', 'desc')->lazy();

        return response()->json($getOtSchedule);
    }

    public function otScheduleDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            OperationSchedule::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Schedule Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function otScheduleUpdate(Request $request)
    {
        $schedule = $request->schedules;
        $oldSeat = $request->oldSeat;

        $validator = Validator::make((array) $schedule, [
            'id'             => 'required|integer',
            'schedule_code' => ['required','string',Rule::unique('operation_schedules')->ignore($schedule['id'],'id')],
            'doctor_id'     => 'required|integer',
            'room_id'       => 'required|integer',
            'bed_id'        => 'required|integer',
            'patient_id'    => 'required|integer',
            'bill_date'     => 'required|date',
            'fromdate'      => 'required',
            'todate'        => 'required',
            'amount'        => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {

            $data                = OperationSchedule::find($schedule['id']);
            $data->schedule_code = $schedule['schedule_code'];
            $data->bill_date     = $schedule['bill_date'];
            $data->doctor_id     = $schedule['doctor_id'];
            $data->patient_id    = $schedule['patient_id'];
            $data->room_id       = $schedule['room_id'];
            $data->bed_id        = $schedule['bed_id'];
            $data->time_from     = $schedule['fromdate'];
            $data->time_to       = $schedule['todate'];
            $data->amount        = $schedule['amount'];
            $data->is_done       = $schedule['is_done'];
            $data->remark        = $schedule['remark'];
            $data->updated_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'OT Schedule Update']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function otSchedulePendingList()
    {

        return view('admin.others.ot_schedule_pending_list');
    }
    

    public function pendingCompleteSchedule(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            if($request->is_pending){
                OperationSchedule::where('id', $request->id)->update(['is_done' => 0]);
                DB::commit();
                return response()->json(['message' => 'Schedule Pending']);
            }elseif($request->is_complete){
                OperationSchedule::where('id', $request->id)->update(['is_done' => 1]);
                DB::commit();
                return response()->json(['message' => 'Schedule Complete']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function otScheduleCompleteList()
    {

        return view('admin.others.ot_schedule_complete_list');
    }

    public function getScheduleCode()
    {
        return response()->json(generateOtScheduleCode());
    }



}
