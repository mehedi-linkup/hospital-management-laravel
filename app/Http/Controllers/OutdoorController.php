<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bed;
use App\Models\Bill;
use App\Models\Patient;
use App\Models\BedShift;
use App\Models\BillType;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Floor;
use App\Models\ReleaseSlip;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OutdoorController extends Controller
{
    public function outdoorPatient()
    {
        return view('admin.patient.outdoor_patient');
    }

    public function patientAdmission()
    {
        $code=generateAdmissionCode();
        return view('admin.patient.patient_admission',compact('code'));
    }
    public function patientSeatShift()
    {
        return view('admin.patient.patient_seat_shift');
    }

    public function billEntry()
    {
        $id=0;
        $code=generateBillsTransactionCode();
        return view('admin.patient.bill_entry',compact('code','id'));
    }

    public function billInvoice($id)
    {
        $id = $id;
        return view('admin.patient.bill_invoice',compact('id'));
    }

    public function appointmentReport()
    {
        return view('admin.patient.appointment_report');
    }

    public function appointmentToken($id)
    {
        if(!checkPermissions('outdoor_patient')){
            return redirect()->route('dashboard');
        }
        return view('admin.patient.appointment_token', compact('id'));
    }

    public function getAppointmentTrId()
    {
        return response()->json(generateAppointmentTrId());
    }

    public function getAppointmentSerialNumber(Request $request)
    {
        $serial_number = 1;

        $total_count = DB::table('appointments')->whereDate('appointment_date', $request->date)->whereDoctorId($request->doctor_id)->count();

        if($total_count > 0){
            $serial_number = ++$total_count;
        }

        return response()->json($serial_number);
    }

    public function addAppointment(Request $request)
    {
        DB::beginTransaction();
        try{
            $patient = $request->patient;

            $appointment = $request->appointment;            

            $validator = Validator::make($patient, [
                'name'          => 'required|string|max:255',
                'mobile'        => 'required|string|size:11',
                'gender'        => 'required|in:Male,Female,Other',
                'date_of_birth' => 'required|date'
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $validator = Validator::make($appointment, [
                'token_number'     => 'required|string|unique:appointments,token_number',
                'serial_number'    => 'required|integer',
                'appointment_date' => 'required|date',
                'doctor_id'        => 'required|integer',
                'fees'             => 'required|numeric',
                'reference_id'     => 'nullable|integer',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            unset($patient['year'], $patient['month'], $patient['day']);

            if($patient['id'] != ''){
                $patient_id = $patient['id'];
                $patient['updated_by']  = auth()->user()->id;
                $patient['ip_address']  = $request->ip();

                Patient::where('id', $patient_id)->update($patient);
            }else{
                $patient['created_by']  = auth()->user()->id;
                $patient['ip_address']  = $request->ip();
                $patient['branch_id']  = session('branch_id');

                $patient = Patient::create($patient);
                $patient_id = $patient->id;
            }

            $appointment['patient_id'] = $patient_id;
            $appointment['created_by']  = auth()->user()->id;
            $appointment['ip_address']  = $request->ip();
            $appointment['branch_id']  = session('branch_id');

            Appointment::create($appointment);

            DB::commit();
            return response()->json(['message' => 'Appointment created!']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }


    public function updateAppointment(Request $request)
    {
        DB::beginTransaction();
        try{
            $patient = $request->patient;

            $appointment = $request->appointment;            

            $validator = Validator::make($patient, [
                'name'          => 'required|string|max:255',
                'mobile'        => 'required|string|size:11',
                'gender'        => 'required|in:Male,Female,Other',
                'date_of_birth' => 'required|date'
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $validator = Validator::make($appointment, [
                'id'               => 'required|integer',
                'token_number'     => 'required|string|unique:appointments,token_number,'.$appointment['id'],
                'serial_number'    => 'required|integer',
                'appointment_date' => 'required|date',
                'doctor_id'        => 'required|integer',
                'fees'             => 'required|numeric',
                'reference_id'     => 'nullable|integer',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            unset($patient['year'], $patient['month'], $patient['day']);

            if($patient['id'] != ''){
                $patient_id = $patient['id'];
                $patient['updated_by']  = auth()->user()->id;
                $patient['ip_address']  = $request->ip();

                Patient::where('id', $patient_id)->update($patient);
            }else{
                $patient['created_by']  = auth()->user()->id;
                $patient['ip_address']  = $request->ip();
                $patient['branch_id']  = session('branch_id');

                $patient = Patient::create($patient);
                $patient_id = $patient->id;
            }

            $appointment['patient_id'] = $patient_id;
            $appointment['updated_by'] = auth()->user()->id;
            $appointment['ip_address'] = $request->ip();

            Appointment::where('id', $appointment['id'])->update($appointment);

            DB::commit();
            return response()->json(['message' => 'Appointment Updated!']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function appointmentDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Appointment::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Appointment Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    //// Bill type
    public function billtypeEntry()
    {
        return view('admin.patient.billtype_entry');
    }

    public function billtypeStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['created_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();
            $data['branch_id']  = session('branch_id');

            BillType::create($data);

            DB::commit();
            return response()->json(['message' => 'Bill Type Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function billtypeUpdate(Request $request)
    {
        $request->validate([
            'id'   => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['updated_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();

            BillType::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Bill Type Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function billtypeDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            BillType::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Bill Type Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getBilltypes(Request $request)
    {
        $billtype = DB::table('bill_types as a')
        ->whereNull('a.deleted_at')
        ->select("a.*")
        ->orderBy('a.id', 'desc')->lazy();

        return response()->json($billtype);
    }




///////////

    public function getAppointments(Request $request)
    {
        $clauses = "";

        if($request->date && $request->date != ''){
            $clauses .= " and a.appointment_date = '$request->date'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and a.appointment_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->doctor_id && $request->doctor_id != ''){
            $clauses .= " and a.doctor_id = '$request->doctor_id'";
        }

        if($request->patient_id && $request->patient_id != ''){
            $clauses .= " and a.patient_id = '$request->patient_id'";
        }

        if($request->reference_id && $request->reference_id != ''){
            $clauses .= " and a.reference_id = '$request->reference_id'";
        }

        if($request->status && $request->status != ''){
            $clauses .= " and a.status = '$request->status'";
        }

        if($request->id && $request->id != ''){
            $clauses .= " and a.id = '$request->id'";
        }
        
        $result = DB::select(
            "SELECT a.*,

            /*patient section start*/
            p.name as patient_name,
            p.mobile as patient_mobile,
            p.patient_code,
            p.gender as patient_gender,
            p.address as patient_address,
            p.remark as patient_remark,
            p.date_of_birth as patient_date_of_birth,

            @_total_days := TIMESTAMPDIFF(DAY, p.date_of_birth, now()),
            @_year := FLOOR(@_total_days / 365),
            @_month := FLOOR((@_total_days - (@_year * 365)) / 30),
            @_day :=  @_total_days - ((@_year * 365) + (@_month * 30)),

            @_total_days as patient_age_total_days,
            @_year as patient_age_year,
            @_month as patient_age_month,
            @_day as patient_age_day,

            (
                SELECT 
                    CONCAT(
                        CASE 
                            WHEN @_year THEN CONCAT( @_year, ' years ')
                            ELSE ''
                        END,

                        CASE 
                            WHEN @_month > 0 THEN CONCAT( @_month, ' months ')
                            ELSE ''
                        END,

                        CASE 
                            WHEN @_day > 0 THEN CONCAT( @_day, ' days')
                            ELSE ''
                        END
                    )
            ) as patient_age,
            /*patient section end*/

            d.name as doctor_name,
            d.doctor_code,
            concat_ws(' - ', d.doctor_code, d.name) as doctor_display_name,

            ag.name as reference_name,
            ag.agent_code as reference_code,
            ag.commission_percent,
            concat_ws(' - ', ag.agent_code, ag.name) as reference_display_name

            from appointments a
            left join patients p on p.id = a.patient_id
            left join doctors d on d.id = a.doctor_id
            left join agents ag on ag.id = a.reference_id
            where a.deleted_at is null
            $clauses
            order by a.id desc
        ");

        return response()->json($result);
    }
    public function getAdmissions(Request $request)
    {
        $clauses = "";

        if($request->date && $request->date != ''){
            $clauses .= " and a.admission_date = '$request->date'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and a.admission_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->doctor_id && $request->doctor_id != ''){
            $clauses .= " and a.doctor_id = '$request->doctor_id'";
        }
        if($request->room_id && $request->room_id != ''){
            $clauses .= " and a.room_id = '$request->room_id'";
        }
        if($request->seat_id && $request->seat_id != ''){
            $clauses .= " and a.bed_id = '$request->bed_id'";
        }

        if($request->patient_id && $request->patient_id != ''){
            $clauses .= " and a.patient_id = '$request->patient_id'";
        }

        if($request->reference_id && $request->reference_id != ''){
            $clauses .= " and a.reference_id = '$request->reference_id'";
        }

        if($request->status && $request->status != ''){
            $clauses .= " and a.status = '$request->status'";
        }

        if($request->id && $request->id != ''){
            $clauses .= " and a.id = '$request->id'";
        }
        
        $result = DB::select(
            "SELECT a.*,
            /*patient section start*/
            p.name as patient_name,
            p.mobile as patient_mobile,
            p.patient_code,
            p.gender as patient_gender,
            p.address as patient_address,
            p.remark as patient_remark,
            p.date_of_birth as patient_date_of_birth,
            concat_ws(' - ', a.admission_code , p.name, p.mobile) as admission_name,
            concat_ws(' - ', d.doctor_code, d.name) as doctor_display_name,
            concat_ws(' - ', ag.agent_code, ag.name) as reference_display_name,
            concat_ws(' - ', rm.room_number, fr.floor_name) as room_name,
            b.bed_number,
            @_total_days := TIMESTAMPDIFF(DAY, p.date_of_birth, now()),
            @_year := FLOOR(@_total_days / 365),
            @_month := FLOOR((@_total_days - (@_year * 365)) / 30),
            @_day :=  @_total_days - ((@_year * 365) + (@_month * 30)),

            @_total_days as patient_age_total_days,
            @_year as patient_age_year,
            @_month as patient_age_month,
            @_day as patient_age_day,

            (
                SELECT 
                    CONCAT(
                        CASE 
                            WHEN @_year THEN CONCAT( @_year, ' years ')
                            ELSE ''
                        END,

                        CASE 
                            WHEN @_month > 0 THEN CONCAT( @_month, ' months ')
                            ELSE ''
                        END,

                        CASE 
                            WHEN @_day > 0 THEN CONCAT( @_day, ' days')
                            ELSE ''
                        END
                    )
            ) as patient_age

            from admissions a
            left join patients p on p.id = a.patient_id
            left join beds b on b.id = a.bed_id
            left join rooms rm on rm.id = a.room_id
            left join floors fr on fr.id = rm.floor_number
            left join doctors d on d.id = a.doctor_id
            left join agents ag on ag.id = a.reference_id
            where a.deleted_at is null
            $clauses
            order by a.id desc
        ");

        return response()->json($result);
    }
    public function getAdmissionsSeat(Request $request)
    {

        $clauses = "";

       
        if($request->id && $request->id != ''){
            $clauses .= " and id = '$request->id'";
        }

        $order = "sequence desc";
        
        $result = DB::select(
            "SELECT * from(
                select 
                'a' as sequence,
                a.id as id,
                0 as bs_id,
                a.bed_id as bed_id,
                a.room_id as room_id,
                a.status as status,
                rm.room_number as room_name,
                b.bed_number
                from admissions a
                left join beds b on b.id = a.bed_id
                left join rooms rm on rm.id = a.room_id
                where a.deleted_at is null
                and a.branch_id  = ?
                UNION
                    select
                    'b' as sequence,
                    a.id as id,
                    bs.id as bs_id,
                    bs.to_bed_id as bed_id,
                    bs.to_room_id as room_id,
                    a.status as status,
                    rm.room_number as room_name,
                    b.bed_number
                    from bed_shifts bs
                    left join admissions a on a.id = bs.admission_id
                    left join beds b on b.id = bs.to_bed_id
                    left join rooms rm on rm.id = bs.to_room_id
                    where bs.deleted_at is null
                    and bs.branch_id  = ?
                    order by bs_id desc
            ) as tbl
            where 1 = 1 $clauses
            order by $order
        ",[session('branch_id'),session('branch_id')]);

        return response()->json($result);
    }
 
    public function admissionStore(Request $request)
    {
        DB::beginTransaction();
        try{
            
            $admission = $request->admission;           
            $validator = Validator::make($admission, [
                'admission_code'  => 'required|string|unique:admissions',
                'admission_date'  => 'required|date',
                'doctor_id'       => 'required|integer',
                'patient_id'      => 'required|integer',
                'doctor_id'       => 'required|integer',
                'room_id'         => 'required|integer',
                'bed_id'          => 'required|integer',
                'bed_rent'        => 'required|numeric',
                'received_amount' => 'required|numeric',
                'reference_id'    => 'nullable|integer',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $checkAdmited=  Admission::where('patient_id',$admission['patient_id'])->where('status','Admited');
            
            if($checkAdmited->count() !=0){
                DB::commit();
                return response()->json(['success'=>false,'message' => 'Patient Already Admited!!']);
            }else{
                
                $admission['created_by'] = auth()->user()->id;
                $admission['ip_address'] = $request->ip();
                $admission['branch_id']  = session('branch_id');
                Admission::create($admission);
                DB::statement("
                    update beds set 
                    is_book = 1 
                    where id = ? 
                    and branch_id = ?
                ", [$admission['bed_id'], session('branch_id')]);
                //Bed::where('id',$admission['bed_id'])->update('is_book',1);
                DB::commit();
                return response()->json(['success'=>true,'message' => 'Admission created!']);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function admissionUpdate(Request $request)
    {
        DB::beginTransaction();
        try{
            
            $admission = $request->admission;           
            $validator = Validator::make($admission, [
            'admission_code'  => ['required','string',Rule::unique('admissions')->ignore($admission['id'],'id')],
            'admission_date'  => 'required|date',
            'doctor_id'       => 'required|integer',
            'patient_id'      => 'required|integer',
            'doctor_id'       => 'required|integer',
            'room_id'         => 'required|integer',
            'bed_id'          => 'required|integer',
            'bed_rent'        => 'required|numeric',
            'received_amount' => 'required|numeric',
            'reference_id'    => 'nullable|integer',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $olddata=Admission::where('id',$admission['id'])->first();


            if($olddata->patient_id == $admission['patient_id']){
                    $admission['created_by'] = auth()->user()->id;
                    $admission['ip_address'] = $request->ip();
                    $admission['branch_id']  = session('branch_id');
                    Admission::where('id', $admission['id'])->update($admission);
                    DB::statement("
                        update beds set 
                        is_book = 0 
                        where id = ? 
                        and branch_id = ?
                    ", [$olddata->bed_id, session('branch_id')]);
                    DB::statement("
                        update beds set 
                        is_book = 1 
                        where id = ? 
                        and branch_id = ?
                    ", [$admission['bed_id'], session('branch_id')]);
                    DB::commit();
                    return response()->json(['success'=>true,'message' => 'Admission Updated!']);
            }else{
                $checkAdmited=  Admission::where('patient_id',$admission['patient_id'])->where('status','Admited');
                if($checkAdmited->count() !=0){
                    DB::commit();
                    return response()->json(['success'=>false,'message' => 'Patient Already Admited!!']);
                }else{
                    $admission['created_by'] = auth()->user()->id;
                    $admission['ip_address'] = $request->ip();
                    $admission['branch_id']  = session('branch_id');
                    Admission::where('id', $admission['id'])->update($admission);
                    DB::statement("
                        update beds set 
                        is_book = 0 
                        where id = ? 
                        and branch_id = ?
                    ", [$olddata->bed_id, session('branch_id')]);
                    DB::statement("
                        update beds set 
                        is_book = 1 
                        where id = ? 
                        and branch_id = ?
                    ", [$admission['bed_id'], session('branch_id')]);
                    DB::commit();
                    return response()->json(['success'=>true,'message' => 'Admission Updated!']);
                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function admissionDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {

            $prevoiusAdmission= Admission::where('id',$request->id)->where('is_shift',0)->first();
         
            DB::statement("
                    update beds set 
                    is_book = 0
                    where id = ?
                    and branch_id = ?
            ", [$prevoiusAdmission->bed_id, session('branch_id')]);
           
            Admission::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Admission Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }



    public function getBills(Request $request)
    {
        $clauses = "";

        if($request->date && $request->date != ''){
            $clauses .= " and b.bill_date = '$request->date'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and b.bill_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->billTypeId && $request->billTypeId != ''){
            $clauses .= " and b.bill_type_id = '$request->billTypeId'";
        }
        
        if($request->patient_id && $request->patient_id != ''){
            $clauses .= " and b.patient_id = '$request->patient_id'";
        }

        if($request->userId && $request->userId != ''){
            $clauses .= " and b.created_by = '$request->userId'";
        }

        if($request->id && $request->id != ''){
            $clauses .= " and b.id = '$request->id'";
        }
      
        $result = DB::select(
            "SELECT b.*,
            p.patient_code,
            p.name as patient_name,
            p.address as patient_address,
            p.mobile as patient_mobile,
            bt.name as bill_type_name,
            a.admission_code,
            a.status as admission_status,
            u.name as user_name,
            concat_ws(' - ', p.patient_code, p.name) as patient_display_name
            
            from bills b
            left join patients p on p.id = b.patient_id
            left join bill_types bt on bt.id = b.bill_type_id
            left join admissions a on a.id = b.admission_id
            left join users u on u.id = b.created_by
            where b.deleted_at is null
            $clauses
            order by b.id desc
        ");

        return response()->json($result);
    }

    public function billStore(Request $request)
    {

        $bill = json_decode($request->bills);
        $validator = Validator::make((array) $bill, [
            'transaction_number' => 'required|string|unique:bills',
            'bill_type_id'       => 'required|integer',
            'bill_date'          => 'required|date',
            'patient_id'         => 'required|integer',
            'transaction_type'   => 'required|string',
            'amount'             => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $admissiontId= Admission::where('patient_id',$bill->patient_id)->where('status','Admited')->first();
            $data                     = New Bill();
            $data->transaction_number = $bill->transaction_number;
            $data->bill_type_id       = $bill->bill_type_id;
            $data->bill_date          = $bill->bill_date;
            $data->patient_id         = $bill->patient_id;
            $data->transaction_type   = $bill->transaction_type;
            if($admissiontId){
                $data->admission_id       = $admissiontId->id;
            }else{
                $data->admission_id       = null;
            }
            $data->amount             = $bill->amount;
            $data->remark             = $bill->remark;
            $data->created_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Bills Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function billUpdate(Request $request)
    {

        $bill = json_decode($request->bills);
        $validator = Validator::make((array) $bill, [
            'transaction_number' => ['required','string',Rule::unique('bills')->ignore($bill->id,'id')],
            'bill_type_id'       => 'required|integer',
            'bill_date'          => 'required|date',
            'patient_id'         => 'required|integer',
            'transaction_type'   => 'required|string',
            'amount'             => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $admissiontId= Admission::where('patient_id',$bill->patient_id)->where('status','Admited')->first();

            $data                     = Bill::find($bill->id);
            $data->transaction_number = $bill->transaction_number;
            $data->bill_type_id       = $bill->bill_type_id;
            $data->bill_date          = $bill->bill_date;
            $data->patient_id         = $bill->patient_id;
            $data->transaction_type   = $bill->transaction_type; 
            if($admissiontId && $admissiontId->status == "Admited"){
                $data->admission_id       = $admissiontId->id;
            }else{
                $data->admission_id       = null;
            }
            $data->amount             = $bill->amount;
            $data->remark             = $bill->remark;
            $data->created_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Bills Updated','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function billDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Bill::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Bill Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }


    public function getSeatShift(Request $request)
    {
        $clauses = "";

        if($request->date && $request->date != ''){
            $clauses .= " and bs.shift_date = '$request->date'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and bs.shift_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->admission_id && $request->admission_id != ''){
            $clauses .= " and bd.admission_id = '$request->admission_id'";
        }
        if($request->room_id && $request->room_id != ''){
            $clauses .= " and bs.to_room_id = '$request->room_id'";
        }
        if($request->seat_id && $request->seat_id != ''){
            $clauses .= " and bs.to_bed_id  = '$request->bed_id'";
        }

        if($request->patient_id && $request->patient_id != ''){
            $clauses .= " and bs.patient_id = '$request->patient_id'";
        }

        if($request->status && $request->status != ''){
            $clauses .= " and a.status = '$request->status'";
        }

        if($request->id && $request->id != ''){
            $clauses .= " and bs.id = '$request->id'";
        }
        
        $result = DB::select(
            "SELECT bs.*,
            /*patient section start*/
            a.admission_code,
            p.name as patient_name,
            p.mobile as patient_mobile,
            DATEDIFF(IF(bs.bed_release_date,bs.bed_release_date,DATE_ADD(CURDATE(), INTERVAL 1 DAY)),bs.shift_date) as no_of_day,
            p.patient_code,
            p.gender as patient_gender,
            p.address as patient_address,
            p.remark as patient_remark,
            p.date_of_birth as patient_date_of_birth,
            concat_ws(' - ', a.admission_code , p.name, p.mobile) as admission_name,
            concat_ws(' - ', p.patient_code , p.name) as patient_name,
            concat_ws(' - ', frm.room_number, ffr.floor_name) as from_room_name,
            concat_ws(' - ', trm.room_number, tfr.floor_name) as to_room_name,
            fb.bed_number as from_bed_name,
            tb.bed_number as to_bed_name
            
            from bed_shifts bs
            left join admissions a on a.id = bs.admission_id
            left join patients p on p.id = bs.patient_id
            left join beds fb on fb.id = bs.from_bed_id
            left join rooms frm on frm.id = bs.from_room_id
            left join floors ffr on ffr.id = frm.floor_number
            left join beds tb on tb.id = bs.to_bed_id 
            left join rooms trm on trm.id = bs.to_room_id
            left join floors tfr on tfr.id = trm.floor_number
            where bs.deleted_at is null
            $clauses
            order by bs.id desc
        ");

        return response()->json($result);
    }

    public function seatShiftStore(Request $request)
    {
        $seatshift = $request->seatshift;
       

        $validator = Validator::make((array) $seatshift, [
            'admission_id'   => 'required|integer',
            'patient_id'     => 'required|integer',
            'shift_date'     => 'required|date',
            'from_room_id'   => 'required|integer',
            'from_bed_id'    => 'required|integer',
            'to_room_id'     => 'required|integer',
            'to_bed_id'      => 'required|integer',
            'bed_rent'       => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            
            if($seatshift['shift_time'] < "14:00"){
                $previouseShiftdate = Carbon::createFromFormat('Y-m-d', $seatshift['shift_date']);
                
            }else{
                $previouseShiftdate = Carbon::createFromFormat('Y-m-d', $seatshift['shift_date']);
                $previouseShiftdate = $previouseShiftdate->addDay(); // Subtracts 1 day
            }

            $countSeatShift= BedShift::where('admission_id',$seatshift['admission_id'])->count();
            if($countSeatShift == 0){
               
                DB::statement("
                    update admissions set 
                    is_shift = 1, 
                    bed_release_date = ? 
                    where id = ? 
                    and branch_id = ?
                    ", [$previouseShiftdate,$seatshift['admission_id'], session('branch_id')]);
                
            }else{
                $getLastSeatShift= BedShift::where('admission_id',$seatshift['admission_id'])->whereNull('deleted_at')->orderBy('id','desc')->first();
                    if($seatshift['shift_time'] < "14:00"){
                        $previousedate = Carbon::createFromFormat('Y-m-d', $seatshift['shift_date']);
                        
                    }else{
                        $previousedate = Carbon::createFromFormat('Y-m-d', $seatshift['shift_date']);
                        $previousedate = $previouseShiftdate->subDay(); // Subtracts 1 day
                    }
                    
                    DB::statement("
                    update bed_shifts set 
                    is_shift = 1, 
                    bed_release_date = ? 
                    where id = ? 
                    and branch_id = ?
                ", [$previouseShiftdate,$getLastSeatShift->id, session('branch_id')]);
                
            }

            $data               = New BedShift();
            $data->admission_id = $seatshift['admission_id'];
            $data->patient_id   = $seatshift['patient_id'];
            if($seatshift['shift_time'] < "14:00"){
                $previousedate = Carbon::createFromFormat('Y-m-d', $seatshift['shift_date']);
               
                $data->shift_date   = $previousedate ;
                $data->shift_time   = $seatshift['shift_time'];
            }else{
                $previousedate = Carbon::createFromFormat('Y-m-d', $seatshift['shift_date']);
                $previousedate = $previousedate->addDay(); // add 1 day
                $data->shift_date   = $previousedate ;
                $data->shift_time   = '00:00:00';
            }
            $data->from_room_id = $seatshift['from_room_id'];
            $data->from_bed_id  = $seatshift['from_bed_id'];
            $data->to_room_id   = $seatshift['to_room_id'];
            $data->to_bed_id    = $seatshift['to_bed_id'];
            $data->bed_rent     = $seatshift['bed_rent'];
            $data->is_shift     = 0;
            $data->remark       = $seatshift['remark'];
            $data->created_by   = auth()->user()->id;
            $data->ip_address   = $request->ip();
            $data->branch_id    = session('branch_id');
            $data->save(); 


            ////update bed after seat shift
            DB::statement("
                    update beds set 
                    is_book = 0 
                    where id = ? 
                    and branch_id = ?
                ", [$seatshift['from_bed_id'], session('branch_id')]);
            DB::statement("
                    update beds set 
                    is_book = 1 
                    where id = ? 
                    and branch_id = ?
                ", [$seatshift['to_bed_id'], session('branch_id')]);
            ////end of seat shift
            DB::commit();
            return response()->json(['message' => 'Seat Shift Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    
    public function seatShiftDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {

         
            $getSeatShift= BedShift::whereNull('deleted_at')->where('id',$request->id)->first();
            $countSeatShift= BedShift::whereNull('deleted_at')->where('admission_id',$getSeatShift->admission_id)->count();

            //dd($countSeatShift);
            if($countSeatShift > 1){
                $unshiftSeat= BedShift::whereNull('deleted_at')
                ->where('admission_id',$getSeatShift->admission_id)
                ->where('is_shift',1)
                ->orderBy('created_at', 'desc')
                ->first();
                    DB::statement("
                        update bed_shifts set 
                        is_shift = 0, 
                        bed_release_date = ?
                        where id = ? 
                        and admission_id = ? 
                        and branch_id = ?
                    ", [null,$unshiftSeat->id,$unshiftSeat->admission_id, session('branch_id')]);
            }else{
                DB::statement("
                    update admissions set 
                    is_shift = 0, 
                    bed_release_date = ?
                    where id = ? 
                    and branch_id = ?
                ", [null,$getSeatShift->admission_id, session('branch_id')]);
            }

            $prevoiusSeatShift= BedShift::where('id',$request->id)->first();
           // dd( $prevoiusSeatShift);
             ////update bed after Delete seat shift
             DB::statement("
                    update beds set 
                    is_book = 1 
                    where id = ? 
                    and branch_id = ?
            ", [$prevoiusSeatShift->from_bed_id, session('branch_id')]);
            DB::statement("
                    update beds set 
                    is_book = 0
                    where id = ? 
                    and branch_id = ?
            ", [$prevoiusSeatShift->to_bed_id, session('branch_id')]);
            ////end of seat shift
            BedShift::where('id', $request->id)->forceDelete();

            DB::commit();
            return response()->json(['message' => 'Seat Shift Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }


    public function seatShiftUpdate(Request $request)
    {
        DB::beginTransaction();
        try{
            
            $seatshift = $request->seatshift;
            $validator = Validator::make((array) $seatshift, [
                'id'           => 'required|integer',
                'admission_id' => 'required|integer',
                'patient_id'   => 'required|integer',
                'shift_date'   => 'required|date',
                'from_room_id' => 'required|integer',
                'from_bed_id'  => 'required|integer',
                'to_room_id'   => 'required|integer',
                'to_bed_id'    => 'required|integer',
                'bed_rent'     => 'required|numeric'
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            if($seatshift['shift_time'] < "14:00"){
                $previouseShiftdate = Carbon::createFromFormat('Y-m-d', $seatshift['shift_date']);
                
            }else{
                $previouseShiftdate = Carbon::createFromFormat('Y-m-d', $seatshift['shift_date']);
                $previouseShiftdate = $previouseShiftdate->addDay(); // Subtracts 1 day
            }
            $countSeatShift= BedShift::where('admission_id',$seatshift['admission_id'])->where('is_shift',1)->count();

            if($countSeatShift < 1){
                DB::statement("
                    update admissions set  
                    bed_release_date = ? 
                    where id = ? 
                    and branch_id = ?
                    ", [$previouseShiftdate,$seatshift['admission_id'], session('branch_id')]);
                
            }else{
                    $getLastSeatShift= BedShift::where('admission_id',$seatshift['admission_id'])->where('is_shift',1)->whereNull('deleted_at')->orderBy('id','desc')->first();
                    $previousedate = Carbon::createFromFormat('Y-m-d', $seatshift['shift_date']);
                    $previousedate = $previousedate->addDay(); // Subtracts 1 day
                    DB::statement("
                    update bed_shifts set 
                    bed_release_date = ? 
                    where id = ? 
                    and branch_id = ?
                ", [$previouseShiftdate,$getLastSeatShift->id, session('branch_id')]);
            }


                $oldSeatShift= BedShift::where('id',$seatshift['id'])->first();
                if($oldSeatShift->admission_id != $seatshift['admission_id']){
                    DB::statement("
                        update admissions set 
                        is_shift = 0,
                        bed_release_date = ? 
                        where id = ? 
                        and branch_id = ?
                    ", [null,$oldSeatShift->admission_id, session('branch_id')]);
                
                    DB::statement("
                        update admissions set 
                        is_shift = 1,
                        bed_release_date = ?
                        where id = ? 
                        and branch_id = ?
                    ", [$oldSeatShift->bed_release_date,$seatshift['admission_id'], session('branch_id')]);
                }

               


            $data               = BedShift::find($seatshift['id']);
            $data->admission_id = $seatshift['admission_id'];
            $data->patient_id   = $seatshift['patient_id'];
            if($seatshift['shift_time'] < "14:00"){
                $previousedate = Carbon::createFromFormat('Y-m-d', $seatshift['shift_date']);
               
                $data->shift_date   = $previousedate ;
                $data->shift_time   = $seatshift['shift_time'];
            }else{
                $previousedate = Carbon::createFromFormat('Y-m-d', $seatshift['shift_date']);
                $previousedate = $previousedate->addDay(); // add 1 day
                $data->shift_date   = $previousedate ;
                $data->shift_time   = '00:00:00';
            }
            $data->from_room_id = $seatshift['from_room_id'];
            $data->from_bed_id  = $seatshift['from_bed_id'];
            $data->to_room_id   = $seatshift['to_room_id'];
            $data->to_bed_id    = $seatshift['to_bed_id'];
            $data->bed_rent     = $seatshift['bed_rent'];
            $data->is_shift     = 0;
            $data->remark       = $seatshift['remark'];
            $data->updated_by   = auth()->user()->id;
            $data->ip_address   = $request->ip();
            $data->branch_id    = session('branch_id');
            $data->save(); 

            $olddata=BedShift::where('id',$seatshift['id'])->first();
                    DB::statement("
                        update beds set 
                        is_book = 0 
                        where id = ? 
                        and branch_id = ?
                    ", [$olddata->bed_id, session('branch_id')]);
                    DB::statement("
                        update beds set 
                        is_book = 1 
                        where id = ? 
                        and branch_id = ?
                    ", [$seatshift['to_bed_id'], session('branch_id')]);
                    DB::commit();
                    return response()->json(['success'=>true,'message' => 'Seat Shift Updated!']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function slipBillSearch()
    {
        return view('admin.patient.release_bill_search');
    }
    public function slipBillPaymentSearch()
    {
        return view('admin.patient.release_bill_payment_search');
    }

    public function slipBill($id)
    {
        $id = $id;
        return view('admin.patient.release_bill',compact('id'));
    }

    public function getSlipBill(Request $request)
    {
        
    
            $res['admmission'] = DB::select("
                    SELECT
                        a.*,
                        concat_ws(' - ', d.name, d.doctor_code) as doctor_text,
                        concat_ws(' - ', p.name ,p.patient_code) as patient_text,
                        p.patient_code as patient_code,
                        p.mobile as patient_mobile,
                        p.address as patient_address,
                        u.name as user_name
                    from admissions a
                    left join patients p on p.id = a.patient_id
                    left join doctors d on d.id = a.doctor_id
                    left join users u on u.id = a.created_by
                    where a.deleted_at is null
                    and a.id = ?
                    and a.branch_id = ?
                ", [$request->admissionId, session('branch_id')]);
        
        
        
   

        $isShift=Admission::where('id',$request->admissionId)->first();
        $isSeatShift=BedShift::where('admission_id',$request->admissionId)->first();


      

        $order = "sequence desc";
        
        $res['getRoom'] = DB::select(
            "SELECT * from(
                select 
                'a' as sequence,
                a.id as id,
                0 as bs_id,
                a.bed_id as bed_id,
                a.room_id as room_id,
                a.status as status,
                rm.room_number as room_name,
                fr.floor_number as floor_name,
                b.bed_number as seat_name
                from admissions a
                left join beds b on b.id = a.bed_id
                left join rooms rm on rm.id = a.room_id
                left join floors fr on fr.id = rm.floor_number
                where a.deleted_at is null
                and a.branch_id  = ?
                UNION
                    select
                    'b' as sequence,
                    a.id as id,
                    bs.id as bs_id,
                    bs.to_bed_id as bed_id,
                    bs.to_room_id as room_id,
                    a.status as status,
                    rm.room_number as room_name,
                    fr.floor_number as floor_name,
                    b.bed_number as seat_name
                    from bed_shifts bs
                    left join admissions a on a.id = bs.admission_id
                    left join beds b on b.id = bs.to_bed_id
                    left join rooms rm on rm.id = bs.to_room_id
                    left join floors fr on fr.id = rm.floor_number
                    where bs.deleted_at is null
                    and bs.branch_id  = ?
                    order by bs_id desc
            ) as tbl
            where 1 = 1 
            and id = '$request->admissionId'
            order by $order
        ",[session('branch_id'),session('branch_id')]);

        // if(!$isSeatShift && $isShift->is_shift == '0'){
        //     $res['getRoom']= DB::table('admissions as a')
        //                     ->selectRaw("a.*,fr.floor_number as floor_name, rm.room_number as room_name,b.bed_number as seat_name")
        //                     ->leftJoin('rooms as rm', 'rm.id', '=', 'a.room_id')
        //                     ->leftJoin('beds as b', 'b.id', '=', 'a.bed_id')
        //                     ->leftJoin('floors as fr', 'fr.id', '=', 'rm.floor_number')
        //                     ->whereNull('a.deleted_at')
        //                     ->where('a.id',$request->admissionId)
        //                     ->first();
        // }elseif($isSeatShift){
        //     $res['getRoom']=DB::table('bed_shifts as bs')
        //                     ->selectRaw("bs.*,fr.floor_number as floor_name, rm.room_number as room_name,b.bed_number as seat_name")
        //                     ->leftJoin('rooms as rm', 'rm.id', '=', 'bs.to_room_id')
        //                     ->leftJoin('beds as b', 'b.id', '=', 'bs.to_bed_id')
        //                     ->leftJoin('floors as fr', 'fr.id', '=', 'rm.floor_number')
        //                     ->whereNull('bs.deleted_at')
        //                     ->where('bs.admission_id',$request->admissionId)
        //                     ->where('bs.is_shift',1)
        //                     ->orderBy('bs.id','desc')
        //                     ->first();
        // }  
        
        $res['getBills']= admissionBills($request->admissionId);
        $res['getTestBills']= admissionTestBills($request->admissionId);
        $res['getTestBillPaid']= admissionBillPaid($request->admissionId);
        $res['getpharmacyBills']= admissionPharmacyBills($request->admissionId);
        $res['admissionSeatFirstBills']= admissionSeatFirstBills($request->admissionId,$request->date);
        $res['getSeatSheftBills']= admissionSeatSheftBills($request->admissionId);
        $res['seatSheftLastBills']= seatSheftLastBills($request->admissionId,$request->date);
        $res['getOTSBills']= admissionOTBills($request->admissionId);
        $res['getReleaseSlip']= getReleaseSlip($request->admissionId,$request->date);

        return response()->json($res);
    }

    public function getReleaseSlipCode()
    {
        return response()->json(generateReleaseSlipCode());
    }


    public function releaseSlipStore(Request $request)
    {
        $releasebillpayment = $request->releasebillpayment;
        $validator = Validator::make((array) $releasebillpayment, [
            'releaseslip_code' => 'required|string|unique:release_slips',
            //'patient_id '      => 'required|integer',
            'doctor_id'        => 'required|integer',
            'admission_id'     => 'required|integer',
            'room_id'          => 'required|integer',
            'bed_id'           => 'required|integer',
            'slip_date'        => 'required|date',
            'due'              => 'required|numeric',
            'paid'             => 'required|numeric',
            'discount'         => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data                   = New ReleaseSlip();
            $data->releaseslip_code = $releasebillpayment['releaseslip_code'];

            if($releasebillpayment['slip_time'] < "14:00"){
                $previousedate = Carbon::createFromFormat('Y-m-d', $releasebillpayment['slip_date']);
                $previousedate = $previousedate->subDay(); // add 1 day
                $data->slip_date   = $previousedate ;
            }else{
                $previousedate = Carbon::createFromFormat('Y-m-d', $releasebillpayment['slip_date']);
                $data->slip_date   = $previousedate ;
            }
            $data->slip_time     = $releasebillpayment['slip_time'];
            $data->patient_id    = $releasebillpayment['patient_id'];
            $data->doctor_id     = $releasebillpayment['doctor_id'];
            $data->admission_id  = $releasebillpayment['admission_id'];
            $data->room_id       = $releasebillpayment['room_id'];
            $data->bed_id        = $releasebillpayment['bed_id'];
            $data->due           = $releasebillpayment['due'];
            $data->previous_paid = $releasebillpayment['paid'];
            $data->discount      = $releasebillpayment['discount'];
            $data->amount        = $releasebillpayment['paid'] - $releasebillpayment['discount'];
            $data->remark        = $releasebillpayment['remark'];
            $data->status        = "Release";
            $data->created_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 

                $seatShiftCount = DB::table('bed_shifts')->where('admission_id', $releasebillpayment['admission_id'])
                ->whereNull('deleted_at')->orderBy('id','desc')
                ->where('branch_id', session('branch_id'))
                ->count();
               // dd($inventoryCount);
                if( $seatShiftCount > 0){
                    $lastseatShift = DB::table('bed_shifts')->where('admission_id', $releasebillpayment['admission_id'])
                    ->whereNull('deleted_at')->orderBy('id','desc')
                    ->where('branch_id', session('branch_id'))
                    ->first();
                        DB::statement("
                        update bed_shifts set 
                        bed_release_date = ?, 
                        is_shift = 1 
                        where id = ? 
                        and branch_id = ?
                        ", [$previousedate, $lastseatShift->id, session('branch_id')]);
                    
                        DB::statement("
                            update admissions set  
                            status = ? 
                            where id = ? 
                            and branch_id = ?
                        ",["Release", $releasebillpayment['admission_id'],session('branch_id')]);

                }else{
                        DB::statement("
                        update admissions set 
                        bed_release_date = ?, 
                        status = ?,
                        is_shift = 1
                        where id = ?
                        and branch_id = ?
                    ",[$previousedate,'Release',$releasebillpayment['admission_id'],session('branch_id')]);
                }

                    DB::statement("
                        update beds set 
                        is_book = 0 
                        where id = ? 
                        and branch_id = ?
                    ", [$releasebillpayment['bed_id'], session('branch_id')]);

            DB::commit();
            return response()->json(['message' => 'Release Slip Added Successfully','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function releaseSlipUpdate(Request $request)
    {
        $releasebillpayment = $request->releasebillpayment;
       
        $validator = Validator::make((array) $releasebillpayment, [
            'releaseslip_code'  => ['required','string',Rule::unique('release_slips')->ignore($releasebillpayment['id'],'id')],
            'doctor_id'        => 'required|integer',
            'admission_id'     => 'required|integer',
            'room_id'          => 'required|integer',
            'bed_id'           => 'required|integer',
            'slip_date'        => 'required|date',
            'due'              => 'required|numeric',
            'paid'             => 'required|numeric',
            'discount'         => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            
            $data                   = ReleaseSlip::find($releasebillpayment['id']);
            $data->releaseslip_code = $releasebillpayment['releaseslip_code'];

            if($releasebillpayment['slip_time'] < "14:00"){
                $previousedate = Carbon::createFromFormat('Y-m-d', $releasebillpayment['slip_date']);
                $previousedate = $previousedate->subDay(); // add 1 day
                $data->slip_date   = $previousedate ;
            }else{
                $previousedate = Carbon::createFromFormat('Y-m-d', $releasebillpayment['slip_date']);
                $data->slip_date   = $previousedate ;
            }
            $data->slip_time     = $releasebillpayment['slip_time'];
            $data->patient_id    = $releasebillpayment['patient_id'];
            $data->doctor_id     = $releasebillpayment['doctor_id'];
            $data->admission_id  = $releasebillpayment['admission_id'];
            $data->room_id       = $releasebillpayment['room_id'];
            $data->bed_id        = $releasebillpayment['bed_id'];
            $data->due           = $releasebillpayment['due'];
            $data->previous_paid = $releasebillpayment['paid'];
            $data->discount      = $releasebillpayment['discount'];
            $data->amount        = $releasebillpayment['paid'] - $releasebillpayment['discount'];
            $data->remark        = $releasebillpayment['remark'];
            $data->status        = "Release";
            $data->created_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 

                $seatShiftCount = DB::table('bed_shifts')->where('admission_id', $releasebillpayment['admission_id'])
                ->whereNull('deleted_at')->orderBy('id','desc')
                ->where('branch_id', session('branch_id'))
                ->count();
               // dd($inventoryCount);
                if( $seatShiftCount > 0){
                    $lastseatShift = DB::table('bed_shifts')->where('admission_id', $releasebillpayment['admission_id'])
                    ->whereNull('deleted_at')->orderBy('id','desc')
                    ->where('branch_id', session('branch_id'))
                    ->first();
                        DB::statement("
                        update bed_shifts set 
                        bed_release_date = ?, 
                        is_shift = 1 
                        where id = ? 
                        and branch_id = ?
                        ", [$previousedate, $lastseatShift->id, session('branch_id')]);
                    
                        DB::statement("
                            update admissions set  
                            status = ? 
                            where id = ? 
                            and branch_id = ?
                        ",["Release", $releasebillpayment['admission_id'],session('branch_id')]);

                }else{
                        DB::statement("
                        update admissions set 
                        bed_release_date = ?, 
                        status = ?,
                        is_shift = 1
                        where id = ?
                        and branch_id = ?
                    ",[$previousedate,'Release',$releasebillpayment['admission_id'],session('branch_id')]);
                }

                    DB::statement("
                        update beds set 
                        is_book = 0 
                        where id = ? 
                        and branch_id = ?
                    ", [$releasebillpayment['bed_id'], session('branch_id')]);

            DB::commit();
            return response()->json(['message' => 'Release Slip Updated Successfully','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function releaseSlipInvoice($id)
    {
        $admissiomId =  ReleaseSlip::where('id',$id)->whereNull('deleted_at')->where('status','Release')->first();
        $id = $admissiomId->admission_id;
        $date = $admissiomId->slip_date;
        return view('admin.patient.release_bill',compact('id','date'));
    }

    public function releaseSlipRecord()
    {
        return view('admin.patient.release_slip_record');
    }

    public function getReleaseSlip(Request $request)
    {
        
                $clauses = "";

                if($request->date && $request->date != ''){
                    $clauses .= " and rs.slip_date = '$request->date'";
                }

                if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
                    $clauses .= " and rs.slip_date between '$request->dateFrom' and '$request->dateTo'";
                }

                if($request->admission_id && $request->admission_id != ''){
                    $clauses .= " and rs.admission_id = '$request->admission_id'";
                }
                if($request->doctor_id && $request->doctor_id != ''){
                    $clauses .= " and rs.doctor_id = '$request->doctor_id'";
                }

                if($request->patient_id && $request->patient_id != ''){
                    $clauses .= " and rs.patient_id = '$request->patient_id'";
                }

                if($request->room_id && $request->room_id != ''){
                    $clauses .= " and rs.room_id = '$request->room_id'";
                }
                if($request->seat_id && $request->seat_id != ''){
                    $clauses .= " and rs.bed_id = '$request->seat_id'";
                }

                if($request->status){
                    $clauses .= " and rs.status = 'Release'";
                }

                if($request->id && $request->id != ''){
                    $clauses .= " and rs.admission_id = '$request->id'";
                }

    
            $res['releaseSlip'] = DB::select("
                    SELECT
                        rs.*,
                        concat_ws(' - ', d.name, d.doctor_code) as doctor_name,
                        concat_ws(' - ', p.name ,p.patient_code,p.mobile) as patient_name,
                        concat_ws(' - ', fr.floor_name ,rm.room_number) as room_name,
                        concat_ws(' - ', rm.room_number,b.bed_number) as seat_name,
                        a.admission_code as admission_code,
                        u.name as user_name
                    from release_slips rs
                    left join patients p on p.id = rs.patient_id
                    left join doctors d on d.id = rs.doctor_id
                    left join admissions a on a.id = rs.admission_id
                    left join rooms rm on rm.id = rs.room_id
                    left join beds b on b.id = rs.bed_id
                    left join floors fr on fr.id = rm.floor_number
                    left join users u on u.id = rs.created_by
                    where rs.deleted_at is null
                    and rs.branch_id = ?
                    $clauses
                ", [session('branch_id')]);
   
        return response()->json($res);
    }


    public function releaseSlipDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {

            $getReleaseAdmissionId = ReleaseSlip::where('id',$request->id)->whereNull('deleted_at')->first();
            // print_r($getReleaseAdmissionId->admission_id);
            // print_r($getReleaseAdmissionId->bed_id);
            // exit;


            $seatShiftCount = DB::table('bed_shifts')->where('admission_id', $getReleaseAdmissionId->admission_id)
                ->whereNull('deleted_at')->orderBy('id','desc')
                ->where('branch_id', session('branch_id'))
                ->count();
               // dd($inventoryCount);
                if( $seatShiftCount > 0){
                    $lastseatShift = DB::table('bed_shifts')->where('admission_id', $getReleaseAdmissionId->admission_id)
                    ->whereNull('deleted_at')->orderBy('id','desc')
                    ->where('branch_id', session('branch_id'))
                    ->first();
                        DB::statement("
                        update bed_shifts set 
                        bed_release_date = ?, 
                        is_shift = 0 
                        where id = ? 
                        and branch_id = ?
                        ", [null,$lastseatShift->id, session('branch_id')]);
                    
                        DB::statement("
                            update admissions set  
                            status = ? 
                            where id = ? 
                            and branch_id = ?
                        ",["Admited", $getReleaseAdmissionId->admission_id,session('branch_id')]);

                }else{
                        DB::statement("
                        update admissions set 
                        bed_release_date = ?, 
                        status = ?,
                        is_shift = 0
                        where id = ?
                        and branch_id = ?
                    ",[null,'Admited',$getReleaseAdmissionId->admission_id,session('branch_id')]);
                }

                    DB::statement("
                        update beds set 
                        is_book = 1 
                        where id = ? 
                        and branch_id = ?
                    ", [$getReleaseAdmissionId->bed_id, session('branch_id')]);



            ReleaseSlip::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Bill Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function releaseSlipEdit($id)
    {
        $admissiomId =  ReleaseSlip::where('id',$id)->whereNull('deleted_at')->where('status','Release')->first();
        $id = $admissiomId->admission_id;
        return view('admin.patient.release_slip_edit',compact('id'));
    }

    public function seatStatus()
    {
        return view('admin.patient.seat_status');
    }
    public function getseatStatus(Request $request)
    {
        $floors = Floor::whereNull('deleted_at')->get();
        if ($request->with_room) {
            foreach ($floors as $floor) {
                $floor->rooms = Room::where('floor_number', $floor->id)->where('is_operation',0)->whereNull('deleted_at')->get();
                $floor->ots = Room::where('floor_number', $floor->id)->where('is_operation',1)->whereNull('deleted_at')->get();
                if ($request->with_bed) {
                    foreach ($floor->rooms as $room) {
                        $room->beds = Bed::where('room_id', $room->id)->whereNull('deleted_at')->get();
                    }
                }
                if ($request->with_ot) {
                    foreach ($floor->ots as $ot) {
                        $ot->beds = Bed::where('room_id', $room->id)->whereNull('deleted_at')->get();
                    }
                }
            }
        }
        return response()->json($floors);
    }
}
