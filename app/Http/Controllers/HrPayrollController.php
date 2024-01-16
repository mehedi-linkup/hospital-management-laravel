<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Month;
use App\Models\Salary;
use App\Models\SalaryDetail;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use File;

class HrPayrollController extends Controller
{

    public function departmentEntry()
    {
        return view('admin.hrpayroll.department_entry');
    }

    public function departmentStore(Request $request)
    {
        $request->validate([
            'name'               => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');

            Department::create($data);

            DB::commit();
            return response()->json(['message' => 'Department Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function departmentUpdate(Request $request)
    {
        $request->validate([
            'id'                 => ['required', 'integer'],
            'name'               => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            Department::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Department Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function departmentDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Department::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Department Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getDepartments(Request $request)
    {
        $department = DB::table('departments as a')
        ->whereNull('a.deleted_at');

        $department->select("a.*");

        $department =  $department->orderBy('a.id', 'desc')->lazy();

        return response()->json($department);
    }


    public function designationEntry()
    {
        return view('admin.hrpayroll.designation_entry');
    }

    public function designationStore(Request $request)
    {
        $request->validate([
            'name'               => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');

            Designation::create($data);

            DB::commit();
            return response()->json(['message' => 'Designation Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function designationUpdate(Request $request)
    {
        $request->validate([
            'id'                 => ['required', 'integer'],
            'name'               => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            Designation::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Designation Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function designationDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Designation::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Designation Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getDesignations(Request $request)
    {
        $department = DB::table('designations as a')
        ->whereNull('a.deleted_at');

        $department->select("a.*");

        $department =  $department->orderBy('a.id', 'desc')->lazy();

        return response()->json($department);
    }
    public function monthEntry()
    {
        return view('admin.hrpayroll.month_entry');
    }

    public function monthStore(Request $request)
    {
        $request->validate([
            'name'               => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');

            Month::create($data);

            DB::commit();
            return response()->json(['message' => 'Month Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function monthUpdate(Request $request)
    {
        $request->validate([
            'id'                 => ['required', 'integer'],
            'name'               => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            Month::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Month Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function monthDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Month::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Month Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getMonths(Request $request)
    {
        $month = DB::table('months as a')
        ->whereNull('a.deleted_at');

        $month->select("a.*");

        $month =  $month->orderBy('a.id', 'desc')->lazy();

        return response()->json($month);
    }
    public function employeeEntry()
    {
        return view('admin.hrpayroll.employee_entry');
    }
    public function employeeList()
    {
        return view('admin.hrpayroll.employee_list');
    }
    public function employeeActiveList()
    {
        return view('admin.hrpayroll.employee_active_list');
    }
    public function employeedeactiveList()
    {
        return view('admin.hrpayroll.employee_deactive_list');
    }

    public function employeeStore(Request $request)
    {
        $employee = json_decode($request->employees);

        $validator = Validator::make((array) $employee, [
            'employee_code'  => 'required|string|unique:employees',
            'bio_id'         => 'required|string|unique:employees',
            'name'           => 'required|string|max:255',
            'mobile_number'  => 'required|string|size:11',
            'father_name'    => 'required|string',
            'mother_name'    => 'required|string',
            'salary_range'   => 'required|numeric',
            'joining_date'   => 'required|date',
            'birth_date'     => 'required|date',
            'gender'         => 'required|in:Male,Female,Other',
            'merital_status' => 'required|in:Single,Married,Divorce,Widowed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            //dd($request->name);
            $path = public_path('images/employee');
            if ( ! File::exists($path) ) { FIle::makeDirectory($path,0777,true); }

            $data                    = New Employee();
            $data->image             = imageUpload($request, 'image' , 'images/employee');
            $data->name              = $employee->name;
            $data->employee_code     = $employee->employee_code;
            $data->bio_id            = $employee->bio_id;
            $data->department_id     = $employee->department_id;
            $data->designation_id    = $employee->designation_id;
            $data->joining_date      = $employee->joining_date;
            $data->mobile_number     = $employee->mobile_number;
            $data->email             = $employee->email;
            $data->status            = $employee->status;
            $data->gender            = $employee->gender;
            $data->merital_status    = $employee->merital_status;
            $data->birth_date        = $employee->birth_date;
            $data->father_name       = $employee->father_name;
            $data->mother_name       = $employee->mother_name;
            $data->present_address   = $employee->present_address;
            $data->permanent_address = $employee->permanent_address;
            $data->salary_range      = $employee->salary_range;
            $data->created_by        = auth()->user()->id;
            $data->ip_address        = $request->ip();
            $data->branch_id         = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Employee Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function employeeUpdate(Request $request)
    {
        $employee = json_decode($request->employees);

        $validator = Validator::make((array) $employee, [
            'id'             => 'required|integer',
            'employee_code'  => ['required','string',Rule::unique('employees')->ignore($employee->id,'id')],
            'bio_id'         => ['required','string',Rule::unique('employees')->ignore($employee->id,'id')],
            'name'           => 'required|string|max:255',
            'mobile_number'  => 'required|string|size:11',
            'father_name'    => 'required|string',
            'mother_name'    => 'required|string',
            'salary_range'   => 'required|numeric',
            'joining_date'   => 'required|date',
            'birth_date'     => 'required|date',
            'gender'         => 'required|in:Male,Female,Other',
            'merital_status' => 'required|in:Single,Married,Divorce,Widowed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        
        try {
            $data=Employee::find($employee->id);
            $image = $data->image;
            $path = public_path('images/employee');
            if ( ! File::exists($path) ) { FIle::makeDirectory($path,0777,true); }
            if ($request->hasFile('image')) {
                if (!empty($image) && file_exists($image)) 
                    unlink($image);
                $data->image = imageUpload($request, 'image', 'images/employee');
            }
            $data->name              = $employee->name;
            $data->employee_code     = $employee->employee_code;
            $data->bio_id            = $employee->bio_id;
            $data->department_id     = $employee->department_id;
            $data->designation_id    = $employee->designation_id;
            $data->joining_date      = $employee->joining_date;
            $data->mobile_number     = $employee->mobile_number;
            $data->email             = $employee->email;
            $data->gender            = $employee->gender;
            $data->status            = $employee->status;
            $data->merital_status    = $employee->merital_status;
            $data->birth_date        = $employee->birth_date;
            $data->father_name       = $employee->father_name;
            $data->mother_name       = $employee->mother_name;
            $data->present_address   = $employee->present_address;
            $data->permanent_address = $employee->permanent_address;
            $data->salary_range      = $employee->salary_range;
            $data->updated_by        = auth()->user()->id;
            $data->ip_address        = $request->ip();
            $data->branch_id         = session('branch_id');
            $data->save(); 
            DB::commit();
            return response()->json(['message' => 'Employee Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function employeeDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Employee::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Employee Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getEmployees(Request $request)
    {

        $getEmployee = DB::table('employees as emp')
        ->whereNull('emp.deleted_at')
        ->selectRaw("emp.*,emp.name as employee_name, d.name as department_name, ds.name as designation_name,concat(emp.name, ' - ', emp.employee_code) as display_name")
        ->leftJoin('departments as d', 'd.id', '=', 'emp.department_id')
        ->leftJoin('designations as ds', 'ds.id', '=', 'emp.designation_id');
        if($request->status && $request->status == 'a'){
            $getEmployee->where('emp.status', 'a');
        }
        if($request->status && $request->status == 'd'){
            $getEmployee->where('emp.status', 'd');
        }
        $getEmployee = $getEmployee->orderBy('emp.id', 'desc')->lazy();
        return response()->json($getEmployee);
    }
    public function getEmployeeCode()
    {
        return response()->json(generateEmployeeCode());
    }

    public function salaryPayment()
    {
        $code= generateSalaryCode();
        return view('admin.hrpayroll.salary_payment',compact('code'));
    }

    public function checkPaymentMonth(Request $request)
    {
        $getMonth = DB::table('salaries as s')
        ->whereNull('s.deleted_at')
        ->selectRaw("s.*")
        ->where('s.month_id',$request->month_id)
        ->where('s.branch_id',session('branch_id'));
        if($getMonth->count() > 0){
            return response()->json(['success' => true]);
            exit();
        }else{
            return response()->json(['success' => false]);
            exit();
        }
    }

    public function getSalaryPayment(Request $request)
    {
        $clauses = "";
        

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and sp.payment_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if(isset($request->user_id) && $request->user_id != ''){
            $clauses .= " and sp.created_by = '$request->user_id'";
        }

        if(isset($request->month_id) && $request->month_id != ''){
            $clauses .= " and sp.month_id = '$request->month_id'";
        }

       
        
        //dd($request->purchaseId);
        $result = DB::select(
                    "SELECT sp.*,
                    m.name as month_name,
                    u.name as User_Name

                    from salaries sp
                    join months m on m.id = sp.month_id
                    left join users u on u.id = sp.created_by

                    where sp.deleted_at is null
                    and sp.branch_id = ?
                    $clauses
                    order by sp.id desc
        ", [session('branch_id')]);

        //dd($result);
        
        if($request->with_details){
            foreach($result as $value){
                $value->details = DB::select(
                    "SELECT sd.*,
                    e.id  as employee_id,
                    e.employee_code  as employee_code,
                    e.name as employee_name,
                    d.name as department_name,
                    de.name as designation_name

                    from salary_details sd
                    left join employees e on e.id = sd.employee_id
                    left join departments d on d.id = e.department_id
                    left join designations de on de.id = e.designation_id

                    where sd.deleted_at is null
                    and sd.salary_id  = '$value->id'
                ");
            }
        }

        return response()->json($result);
    }
    public function getSalaryDetails(Request $request)
    {
        $clauses = "";
        

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and sd.payment_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->employee_id && $request->employee_id != ''){
            $clauses .= " and sd.employee_id = '$request->employee_id'";
        }

        if($request->month_id && $request->month_id != ''){
            $clauses .= " and s.month_id = '$request->month_id'";
        }

       
        
        //dd($request->purchaseId);
        $result = DB::select(
                "SELECT sd.*,
                e.employee_code as Employee_ID,
                e.name as Employee_Name,
                d.name as Department_Name,
                de.name as Designation_Name,
                m.name as month_name,
                s.payment_date

                from salary_details sd
                left join salaries s on s.id = sd.salary_id
                left join months m on m.id = s.month_id
                left join employees e on e.id = sd.employee_id
                left join designations de on de.id = e.designation_id
                left join departments d on d.id = e.department_id
                where sd.deleted_at is null
                and sd.branch_id = ?
                $clauses
        ", [session('branch_id')]);

        return response()->json($result);
    }

    public function salaryPaymentStore(Request $request)
    {
        $payment = $request->payment;
        $employees = $request->employees;
        $validator = Validator::make((array) $payment, [
            'transaction_number' => 'required|string|unique:salaries',
            'month_id'             => 'required|integer',
            'payment_date'         => 'required|date'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
           
            $data                     = New Salary();
            $data->transaction_number = $payment['transaction_number'];
            $data->month_id           = $payment['month_id'];
            $data->payment_date       = $payment['payment_date'];
            $data->created_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 

            $total_payment_amount = 0;
            foreach ($employees as $value) {
                SalaryDetail::create(array(
                    'salary_id'   => $data->id,
                    'employee_id' => $value['id'],
                    'salary'      => $value['salary'],
                    'benefit'     => $value['benefit'],
                    'deduction'   => $value['deduction'],
                    'net_payable' => $value['net_payable'],
                    'payment'     => $value['payment'],
                    'comment'     => $value['comment'],
                    'created_by'  => auth()->user()->id,
                    'ip_address'  => $request->ip(),
                    'branch_id'   => session('branch_id')
                ));
                $total_payment_amount += $value['payment'];
            }

            $data= Salary::find( $data->id);
            $data->total_payment_amount = $total_payment_amount;
            $data->save();

            DB::commit();
            return response()->json(['message' => 'Salary Payment Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function salaryPaymentUpdate(Request $request)
    {
        $payment = $request->payment;
        $employees = $request->employees;
        $validator = Validator::make((array) $payment, [
            'id'                 => 'required|integer',
            'transaction_number'  => ['required','string',Rule::unique('salaries')->ignore($payment['id'],'id')],
            'month_id'           => 'required|integer',
            'payment_date'       => 'required|date'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
           
            $data                     = Salary::find($payment['id']);
            $data->transaction_number = $payment['transaction_number'];
            $data->month_id           = $payment['month_id'];
            $data->payment_date       = $payment['payment_date'];
            $data->updated_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 

            $deleteSalaryPayments=SalaryDetail::where('salary_id',$data->id);
            $deleteSalaryPayments->forceDelete();

            $total_payment_amount = 0;
            foreach ($employees as $value) {
                SalaryDetail::create(array(
                    'salary_id'   => $data->id,
                    'employee_id' => $value['employee_id'],
                    'salary'      => $value['salary'],
                    'benefit'     => $value['benefit'],
                    'deduction'   => $value['deduction'],
                    'net_payable' => $value['net_payable'],
                    'payment'     => $value['payment'],
                    'comment'     => $value['comment'],
                    'updated_by'  => auth()->user()->id,
                    'ip_address'  => $request->ip(),
                    'branch_id'   => session('branch_id')
                ));
                $total_payment_amount += $value['payment'];
            }

            $data= Salary::find( $data->id);
            $data->total_payment_amount = $total_payment_amount;
            $data->save();

            DB::commit();
            return response()->json(['message' => 'Salary Payment Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function salaryPaymentDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Salary::where('id', $request->id)->delete();
            SalaryDetail::where('salary_id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Salary Payment Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function salaryPaymentReport()
    {
        return view('admin.hrpayroll.salary_payment_report');
    }

    



}
