<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{

    public function accountEntry()
    {
        return view('admin.accounts.accounts_entry');
    }

    public function accountStore(Request $request)
    {
        $account = json_decode($request->accounts);

        $validator = Validator::make((array) $account, [
            'account_code' => 'required|string|unique:accounts',
            'account_name' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            //dd($request->name);
            
            $data               = New Account();
            $data->account_code = $account->account_code;
            $data->account_name = $account->account_name;
            $data->remark       = $account->remark;
            $data->created_by   = auth()->user()->id;
            $data->ip_address   = $request->ip();
            $data->branch_id    = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Account Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function accountUpdate(Request $request)
    {
        $account = json_decode($request->accounts);

        $validator = Validator::make((array) $account, [
            'account_code' => ['required','string',Rule::unique('accounts')->ignore($account->id,'id')],
            'account_name' => 'required|string|max:255',
            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        
        try {
            $data               = Account::find($account->id);
            $data->account_code = $account->account_code;
            $data->account_name = $account->account_name;
            $data->remark       = $account->remark;
            $data->updated_by   = auth()->user()->id;
            $data->ip_address   = $request->ip();
            $data->branch_id    = session('branch_id');
            $data->save(); 
            DB::commit();
            return response()->json(['message' => 'Account Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function accountDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Account::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Account Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getAccounts(Request $request)
    {
        $getAccount = DB::table('accounts as a')
        ->whereNull('a.deleted_at');
        $getAccount->selectRaw("a.*,
        concat( a.account_code, ' - ', a.account_name) as display_name
        ");
        $getAccount =  $getAccount->orderBy('a.id', 'asc')->lazy();

        return response()->json($getAccount);
    }
    public function getAccountCode()
    {
        return response()->json(generateAccountCode());
    }
    public function getCashTransactionCode()
    {
        return response()->json(generateCashTransactionCode());
    }

    public function bankaccountEntry()
    {
        return view('admin.accounts.bank_accounts_entry');
    }
   
    public function bankaccountStore(Request $request)
    {
        $bankaccount = json_decode($request->bankaccounts);

        $validator = Validator::make((array) $bankaccount, [
            'account_name'   => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_type'   => 'required|string|max:30',
            'bank_name'      => 'required|string|max:100',
            'branch_name'    => 'required|string|max:100'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            //dd($request->name);
            
            $data                 = New BankAccount();
            $data->account_name   = $bankaccount->account_name;
            $data->account_number = $bankaccount->account_number;
            $data->account_type   = $bankaccount->account_type;
            $data->bank_name      = $bankaccount->bank_name;
            $data->branch_name    = $bankaccount->branch_name;
            $data->remark         = $bankaccount->remark;
            $data->created_by     = auth()->user()->id;
            $data->ip_address     = $request->ip();
            $data->branch_id      = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Bank Account Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function bankaccountUpdate(Request $request)
    {
        $bankaccount = json_decode($request->bankaccounts);

        $validator = Validator::make((array) $bankaccount, [
            'account_name'   => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_type'   => 'required|string|max:30',
            'bank_name'      => 'required|string|max:100',
            'branch_name'    => 'required|string|max:100'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        
        try {
            $data                 = BankAccount::find($bankaccount->id);
            $data->account_name   = $bankaccount->account_name;
            $data->account_number = $bankaccount->account_number;
            $data->account_type   = $bankaccount->account_type;
            $data->bank_name      = $bankaccount->bank_name;
            $data->branch_name    = $bankaccount->branch_name;
            $data->remark         = $bankaccount->remark;
            $data->updated_by     = auth()->user()->id;
            $data->ip_address     = $request->ip();
            $data->branch_id      = session('branch_id');
            $data->save(); 
            DB::commit();
            return response()->json(['message' => 'Bank Account Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function bankaccountDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            BankAccount::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Bank Account Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getBankAccounts(Request $request)
    {
        $getBankAccount = DB::table('bank_accounts as ba')
        ->whereNull('ba.deleted_at');
        $getBankAccount->selectRaw(
            "ba.*,
            concat( ba.account_name, ' - ', ba.account_number,' (', ba.bank_name,')') as display_name
        ");
        $getBankAccount =  $getBankAccount->orderBy('ba.id', 'desc')->lazy();

        return response()->json($getBankAccount);
    }

    public function banktransactionEntry()
    {
        return view('admin.accounts.bank_transaction_entry');
    }
  
    public function banktransactionStore(Request $request)
    {
        $banktransaction = json_decode($request->banktransactions);

        $validator = Validator::make((array) $banktransaction, [
            'transaction_number' => 'required|string|max:20|unique:bank_transactions',
            'bank_account_id'    => 'required|integer',
            'transaction_date'   => 'required|date',
            'transaction_type'   => 'required|in:Deposit,Withdraw',
            'amount'             => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            //dd($request->name);
            
            $data                     = New BankTransaction();
            $data->transaction_number = $banktransaction->transaction_number;
            $data->bank_account_id    = $banktransaction->bank_account_id;
            $data->transaction_date   = $banktransaction->transaction_date;
            $data->transaction_type   = $banktransaction->transaction_type;
            $data->amount             = $banktransaction->amount;
            $data->remark             = $banktransaction->remark;
            $data->created_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Bank Transaction Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function banktransactionUpdate(Request $request)
    {
        $banktransaction = json_decode($request->banktransactions);

        $validator = Validator::make((array) $banktransaction, [
            'transaction_number' => ['required','string','max:20', Rule::unique('bank_transactions')->ignore($banktransaction->id,'id')],
            'bank_account_id'    => 'required|integer',
            'transaction_date'   => 'required|date',
            'transaction_type'   => 'required|in:Deposit,Withdraw',
            'amount'             => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        
        try {
            $data                     = BankTransaction::find($banktransaction->id);
            $data->transaction_number = $banktransaction->transaction_number;
            $data->bank_account_id    = $banktransaction->bank_account_id;
            $data->transaction_date   = $banktransaction->transaction_date;
            $data->transaction_type   = $banktransaction->transaction_type;
            $data->amount             = $banktransaction->amount;
            $data->remark             = $banktransaction->remark;
            $data->updated_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 
            DB::commit();
            return response()->json(['message' => 'Bank Transaction Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function banktransactionDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            BankTransaction::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Bank Transaction Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getBankTransactions(Request $request)
    {
        $getBankTransaction = DB::table('bank_transactions as bt')
        ->selectRaw("bt.*, concat( b.account_name, ' - ', b.account_number,' (', b.bank_name,')') as display_text")
        ->leftJoin('bank_accounts as b', 'b.id', '=', 'bt.bank_account_id' )
        ->whereNull('bt.deleted_at');
        if($request->date && $request->date != ''){
            $getBankTransaction->where('bt.transaction_date', $request->date);
        }
        $getBankTransaction= $getBankTransaction->orderBy('bt.id', 'desc')->lazy();

        return response()->json($getBankTransaction);
    }
    public function getBankTransactionCode()
    {
        return response()->json(generateBankTransactionCode());
    }
    public function cashtransactionEntry()
    {
        return view('admin.accounts.cash_transaction_entry');
    }


    public function cashtransactionReport()
    {
        return view('admin.accounts.cash_transaction_report');
    }
  
    public function cashtransactionStore(Request $request)
    {
        $cashtransaction = json_decode($request->cashtransactions);

        $validator = Validator::make((array) $cashtransaction, [
            'transaction_number' => 'required|string|max:20|unique:cash_transactions',
            'account_id'    => 'required|integer',
            'transaction_date'   => 'required|date',
            'transaction_type'   => 'required|in:Received,Payment',
            'amount'             => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            //dd($request->name);
            
            $data                     = New CashTransaction();
            $data->transaction_number = $cashtransaction->transaction_number;
            $data->account_id         = $cashtransaction->account_id;
            $data->transaction_date   = $cashtransaction->transaction_date;
            $data->transaction_type   = $cashtransaction->transaction_type;
            $data->amount             = $cashtransaction->amount;
            $data->remark             = $cashtransaction->remark;
            $data->created_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Cash Transaction Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function cashtransactionUpdate(Request $request)
    {
        $cashtransaction = json_decode($request->cashtransactions);

        $validator = Validator::make((array) $cashtransaction, [
            'transaction_number' => ['required','string','max:20', Rule::unique('cash_transactions')->ignore($cashtransaction->id,'id')],
            'account_id'         => 'required|integer',
            'transaction_date'   => 'required|date',
            'transaction_type'   => 'required|in:Received,Payment',
            'amount'             => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        
        try {
            $data                     = CashTransaction::find($cashtransaction->id);
            $data->transaction_number = $cashtransaction->transaction_number;
            $data->account_id         = $cashtransaction->account_id;
            $data->transaction_date   = $cashtransaction->transaction_date;
            $data->transaction_type   = $cashtransaction->transaction_type;
            $data->amount             = $cashtransaction->amount;
            $data->remark             = $cashtransaction->remark;
            $data->updated_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 
            DB::commit();
            return response()->json(['message' => 'Cash Transaction Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function cashtransactionDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            CashTransaction::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Cash Transaction Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getCashTransactions(Request $request)
    {
        
        $getCashTransaction = DB::table('cash_transactions as ct')
        ->selectRaw("ct.*, concat( a.account_code, ' - ', a.account_name) as display_text")
        ->leftJoin('accounts as a', 'a.id', '=', 'ct.account_id' )
        ->whereNull('ct.deleted_at');

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $getCashTransaction->whereBetween('ct.transaction_date', [$request->dateFrom, $request->dateTo]);
        }

        if($request->date && $request->date != ''){
            $getCashTransaction->where('ct.transaction_date', $request->date);
        }

        if($request->transactionType == 'Received'){
            $getCashTransaction->where('ct.transaction_type', '=' , 'Received');
        }

        if($request->transactionType == 'Payment'){
            $getCashTransaction->where('ct.transaction_type', '=' , 'Payment');
        }
        
        if($request->accountId && $request->accountId != ''){
            $getCashTransaction->where('ct.account_id', $request->accountId);
        }
        $getCashTransaction= $getCashTransaction->orderBy('ct.id', 'desc')->lazy();

        return response()->json($getCashTransaction);
    }
    public function getBankTransactionsReport(Request $request)
    {
        $clauses = "";
        $order = "sequence, id desc";

        if($request->accountId && $request->accountId != null){
            $clauses .= " and account_id = '$request->accountId'";
        }

        if($request->dateFrom && $request->dateFrom != '' 
        && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and transaction_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->transactionType && $request->transactionType != ''){
            $clauses .= " and transaction_type = '$request->transactionType'";
        }

        if($request->ledger) {
            $order = "transaction_date, sequence, id";
        }
        $getBankTransaction = DB::select("
        select * from(
            select 
                'a' as sequence,
                bt.id as id,
                bt.transaction_type as description,
                bt.bank_account_id as account_id,
                bt.transaction_date,
                'Received' as transaction_type,
                bt.amount as deposit,
                0.00 as withdraw,
                bt.remark,
                ac.account_name,
                ac.account_number,
                ac.bank_name,
                ac.branch_name,
                0.00 as balance
            from bank_transactions bt
            join bank_accounts ac on ac.id = bt.bank_account_id 
            where bt.deleted_at is null
            and bt.transaction_type = 'Deposit'
            and bt.branch_id = " .session('branch_id') . "

            UNION
            select 
                'b' as sequence,
                bt.id as id,
                bt.transaction_type as description,
                bt.bank_account_id  as account_id,
                bt.transaction_date,
                'Payment' as transaction_type,
                0.00 as deposit,
                bt.amount as withdraw,
                bt.remark,
                ac.account_name,
                ac.account_number,
                ac.bank_name,
                ac.branch_name,
                0.00 as balance
            from bank_transactions bt
            join bank_accounts ac on ac.id = bt.bank_account_id 
            where bt.deleted_at is null
            and bt.transaction_type = 'Withdraw'
            and bt.branch_id = " .session('branch_id') . "

            UNION
            select
                'c' as sequence,
                pp.id as id,
                concat('Payment Received - ', p.name, ' (', p.patient_code, ')') as description, 
                pp.account_id as account_id,
                pp.payment_date  as transaction_date,
                'Received' as transaction_type,
                pp.amount as deposit,
                0.00 as withdraw,
                pp.remark as note,
                ac.account_name,
                ac.account_number,
                ac.bank_name,
                ac.branch_name,
                0.00 as balance
            from patient_payments pp
            join bank_accounts ac on ac.id = pp.account_id
            left join patients p on p.id = pp.patient_id 
            where pp.deleted_at is null
            and pp.transaction_type = 'Received'
            and pp.branch_id = " . session('branch_id') . "
            
            UNION
            select
                'd' as sequence,
                pp.id as id,
                concat('paid to Patient - ', p.name, ' (', p.patient_code, ')') as description, 
                pp.account_id as account_id,
                pp.payment_date as transaction_date,
                'Payment' as transaction_type,
                0.00 as deposit,
                pp.amount as withdraw,
                pp.remark as note,
                ac.account_name,
                ac.account_number,
                ac.bank_name,
                ac.branch_name,
                0.00 as balance
            from patient_payments pp
            join bank_accounts ac on ac.id = pp.account_id
            left join patients p on p.id = pp.patient_id 
            where pp.deleted_at is null
            and pp.transaction_type = 'Payment'
            and pp.branch_id = " . session('branch_id') . "

            UNION
            select
                'e' as sequence,
                sp.id as id,
                concat('Paid - ', s.name, ' (', s.supplier_code, ')') as description, 
                sp.account_id as account_id,
                sp.payment_date as transaction_date,
                'Payment' as transaction_type,
                0.00 as deposit,
                sp.amount as withdraw,
                sp.remark as note,
                ac.account_name,
                ac.account_number,
                ac.bank_name,
                ac.branch_name,
                0.00 as balance
            from supplier_payments sp
            join bank_accounts ac on ac.id = sp.account_id
            left join suppliers s on s.id = sp.supplier_id 
            where sp.deleted_at is null
            and sp.transaction_type = 'Payment'
            and sp.branch_id = " . session('branch_id') . "
            
            UNION
            select
                'f' as sequence,
                sp.id as id,
                concat('Received from supplier  - ', s.name, ' (', s.supplier_code, ')') as description, 
                sp.account_id as account_id,
                sp.payment_date as transaction_date,
                'Received' as transaction_type,
                sp.amount as deposit,
                0.00 as withdraw,
                sp.remark as note,
                ac.account_name,
                ac.account_number,
                ac.bank_name,
                ac.branch_name,
                0.00 as balance
            from supplier_payments sp
            join bank_accounts ac on ac.id = sp.account_id
            left join suppliers s on s.id = sp.supplier_id 
            where sp.deleted_at is null
            and sp.transaction_type = 'Received'
            and sp.branch_id = " . session('branch_id') . "
        ) as tbl
        where 1 = 1 $clauses
        order by $order
        ");
        return response()->json($getBankTransaction);
    }
    public function getCashLedgerReport(Request $request)
    {
      $previousBalance = generatePrevioueCashLadger($request->fromDate)->cash_balance;
        
        $ledger = DB::select("
        /* Cash In */
            SELECT 
                a.id as id,
                a.admission_date as date,
                concat('Admission Recieved - ', a.admission_code , ' - ', p.name, ' (', p.patient_code, ')') as description,
                a.received_amount as in_amount,
                0.00 as out_amount
            from admissions a 
            left join patients p on p.id = a.patient_id
            where a.deleted_at is null
            and a.branch_id  = " . session('branch_id') . "
            and a.admission_date between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                ab.id as id,
                ab.bill_date  as date,
                concat('Ambulance Bill - ', ab.invoice_number , ' - ', d.name, ' (', d.driver_code, ')', ' - Bill: ', ab.bill_amount) as description,
                ab.paid as in_amount,
                0.00 as out_amount
            from ambulance_bills ab 
            left join drivers d on d.id = ab.patient_id
            where ab.deleted_at is null
            and ab.branch_id  = " . session('branch_id') . "
            and ab.bill_date  between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                bt.id as id,
                bt.transaction_date  as date,
                concat('Bank withdraw - ', b.bank_name, ' - ', b.branch_name, ' - ', b.account_name, ' - ', b.account_number) as description,
                bt.amount as in_amount,
                0.00 as out_amount
            from bank_transactions bt 
            left join bank_accounts b on b.id = bt.bank_account_id
            where bt.deleted_at is null
            and bt.branch_id  = " . session('branch_id') . "
            and bt.transaction_type = 'Withdraw'
            and bt.transaction_date  between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                b.id as id,
                b.bill_date  as date,
                concat(bt.name, ' Bill Recieved - ', p.name, ' (', p.patient_code, ')') as description,
                b.amount as in_amount,
                0.00 as out_amount
            from bills b 
            left join patients p on p.id = b.patient_id
            left join bill_types bt on bt.id = b.bill_type_id
            where b.deleted_at is null
            and b.branch_id  = " . session('branch_id') . "
            and b.transaction_type = 'Received'
            and b.bill_date   between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                ct.id as id,
                ct.transaction_date  as date,
                concat('Recieved - ', a.account_name, ' (', a.account_code, ')' , ' - ', ct.remark) as description,
                ct.amount as in_amount,
                0.00 as out_amount
            from cash_transactions ct 
            left join accounts a on a.id = ct.account_id
            where ct.deleted_at is null
            and ct.branch_id  = " . session('branch_id') . "
            and ct.transaction_type = 'Received'
            and ct.transaction_date   between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                cp.id as id,
                cp.payment_date  as date,
                concat('Commission Recieved By ', cp.reference_type,' - ' , a.name , ' (', a.agent_code, ')') as description,
                cp.amount as in_amount,
                0.00 as out_amount
            from commission_payments cp 
            left join agents a on a.id = cp.reference_id
            where cp.deleted_at is null
            and cp.branch_id  = " . session('branch_id') . "
            and cp.payment_type  != 'Bank'
            and cp.transaction_type = 'Received'
            and cp.payment_date   between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                pp.id as id,
                pp.payment_date  as date,
                concat('Recieved to Patient - ', pp.transaction_number , ' - ', p.name, ' (', p.patient_code, ')') as description,
                pp.amount as in_amount,
                0.00 as out_amount
            from patient_payments pp 
            left join patients p on p.id = pp.patient_id
            where pp.deleted_at is null
            and pp.branch_id  = " . session('branch_id') . "
            and pp.payment_type  != 'Bank'
            and pp.transaction_type = 'Received'
            and pp.payment_date   between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                rs.id as id,
                rs.slip_date  as date,
                concat('Recieved to Release Slip - ', 'Admission No. ', a.admission_code , ' - ', p.name, ' (', p.patient_code, ')') as description,
                rs.amount as in_amount,
                0.00 as out_amount
            from release_slips rs 
            left join patients p on p.id = rs.patient_id
            left join admissions a on a.id = rs.admission_id
            where rs.deleted_at is null
            and rs.branch_id  = " . session('branch_id') . "
            and rs.slip_date  between '$request->fromDate' and '$request->toDate'

            UNION
            SELECT 
                s.id as id,
                s.order_date  as date,
                concat('Sale - ', s.invoice_number , ' - ', p.name, ' (', p.patient_code, ')', ', Bill-', s.total) as description,
                s.paid as in_amount,
                0.00 as out_amount
            from sales s 
            left join patients p on p.id = s.patient_id
            where s.deleted_at is null
            and s.branch_id  = " . session('branch_id') . "
            and s.order_date  between '$request->fromDate' and '$request->toDate'

            UNION
            SELECT 
                sp.id as id,
                sp.payment_date  as date,
                concat('Recieved to Inventory Supplier - ', sp.transaction_number , ' - ', s.name, ' (', s.supplier_code, ')') as description,
                sp.amount as in_amount,
                0.00 as out_amount
            from supplier_payments sp 
            left join suppliers s on s.id = sp.supplier_id 
            where sp.deleted_at is null
            and sp.branch_id  = " . session('branch_id') . "
            and sp.payment_type  != 'Bank'
            and sp.transaction_type = 'Received'
            and sp.use_for  = 'Instrument'
            and sp.payment_date   between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                sp.id as id,
                sp.payment_date  as date,
                concat('Recieved to Medicine Supplier - ', sp.transaction_number , ' - ', s.name, ' (', s.supplier_code, ')') as description,
                sp.amount as in_amount,
                0.00 as out_amount
            from supplier_payments sp 
            left join suppliers s on s.id = sp.supplier_id 
            where sp.deleted_at is null
            and sp.branch_id  = " . session('branch_id') . "
            and sp.payment_type  != 'Bank'
            and sp.transaction_type = 'Received'
            and sp.use_for  = 'Medicine'
            and sp.payment_date   between '$request->fromDate' and '$request->toDate'

            UNION
            SELECT 
                tr.id as id,
                tr.bill_date  as date,
                concat('Recieved To Test - ', tr.invoice_number , ' - ', p.name, ' (', p.patient_code, ')', ', Bill-', tr.total) as description,
                tr.paid as in_amount,
                0.00 as out_amount
            from  test_receipts tr 
            left join patients p on p.id = tr.patient_id
            where tr.deleted_at is null
            and tr.branch_id  = " . session('branch_id') . "
            and tr.bill_date  between '$request->fromDate' and '$request->toDate'


            /* Cash out */
            UNION
            SELECT 
                bt.id as id,
                bt.transaction_date  as date,
                concat('Bank Deposit - ', b.bank_name, ' - ', b.branch_name, ' - ', b.account_name, ' - ', b.account_number) as description,
                0.00 as in_amount,
                bt.amount as out_amount
            from bank_transactions bt 
            left join bank_accounts b on b.id = bt.bank_account_id
            where bt.deleted_at is null
            and bt.branch_id  = " . session('branch_id') . "
            and bt.transaction_type = 'Deposit'
            and bt.transaction_date  between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                ct.id as id,
                ct.transaction_date  as date,
                concat('Payment - ', a.account_name, ' (', a.account_code, ')', ' - ', ct.remark) as description,
                0.00 as in_amount,
                ct.amount as out_amount
            from cash_transactions ct 
            left join accounts a on a.id = ct.account_id
            where ct.deleted_at is null
            and ct.branch_id  = " . session('branch_id') . "
            and ct.transaction_type = 'Payment'
            and ct.transaction_date   between '$request->fromDate' and '$request->toDate'

            UNION
            SELECT 
                cp.id as id,
                cp.payment_date  as date,
                concat('Commission Paid By ', cp.reference_type,' - ' , a.name , ' (', a.agent_code, ')') as description,
                0.00 as in_amount,
                cp.amount as out_amount
            from commission_payments cp 
            left join agents a on a.id = cp.reference_id
            where cp.deleted_at is null
            and cp.branch_id  = " . session('branch_id') . "
            and cp.payment_type  != 'Bank'
            and cp.transaction_type = 'Payment'
            and cp.payment_date   between '$request->fromDate' and '$request->toDate'

            UNION
            SELECT 
                pp.id as id,
                pp.payment_date  as date,
                concat('Recieved to Patient - ', pp.transaction_number , ' - ', p.name, ' (', p.patient_code, ')') as description,
                0.00 as in_amount,
                pp.amount as out_amount
            from patient_payments pp 
            left join patients p on p.id = pp.patient_id
            where pp.deleted_at is null
            and pp.branch_id  = " . session('branch_id') . "
            and pp.payment_type  != 'Bank'
            and pp.transaction_type = 'Payment'
            and pp.payment_date   between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                p.id as id,
                p.order_date  as date,
                concat('Inventory Purchase - ', p.invoice_number  , ' - ', s.name, ' (', s.supplier_code, ')', ', Bill-', p.total) as description,
                0.00 as in_amount,
                p.paid as out_amount
            from  purchases p 
            left join suppliers s on s.id = p.supplier_id 
            where p.deleted_at is null
            and p.branch_id  = " . session('branch_id') . "
            and p.use_for = 'Instrument'
            and p.order_date   between '$request->fromDate' and '$request->toDate'
    
            UNION
            SELECT 
                p.id as id,
                p.order_date  as date,
                concat('Medicine Purchase - ', p.invoice_number  , ' - ', s.name, ' (', s.supplier_code, ')' , ', Bill-', p.total) as description,
                0.00 as in_amount,
                p.paid as out_amount
            from  purchases p 
            left join suppliers s on s.id = p.supplier_id 
            where p.deleted_at is null
            and p.branch_id  = " . session('branch_id') . "
            and p.use_for = 'Medicine'
            and p.order_date   between '$request->fromDate' and '$request->toDate'
    
            UNION
            SELECT 
                s.id as id,
                s.payment_date  as date,
                concat('Salary Paid - ', s.transaction_number   , ' - ', m.name ) as description,
                0.00 as in_amount,
                s.total_payment_amount as out_amount
            from  salaries s 
            left join months m on m.id = s.month_id 
            where s.deleted_at is null
            and s.branch_id  = " . session('branch_id') . "
            and s.payment_date  between '$request->fromDate' and '$request->toDate'
    
            UNION
            SELECT 
                sp.id as id,
                sp.payment_date  as date,
                concat('Paid to Medicine Supplier - ', sp.transaction_number , ' - ', s.name, ' (', s.supplier_code, ')') as description,
                0.00 as in_amount,
                sp.amount as out_amount
            from supplier_payments sp 
            left join suppliers s on s.id = sp.supplier_id 
            where sp.deleted_at is null
            and sp.branch_id  = " . session('branch_id') . "
            and sp.payment_type  != 'Bank'
            and sp.transaction_type = 'Payment'
            and sp.use_for  = 'Medicine'
            and sp.payment_date   between '$request->fromDate' and '$request->toDate'

            UNION
            SELECT 
                sp.id as id,
                sp.payment_date  as date,
                concat('Paid to Inventory Supplier - ', sp.transaction_number , ' - ', s.name, ' (', s.supplier_code, ')') as description,
                0.00 as in_amount,
                sp.amount as out_amount
            from supplier_payments sp 
            left join suppliers s on s.id = sp.supplier_id 
            where sp.deleted_at is null
            and sp.branch_id  = " . session('branch_id') . "
            and sp.payment_type  != 'Bank'
            and sp.transaction_type = 'Payment'
            and sp.use_for  = 'Instrument'
            and sp.payment_date   between '$request->fromDate' and '$request->toDate'
           

            order by date, id
        ");

        $ledger = array_map(function($ind, $row) use($previousBalance, $ledger) {
            $row->balance = (($ind == 0 ? $previousBalance : $ledger[$ind - 1]->balance) + $row->in_amount) - $row->out_amount;
            return $row;
        }, array_keys($ledger), $ledger);

        //print_r($ledger);

        $res['ledger'] =  $ledger;
        $res['previousBalance'] =  $previousBalance;

        return response()->json($res);
    }
    public function getBankLedgerReport(Request $request)
    {
      $previousBalance = generateBankLadger($request->accountId,$request->fromDate)->bank_balance;
        
        $ledger = DB::select("
        /* Cash In */
            
            SELECT 
                bt.id as id,
                bt.transaction_date  as date,
                concat('Bank withdraw - ', b.bank_name, ' - ', b.branch_name, ' - ', b.account_name, ' - ', b.account_number) as description,
                0.00 as in_amount,
                bt.amount as out_amount
            from bank_transactions bt 
            left join bank_accounts b on b.id = bt.bank_account_id
            where bt.deleted_at is null
            and bt.branch_id  = " . session('branch_id') . "
            and bt.bank_account_id  = ".$request->accountId."
            and bt.transaction_type = 'Withdraw'
            and bt.transaction_date  between '$request->fromDate' and '$request->toDate'
           
            
            UNION
            SELECT 
                cp.id as id,
                cp.payment_date  as date,
                concat('Commission Recieved By ', cp.reference_type,' - ' , a.name , ' (', a.agent_code, ')') as description,
                cp.amount as in_amount,
                0.00 as out_amount
            from commission_payments cp 
            left join agents a on a.id = cp.reference_id
            where cp.deleted_at is null
            and cp.branch_id  = " . session('branch_id') . "
            and cp.account_id  = ".$request->accountId."
            and cp.payment_type  = 'Bank'
            and cp.transaction_type = 'Received'
            and cp.payment_date   between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                pp.id as id,
                pp.payment_date  as date,
                concat('Recieved to Patient - ', pp.transaction_number , ' - ', p.name, ' (', p.patient_code, ')') as description,
                pp.amount as in_amount,
                0.00 as out_amount
            from patient_payments pp 
            left join patients p on p.id = pp.patient_id
            where pp.deleted_at is null
            and pp.branch_id  = " . session('branch_id') . "
            and pp.account_id  = ".$request->accountId."
            and pp.payment_type  = 'Bank'
            and pp.transaction_type = 'Received'
            and pp.payment_date   between '$request->fromDate' and '$request->toDate'
           
            
            UNION
            SELECT 
                sp.id as id,
                sp.payment_date  as date,
                concat('Recieved to Inventory Supplier - ', sp.transaction_number , ' - ', s.name, ' (', s.supplier_code, ')') as description,
                sp.amount as in_amount,
                0.00 as out_amount
            from supplier_payments sp 
            left join suppliers s on s.id = sp.supplier_id 
            where sp.deleted_at is null
            and sp.branch_id  = " . session('branch_id') . "
            and sp.account_id  = ".$request->accountId."
            and sp.payment_type  = 'Bank'
            and sp.transaction_type = 'Received'
            and sp.use_for  = 'Instrument'
            and sp.payment_date   between '$request->fromDate' and '$request->toDate'
           
            UNION
            SELECT 
                sp.id as id,
                sp.payment_date  as date,
                concat('Recieved to Medicine Supplier - ', sp.transaction_number , ' - ', s.name, ' (', s.supplier_code, ')') as description,
                sp.amount as in_amount,
                0.00 as out_amount
            from supplier_payments sp 
            left join suppliers s on s.id = sp.supplier_id 
            where sp.deleted_at is null
            and sp.branch_id  = " . session('branch_id') . "
            and sp.account_id  = ".$request->accountId."
            and sp.payment_type  = 'Bank'
            and sp.transaction_type = 'Received'
            and sp.use_for  = 'Medicine'
            and sp.payment_date   between '$request->fromDate' and '$request->toDate'

        

            /* Cash out */
            UNION
            SELECT 
                bt.id as id,
                bt.transaction_date  as date,
                concat('Bank Deposit - ', b.bank_name, ' - ', b.branch_name, ' - ', b.account_name, ' - ', b.account_number) as description,
                bt.amount as in_amount,
                0.00 as out_amount
            from bank_transactions bt 
            left join bank_accounts b on b.id = bt.bank_account_id
            where bt.deleted_at is null
            and bt.branch_id  = " . session('branch_id') . "
            and bt.bank_account_id  = ".$request->accountId."
            and bt.transaction_type = 'Deposit'
            and bt.transaction_date  between '$request->fromDate' and '$request->toDate'
           
            
            UNION
            SELECT 
                cp.id as id,
                cp.payment_date  as date,
                concat('Commission Paid By ', cp.reference_type,' - ' , a.name , ' (', a.agent_code, ')') as description,
                0.00 as in_amount,
                cp.amount as out_amount
            from commission_payments cp 
            left join agents a on a.id = cp.reference_id
            where cp.deleted_at is null
            and cp.branch_id  = " . session('branch_id') . "
            and cp.account_id  = ".$request->accountId."
            and cp.payment_type  = 'Bank'
            and cp.transaction_type = 'Payment'
            and cp.payment_date   between '$request->fromDate' and '$request->toDate'

            UNION
            SELECT 
                pp.id as id,
                pp.payment_date  as date,
                concat('Recieved to Patient - ', pp.transaction_number , ' - ', p.name, ' (', p.patient_code, ')') as description,
                0.00 as in_amount,
                pp.amount as out_amount
            from patient_payments pp 
            left join patients p on p.id = pp.patient_id
            where pp.deleted_at is null
            and pp.branch_id  = " . session('branch_id') . "
            and pp.account_id  = ".$request->accountId."
            and pp.payment_type  = 'Bank'
            and pp.transaction_type = 'Payment'
            and pp.payment_date   between '$request->fromDate' and '$request->toDate'
           
           
            UNION
            SELECT 
                sp.id as id,
                sp.payment_date  as date,
                concat('Paid to Medicine Supplier - ', sp.transaction_number , ' - ', s.name, ' (', s.supplier_code, ')') as description,
                0.00 as in_amount,
                sp.amount as out_amount
            from supplier_payments sp 
            left join suppliers s on s.id = sp.supplier_id 
            where sp.deleted_at is null
            and sp.branch_id  = " . session('branch_id') . "
            and sp.account_id  = ".$request->accountId."
            and sp.payment_type  = 'Bank'
            and sp.transaction_type = 'Payment'
            and sp.use_for  = 'Medicine'
            and sp.payment_date   between '$request->fromDate' and '$request->toDate'

            UNION
            SELECT 
                sp.id as id,
                sp.payment_date  as date,
                concat('Paid to Inventory Supplier - ', sp.transaction_number , ' - ', s.name, ' (', s.supplier_code, ')') as description,
                0.00 as in_amount,
                sp.amount as out_amount
            from supplier_payments sp 
            left join suppliers s on s.id = sp.supplier_id 
            where sp.deleted_at is null
            and sp.branch_id  = " . session('branch_id') . "
            and sp.account_id  = ".$request->accountId."
            and sp.payment_type  = 'Bank'
            and sp.transaction_type = 'Payment'
            and sp.use_for  = 'Instrument'
            and sp.payment_date   between '$request->fromDate' and '$request->toDate'
           

            order by date, id
        ");

        $ledger = array_map(function($ind, $row) use($previousBalance, $ledger) {
            $row->balance = (($ind == 0 ? $previousBalance : $ledger[$ind - 1]->balance) + $row->in_amount) - $row->out_amount;
            return $row;
        }, array_keys($ledger), $ledger);

        //print_r($ledger);

        $res['ledger'] =  $ledger;
        $res['previousBalance'] =  $previousBalance;

        return response()->json($res);
    }
    public function getCashViewReport(Request $request)
    {
        $cashBalance = generatePrevioueCashLadger()->cash_balance;
        $bankBalance = generatePrevioueBankLadger();

        $res['cashBalance'] =  $cashBalance;
        $res['bankBalance'] =  $bankBalance;

        return response()->json($res);
    }
   

    public function banktransactionReport()
    {
        return view('admin.accounts.bank_transaction_report');
    }
    public function cashLedgerReport()
    {
        return view('admin.accounts.cash_ledger_report');
    }
    public function bankLedgerReport()
    {
        return view('admin.accounts.bank_ledger_report');
    }
    public function cashViewReport()
    {
        return view('admin.accounts.cash_view_report');
    }


    

    
   
}
