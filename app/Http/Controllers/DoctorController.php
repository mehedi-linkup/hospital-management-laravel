<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Advice;
use App\Models\Doctor;
use App\Models\Doses;
use App\Models\Duration;
use Illuminate\Http\Request;
use App\Models\CheifComplain;
use App\Models\Prescription;
use App\Models\PrescriptionAdvice;
use App\Models\PrescriptionChiefComplain;
use App\Models\PrescriptionMedicine;
use App\Models\PrescriptionTest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function doctorEntry()
    {
        return view('admin.doctor.doctor_entry');
    }

    public function getDoctorCode()
    {
        return response()->json(generateDoctorCode());
    }

    public function doctorStore(Request $request)
    {
        $request->validate([
            'doctor_code'        => ['required', 'string', 'unique:doctors'],
            'name'               => ['required', 'string', 'max:255'],
            'mobile'             => ['required', 'string', 'size:11', 'unique:doctors'],
            'fees'               => ['required', 'numeric'],
            'commission_percent' => ['required', 'numeric'],
            'education_level'    => ['required'],
        ]);

        DB::beginTransaction();
        
        try {
            $data                = (array) $request->all();
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']   = session('branch_id');

            $doctor = Doctor::create($data);

            $user = array(
                'name'       => $doctor->name,
                'doctor_id'  => $doctor->id,
                'username'   => $doctor->doctor_code,
                'password'   => Hash::make('1'),
                'role'       => 'Doctor',
                'ip_address' => $request->ip(),
                'created_by' => auth()->user()->id,
                'branch_id'  => session('branch_id')
            );

            User::create($user);

            DB::commit();
            return response()->json(['message' => 'Doctor Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function doctorUpdate(Request $request)
    {
        $request->validate([
            'id'                 => ['required', 'integer'],
            'doctor_code'        => ['required', 'string', Rule::unique('doctors')->ignore($request->id,'id')],
            'name'               => ['required', 'string', 'max:255'],
            'mobile'             => ['required', 'string', 'size:11', Rule::unique('doctors')->ignore($request->id,'id')],
            'fees'               => ['required', 'numeric'],
            'commission_percent' => ['required', 'numeric'],
            'education_level'    => ['required'],
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            Doctor::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Doctor Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function doctorDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Doctor::where('id', $request->id)->delete();
            User::where('doctor_id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Doctor Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getDoctors(Request $request)
    {
        $doctors = DB::table('doctors as d')
        ->selectRaw("d.*, concat_ws(' - ', d.doctor_code , d.name) as display_name")
        ->whereNull('d.deleted_at')
        ->whereBranchId(session('branch_id'));

        if($request->status){
            $doctors->where('d.status', $request->status);
        }

        if($request->mobile){
            $doctors->where('d.mobile', $request->mobile);
        }

        if($request->doctor_code){
            $doctors->where('d.doctor_code', $request->doctor_code);
        }

        $doctors->selectRaw("d.*, concat_ws(' - ', d.doctor_code, d.name) as display_name");

        $doctors =  $doctors->orderBy('d.id', 'desc')->lazy();

        return response()->json($doctors);
    }

    public function appointmentList()
    {
        if(auth()->user()->role != 'Doctor'){
            return redirect()->route('dashboard');
        }
        return view('admin.doctor.appointment_list');
    }

    ///// cheif Complains
    public function cheifComplainEntry()
    {
        if(Auth::user()->role !='Doctor'){
            return redirect()->route('dashboard');
        }
        return view('admin.doctor.cheif_complains_entry');
    }

    public function cheifComplainStore(Request $request)
    {
        $request->validate([
            'chief_complain' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['doctor_id']  = auth()->user()->doctor_id;
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');

            CheifComplain::create($data);

            DB::commit();
            return response()->json(['message' => 'Cheif Complains Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function cheifComplainUpdate(Request $request)
    {
        $request->validate([
            'id'             => ['required', 'integer'],
            'chief_complain' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['doctor_id']  = auth()->user()->doctor_id;
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            CheifComplain::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Cheif Complains Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function cheifComplainDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            CheifComplain::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Cheif Complains Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getCheifComplains(Request $request)
    {
        $cheifcomplains = DB::table('cheif_complains as a')
        ->whereNull('a.deleted_at')
        ->where("a.doctor_id", Auth::user()->doctor_id)
        ->where("a.status", 'a')
        ->select("a.*")
        ->orderBy('a.id', 'desc')
        ->lazy();

        return response()->json($cheifcomplains);
    }
    ///// Doses
    public function doseEntry()
    {
        if(Auth::user()->role !='Doctor'){
            return redirect()->route('dashboard');
        }
        return view('admin.doctor.dose_entry');
    }

    public function doseStore(Request $request)
    {
        $request->validate([
            'doses' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['doctor_id']  = auth()->user()->doctor_id;
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');

            Doses::create($data);

            DB::commit();
            return response()->json(['message' => 'Dose Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function doseUpdate(Request $request)
    {
        $request->validate([
            'id'    => ['required', 'integer'],
            'doses' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['doctor_id']  = auth()->user()->doctor_id;
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            Doses::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Dose Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function doseDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Doses::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Doses Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getdoses(Request $request)
    {
        $doses = DB::table('doses as dos')
        ->whereNull('dos.deleted_at')
        ->where("dos.doctor_id", Auth::user()->doctor_id)
        ->select("dos.*")
        ->orderBy('dos.id', 'desc')
        ->lazy();

        return response()->json($doses);
    }
    ///// duration
    public function durationEntry()
    {
        if(Auth::user()->role !='Doctor'){
            return redirect()->route('dashboard');
        }
        return view('admin.doctor.duration_entry');
    }

    public function durationStore(Request $request)
    {
        $request->validate([
            'duration' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data= (array) $request->all();

            $data['doctor_id']  = auth()->user()->doctor_id;
            $data['created_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();
            $data['branch_id']  = session('branch_id');

            Duration::create($data);

            DB::commit();
            return response()->json(['message' => 'Duration Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function durationUpdate(Request $request)
    {
        $request->validate([
            'id'    => ['required', 'integer'],
            'duration' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['doctor_id']  = auth()->user()->doctor_id;
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            Duration::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Duration Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function durationDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Duration::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Duration Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getdurations(Request $request)
    {
        $doses = DB::table('durations as du')
        ->whereNull('du.deleted_at')
        ->where("du.doctor_id", Auth::user()->doctor_id)
        ->select("du.*")
        ->orderBy('du.id', 'desc')
        ->lazy();

        return response()->json($doses);
    }

    ///// Advice Complains
    public function adviceEntry()
    {
        if(Auth::user()->role !='Doctor'){
            return redirect()->route('dashboard');
        }
        return view('admin.doctor.advice_entry');
    }

    public function adviceStore(Request $request)
    {
        $request->validate([
            'advice' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();

            $data['doctor_id']  = auth()->user()->doctor_id;
            $data['created_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();
            $data['branch_id']  = session('branch_id');

            Advice::create($data);

            DB::commit();
            return response()->json(['message' => 'Advice Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function adviceUpdate(Request $request)
    {
        $request->validate([
            'id'     => ['required', 'integer'],
            'advice' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();

            $data['doctor_id']  = auth()->user()->doctor_id;
            $data['updated_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();

            Advice::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Advice Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function adviceDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Advice::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Advice Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getAdvices(Request $request)
    {
        $cheifcomplains = DB::table('advice as a')
        ->whereNull('a.deleted_at')
        ->where("a.doctor_id", Auth::user()->doctor_id)
        ->where("a.status", 'a')
        ->select("a.*")
        ->orderBy('a.id', 'desc')
        ->lazy();

        return response()->json($cheifcomplains);
    }

    public function prescription()
    {
        if(Auth::user()->role !='Doctor'){
            return redirect()->route('dashboard');
        }
        $code = generatePrescriptionCode();
        $id = 0;
        return view('admin.doctor.prescription', compact('code', 'id'));
    }

    public function prescriptionEdit($id)
    {
        if(Auth::user()->role !='Doctor'){
            return redirect()->route('dashboard');
        }
        $pres = Prescription::findOrFail($id);
        $code = $pres->prescription_code;
        $id = $pres->id;
        return view('admin.doctor.prescription', compact('code', 'id'));
    }

    public function prescriptionInvoice($id)
    {
        if(Auth::user()->role !='Doctor'){
            return redirect()->route('dashboard');
        }
        return view('admin.doctor.prescription_invoice', compact('id'));
    }

    public function prescription_record()
    {
        if(Auth::user()->role !='Doctor'){
            return redirect()->route('dashboard');
        }
        return view('admin.doctor.prescription_record');
    }

    public function prescriptionStore(Request $request)
    {
        DB::beginTransaction();
        try{
            $prescription = $request->prescription;

            $patient = $request->patient;            

            $validator = Validator::make($prescription, [
                'prescription_code' => 'required|string|unique:prescriptions,prescription_code',
                'prescription_date' => 'required|date',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $validator = Validator::make($patient, [
                'id'  => 'required|integer',
                'age' => 'required|string',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $prescription['patient_id']  = $patient['id'];
            $prescription['patient_age'] = $patient['age'];
            $prescription['doctor_id']   = auth()->user()->doctor_id;
            $prescription['created_by']  = auth()->user()->id;
            $prescription['ip_address']  = $request->ip();
            $prescription['branch_id']   = session('branch_id');

            $pres = Prescription::create($prescription);

            foreach ($request->cart_advices as $value) {
                PrescriptionAdvice::create(array(
                    'prescription_id' => $pres->id,
                    'advice'          => $value,
                ));
            }

            foreach ($request->cart_complains as $value) {
                PrescriptionChiefComplain::create(array(
                    'prescription_id' => $pres->id,
                    'chief_complain' => $value,
                ));
            }

            foreach ($request->cart_tests as $value) {
                PrescriptionTest::create(array(
                    'prescription_id' => $pres->id,
                    'test_id' => $value['id'],
                ));
            }

            foreach ($request->cart_medicines as $value) {
                PrescriptionMedicine::create(array(
                    'prescription_id' => $pres->id,
                    'medicine_id'     => $value['id'],
                    'doses'           => $value['doses'],
                    'duration'        => $value['duration'],
                    'advice'          => $value['advice'],
                ));
            }

            DB::commit();
            return response()->json(['message' => 'Prescribed successfully!', 'id' => $pres->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function prescriptionUpdate(Request $request)
    {
        DB::beginTransaction();
        try{
            $prescription = $request->prescription;

            $patient = $request->patient;            

            $validator = Validator::make($prescription, [
                'id'                => 'required|integer',
                'prescription_code' => 'required|string|unique:prescriptions,prescription_code,'.$prescription['id'],
                'prescription_date' => 'required|date',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $validator = Validator::make($patient, [
                'id'  => 'required|integer',
                'age' => 'required|string',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $prescription['patient_id']  = $patient['id'];
            $prescription['patient_age'] = $patient['age'];
            $prescription['updated_by']  = auth()->user()->id;
            $prescription['ip_address']  = $request->ip();

            Prescription::where('id', $prescription['id'])->update($prescription);

            PrescriptionAdvice::where('prescription_id', $prescription['id'])->delete();
            PrescriptionChiefComplain::where('prescription_id', $prescription['id'])->delete();
            PrescriptionTest::where('prescription_id', $prescription['id'])->delete();
            PrescriptionMedicine::where('prescription_id', $prescription['id'])->delete();

            foreach ($request->cart_advices as $value) {
                PrescriptionAdvice::create(array(
                    'prescription_id' => $prescription['id'],
                    'advice'          => $value,
                ));
            }

            foreach ($request->cart_complains as $value) {
                PrescriptionChiefComplain::create(array(
                    'prescription_id' => $prescription['id'],
                    'chief_complain' => $value,
                ));
            }

            foreach ($request->cart_tests as $value) {
                PrescriptionTest::create(array(
                    'prescription_id' => $prescription['id'],
                    'test_id' => $value['id'],
                ));
            }

            foreach ($request->cart_medicines as $value) {
                PrescriptionMedicine::create(array(
                    'prescription_id' => $prescription['id'],
                    'medicine_id'     => $value['id'],
                    'doses'           => $value['doses'],
                    'duration'        => $value['duration'],
                    'advice'          => $value['advice'],
                ));
            }

            DB::commit();
            return response()->json(['message' => 'Updated successfully!', 'id' => $prescription['id']]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function prescriptionDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Prescription::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Prescription Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getPrescriptions(Request $request)
    {
        $clauses = "";

        if($request->id && $request->id != ''){
            $clauses .= " and p.id = '$request->id'";
        }

        if($request->date && $request->date != ''){
            $clauses .= " and p.prescription_date = '$request->date'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and p.prescription_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->patient_id && $request->patient_id != ''){
            $clauses .= " and p.patient_id = '$request->patient_id'";
        }

        $result = DB::select(
            "SELECT p.*,
            pt.patient_code,
            pt.name as patient_name,
            pt.mobile as patient_mobile,
            pt.gender as patient_gender,
            pt.date_of_birth as patient_date_of_birth,
            d.doctor_code,
            d.name as doctor_name,
            d.mobile as doctor_mobile,
            d.education_level as doctor_education_level

            from prescriptions p
            left join patients pt on pt.id = p.patient_id
            left join doctors d on d.id = p.doctor_id
            where p.deleted_at is null
            and p.branch_id = ?
            and p.doctor_id = ?
            $clauses
            order by p.id desc
        ", [session('branch_id'), auth()->user()->doctor_id]);

        if($request->with_details){
            foreach($result as $value){
                $value->chief_complains = PrescriptionChiefComplain::where('prescription_id', $value->id)->get();
                $value->advices = PrescriptionAdvice::where('prescription_id', $value->id)->get();
                
                $value->medicines = DB::select(
                    "SELECT pm.*,
                    m.name as medicine_name,
                    mc.name as category_name

                    from prescription_medicines pm
                    left join medicines m on m.id = pm.medicine_id
                    left join categories mc on mc.id = m.category_id
                    where pm.prescription_id = '$value->id'
                ");

                $value->tests = DB::select(
                    "SELECT pt.*,
                    t.name as test_name

                    from prescription_tests pt
                    left join tests t on t.id = pt.test_id
                    where pt.prescription_id = '$value->id'
                ");
            }
        }

        return response()->json($result);
    }
}
