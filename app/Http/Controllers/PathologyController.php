<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Test;
use App\Models\TestReceipt;
use App\Models\TestReceiptDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PathologyController extends Controller
{
    public function testReceipt()
    {
        $id=0;
        $code= generateTestReceiptCode();
        return view('admin.pathology.test_receipt',compact('id','code'));
    }
    public function testReceiptEdit($id)
    {
        $id=$id;
        $testcode = TestReceipt::findOrFail($id);
        $code = $testcode->invoice_number;
        return view('admin.pathology.test_receipt',compact('id','code'));
    }

    public function testEntry()
    {
        return view('admin.pathology.test_entry');
    }

    public function getTestCode()
    {
        return response()->json(generateTestCode());
    }

    public function testStore(Request $request)
    {
        $request->validate([
            'test_code'   => ['required', 'string', 'unique:tests'],
            'name'        => ['required', 'string', 'max:255'],
            'room_number' => ['nullable', 'string', 'max:30'],
            'price'       => ['required', 'numeric'],
            'day'         => ['required_without_all:hour,minute', 'nullable', 'integer'],
            'hour'        => ['required_without_all:day,minute', 'nullable', 'integer', 'max:23'],
            'minute'      => ['required_without_all:day,hour', 'nullable', 'integer', 'max:59'],
        ]);
        
        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['created_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();
            $data['branch_id']  = session('branch_id');

            Test::create($data);

            DB::commit();
            return response()->json(['message' => 'Test Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function testUpdate(Request $request)
    {
        $request->validate([
            'id'          => ['required', 'integer'],
            'test_code'   => ['required', 'string', Rule::unique('tests')->ignore($request->id,'id')],
            'name'        => ['required', 'string', 'max:255'],
            'room_number' => ['nullable', 'string', 'max:30'],
            'price'       => ['required', 'numeric'],
            'day'         => ['required_without_all:hour,minute', 'nullable', 'integer'],
            'hour'        => ['required_without_all:day,minute', 'nullable', 'integer', 'max:23'],
            'minute'      => ['required_without_all:day,hour', 'nullable', 'integer', 'max:59'],
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();
            $data['updated_by']  = auth()->user()->id;
            $data['ip_address']  = $request->ip();

            Test::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Test Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function testDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Test::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Test Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }


    public function getTests(Request $request)
    {
        $tests = DB::table('tests as p')

        ->whereNull('p.deleted_at');

        if($request->status){
            $tests->where('p.status', $request->status);
        }

        if($request->test_code){
            $tests->where('p.test_code', $request->test_code);
        }
        if($request->id){
            $tests->where('p.id', $request->id);
        }

        $tests->selectRaw(
            "p.*,
            concat_ws(' - ', p.name, p.test_code) as display_name,
            (SELECT (ifnull(p.day, 0) * 24 * 60) + (ifnull(p.hour, 0) * 60) + ifnull(p.minute, 0)) as get_min,
            (
                SELECT CONCAT
                (
                    CASE 
                        WHEN p.day THEN CONCAT( p.day, ' days ')
                        ELSE ''
                    END,

                    CASE 
                        WHEN p.hour THEN CONCAT( p.hour, ' hours ')
                        ELSE ''
                    END,

                    CASE 
                        WHEN p.minute THEN CONCAT( p.minute, ' minutes')
                        ELSE ''
                    END
                )
            ) as delivery_time

        ");


        $tests =  $tests->orderBy('p.id', 'desc')->lazy();

    


        return response()->json($tests);
    }

    public function testreceiptStore(Request $request)
    {
        $testreceipt = $request->testreceipts;
        $testCart = $request->cartTests;
        $validator = Validator::make((array) $testreceipt, [
            'invoice_number'  => 'required|string|unique:test_receipts',
            'patient_id'      => 'required|integer',
            'bill_date'       => 'required|date',
            'subtotal'        => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'vat_percent'     => 'required|numeric',
            'vat_amount'      => 'required|numeric',
            'others'          => 'required|numeric',
            'total'           => 'required|numeric',
            'paid'            => 'required|numeric',
            'due'             => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $admissiontId= Admission::where('patient_id',$testreceipt['patient_id'])->first();

            $data                 = New TestReceipt();
            $data->invoice_number = $testreceipt['invoice_number'];
            $data->patient_id     = $testreceipt['patient_id'];
            $data->reference_id   = $testreceipt['reference_id'];

            if($admissiontId && $admissiontId->status == "Admited"){
                $data->admission_id       = $admissiontId->id;
            }else{
                $data->admission_id       = null;
            }

            $data->bill_date        = $testreceipt['bill_date'];
            $data->subtotal         = $testreceipt['subtotal'];
            $data->discount_percent = $testreceipt['discount_percent'];
            $data->discount_amount  = $testreceipt['discount_amount'];
            $data->vat_percent      = $testreceipt['vat_percent'];
            $data->vat_amount       = $testreceipt['vat_amount'];
            $data->others           = $testreceipt['others'];
            $data->total            = $testreceipt['total'];
            $data->paid             = $testreceipt['paid'];
            $data->due              = $testreceipt['due'];
            $data->remark           = $testreceipt['note'];
            $data->created_by       = auth()->user()->id;
            $data->ip_address       = $request->ip();
            $data->branch_id        = session('branch_id');
            $data->save(); 


            foreach ($testCart as $value) {
                TestReceiptDetail::create(array(
                    'test_receipt_id'   => $data->id,
                    'test_id'       => $value['productId'],
                    'amount'         => $value['price'],
                    'delivery_date' => $value['delivery_date'],
                    'delivery_time' => \Carbon\Carbon::parse($value['delivery_time']),
                    'created_by'    => auth()->user()->id,
                    'ip_address'    => $request->ip(),
                    'branch_id'     => session('branch_id')
                ));
            }


            DB::commit();
            return response()->json(['message' => 'Test Receipt Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function testReceiptUpdate(Request $request)
    {

        $testreceipt = $request->testreceipts;
        $testCart = $request->cartTests;
        $validator = Validator::make((array) $testreceipt, [
            'id'              => 'required|integer',
            'invoice_number'  => ['required','string',Rule::unique('test_receipts')->ignore($testreceipt['id'],'id')],
            'patient_id'      => 'required|integer',
            'bill_date'       => 'required|date',
            'subtotal'        => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'vat_percent'     => 'required|numeric',
            'vat_amount'      => 'required|numeric',
            'others'          => 'required|numeric',
            'total'           => 'required|numeric',
            'paid'            => 'required|numeric',
            'due'             => 'required|numeric',
        ]);
        
       

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $admissiontId= Admission::where('patient_id',$testreceipt['patient_id'])->first();

            $data                 = TestReceipt::find($testreceipt['id']);
            $data->invoice_number = $testreceipt['invoice_number'];
            $data->patient_id     = $testreceipt['patient_id'];
            $data->reference_id   = $testreceipt['reference_id'];

            if($admissiontId && $admissiontId->status == "Admited"){
                $data->admission_id       = $admissiontId->id;
            }else{
                $data->admission_id       = null;
            }

            $data->bill_date        = $testreceipt['bill_date'];
            $data->subtotal         = $testreceipt['subtotal'];
            $data->discount_percent = $testreceipt['discount_percent'];
            $data->discount_amount  = $testreceipt['discount_amount'];
            $data->vat_percent      = $testreceipt['vat_percent'];
            $data->vat_amount       = $testreceipt['vat_amount'];
            $data->others           = $testreceipt['others'];
            $data->total            = $testreceipt['total'];
            $data->paid             = $testreceipt['paid'];
            $data->due              = $testreceipt['due'];
            $data->remark           = $testreceipt['note'];
            $data->created_by       = auth()->user()->id;
            $data->ip_address       = $request->ip();
            $data->branch_id        = session('branch_id');
            $data->save();

            
            $deleteTestReceiptDetails=TestReceiptDetail::where('test_receipt_id',$testreceipt['id']);
            $deleteTestReceiptDetails->forceDelete();
           
            foreach ($testCart as $value) {
                TestReceiptDetail::create(array(
                    'test_receipt_id'   => $data->id,
                    'test_id'       => $value['productId'],
                    'amount'         => $value['price'],
                    'delivery_date' => $value['delivery_date'],
                    'delivery_time' => \Carbon\Carbon::parse($value['delivery_time']),
                    'created_by'    => auth()->user()->id,
                    'ip_address'    => $request->ip(),
                    'branch_id'     => session('branch_id')
                ));
            }


            DB::commit();
            return response()->json(['message' => 'Test Reciept Updated','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getTestReceipt(Request $request)
    {
        $clauses = "";
        if($request->testreceiptsId && $request->testreceiptsId != ''){
            $clauses .= " and tr.id = '$request->testreceiptsId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and tr.bill_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->patient_id && $request->patient_id != ''){
            $clauses .= " and tr.patient_id = '$request->patient_id'";
        }
        if($request->reference_id && $request->reference_id != ''){
            $clauses .= " and tr.reference_id = '$request->reference_id'";
        }

        if($request->userId && $request->userId != ''){
            $clauses .= " and tr.created_by = '$request->userId'";
        }
        
        //dd($request->purchaseId);
        $result = DB::select(
            "SELECT tr.*,
            concat_ws(' - ', tr.invoice_number, p.name) as invoice_text,
            concat_ws(' - ', p.patient_code , p.name) as display_text,
            concat_ws(' - ', a.agent_code , a.name) as reference_text,
            p.patient_code  as p_code,
            p.name as patient_name,
            p.mobile as patient_mobile,
            p.address as patient_address,
            u.name as user_name,
            ad.status as admission_status

            from test_receipts tr
            left join patients p on p.id = tr.patient_id
            left join admissions ad on ad.id = tr.admission_id
            left join agents a on a.id = tr.reference_id
            left join users u on u.id = tr.created_by
            where tr.deleted_at is null
            and tr.branch_id = ?
            $clauses
        ", [session('branch_id')]);

        //dd($result);
        
        if($request->with_details){
            foreach($result as $value){
                $value->testreceiptDetails = DB::select(
                    "SELECT trd.*,
                    t.room_number as room_number,
                    t.test_code as test_code,
                    t.name as test_name,
                    CASE
                        WHEN trd.report is not null THEN trd.report
                        ELSE t.template
                    END as investigation,
                    concat(t.test_code, ' - ', t.name) as display_name

                    from test_receipt_details trd
                    left join tests t on t.id = trd.test_id
                    where trd.test_receipt_id = '$value->id'
                ");
            }
        }

        return response()->json($result);
    }

    public function  getTestReceiptDetails(Request $request){
        
        $clauses = "";
        

        if($request->testreceiptsId && $request->testreceiptsId != ''){
            $clauses .= " and t.id = '$request->testreceiptsId'";
        }
        if($request->testreceiptsReportId && $request->testreceiptsReportId != ''){
            $clauses .= " and trd.id = '$request->testreceiptsReportId'";
        }
        if($request->statusType == 'Complete'){
            $clauses .= " and trd.is_completed != 0";
        }
        if($request->statusType == 'Delivery'){
            $clauses .= " and trd.is_delivered != 0";
        }

        

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and tr.bill_date between '$request->dateFrom' and '$request->dateTo'";
        }

        $result = DB::select(
            "SELECT trd.*,
                concat(t.test_code, ' - ', t.name) as display_name,
                tr.invoice_number,
                t.name as test_name,
                tr.bill_date,
                u.name as user_name,
                concat_ws(' - ', p.patient_code , p.name) as display_text,
                t.name as test_name,
                @_total_days := TIMESTAMPDIFF(DAY, date_of_birth, tr.bill_date),
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

            from test_receipt_details trd
            left join tests t on t.id = trd.test_id
            left join test_receipts tr on tr.id = trd.test_receipt_id
            left join patients p on p.id = tr.patient_id
            left join users u on u.id = tr.created_by
            where tr.deleted_at is null
            and trd.branch_id = ?
            $clauses
        ",[session('branch_id')]);

        return response()->json($result);
    }


    public function testReceiptInvoice($id)
    {
        $id = $id;
        return view('admin.pathology.test_receipt_invoice',compact('id'));
    }
    public function testReceiptReportInvoice($id)
    {
        $id = $id;
        return view('admin.pathology.test_receipt_report_invoice',compact('id'));
    }
    public function testReceiptRecord()
    {
        return view('admin.pathology.test_receipt_record');
    }
    public function testReceiptDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            TestReceipt::where('id', $request->id)->delete();
            TestReceiptDetail::where('test_receipt_id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Test Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function testInvestigation(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
            'investigation' => ['required'],
        ]);

        DB::beginTransaction();
        
        try {
            TestReceiptDetail::where('id', $request->id)->update(['report' => $request->investigation]);

            DB::commit();
            return response()->json(['message' => 'Report Saved']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function testReceiptCompleteChange(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
        ]);

        DB::beginTransaction();
        
        try {
            $data = TestReceiptDetail::find($request->id);
            $data->is_completed = $request->status;
            $data->save();

            $details = TestReceiptDetail::where('test_receipt_id', $data->test_receipt_id)->get()->pluck('is_completed')->toArray();

            if(in_array(0, $details)){
                TestReceipt::where('id', $data->test_receipt_id)->update(['is_completed' => 0]);
            }else{
                TestReceipt::where('id', $data->test_receipt_id)->update(['is_completed' => 1]);
            }

            DB::commit();
            return response()->json(['message' => 'Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function testReceiptDeliveryChange(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
        ]);

        DB::beginTransaction();
        
        try {
            $data = TestReceiptDetail::find($request->id);
            $data->is_delivered = $request->status;
            $data->save();

            $details = TestReceiptDetail::where('test_receipt_id', $data->test_receipt_id)->get()->pluck('is_delivered')->toArray();

            if(in_array(0, $details)){
                TestReceipt::where('id', $data->test_receipt_id)->update(['is_delivered' => 0]);
            }else{
                TestReceipt::where('id', $data->test_receipt_id)->update(['is_delivered' => 1]);
            }

            DB::commit();
            return response()->json(['message' => 'Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
}
