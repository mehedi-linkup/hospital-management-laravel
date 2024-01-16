<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function patientEntry()
    {
        return view('admin.patient.patient_entry');
    }
    public function patientList()
    {
        return view('admin.patient.patient_list');
    }

    public function getPatientCode()
    {
        return response()->json(generatePatientCode());
    }

    public function patientStore(Request $request)
    {
        $request->validate([
            'patient_code'  => ['required', 'string', 'unique:patients'],
            'name'          => ['required', 'string', 'max:255'],
            'mobile'        => ['required', 'string', 'size:11'],
            'gender'        => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'date_of_birth' => ['required', 'date'],
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');

            Patient::create($data);

            DB::commit();
            return response()->json(['message' => 'Patient Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function patientUpdate(Request $request)
    {
        $request->validate([
            'id'            => ['required', 'integer'],
            'patient_code'  => ['required', 'string', Rule::unique('patients')->ignore($request->id,'id')],
            'name'          => ['required', 'string', 'max:255'],
            'mobile'        => ['required', 'string', 'size:11'],
            'gender'        => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'date_of_birth' => ['required', 'date'],
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            Patient::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Patient Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function patientDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Patient::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Patient Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getPatients(Request $request)
    {
        $patients = DB::table('patients as p')
        ->whereNull('p.deleted_at');

        if($request->status){
            $patients->where('p.status', $request->status);
        }

        if($request->mobile){
            $patients->where('p.mobile', $request->mobile);
        }

        if($request->patient_code){
            $patients->where('p.patient_code', $request->patient_code);
        }

        $patients->selectRaw(
            "p.*,
            concat_ws(' - ', p.name, p.mobile, p.patient_code) as display_name,
            concat_ws(' - ', p.patient_code, p.name) as display_text,

            @_total_days := TIMESTAMPDIFF(DAY, date_of_birth, now()),
            @_year := FLOOR(@_total_days / 365),
            @_month := FLOOR((@_total_days - (@_year * 365)) / 30),
            @_day :=  @_total_days - ((@_year * 365) + (@_month * 30)),

            @_total_days as age_total_days,
            @_year as age_year,
            @_month as age_month,
            @_day as age_day,

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
            ) as age

        ");

        $patients =  $patients->orderBy('p.id', 'desc')->lazy();

        return response()->json($patients);
    }
}
