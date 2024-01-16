<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Issue;
use App\Models\Damage;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Instrument;
use App\Models\IssueDetail;
use Illuminate\Http\Request;
use App\Models\PurchaseDetail;
use App\Models\PurchaseReturn;
use App\Models\InstrumentStock;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseReturnDetail;
use App\Models\SupplierPayment;
use Illuminate\Support\Facades\Validator;

class InventroyController extends Controller
{

   
////Category for Medicine Controller

    public function categoryEntryInventory()
    {
        return view('admin.inventory.category_entry_inventory');
    }

    public function categoryStoreInventory(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();

            $data['use_for']    = 'Instrument';
            $data['created_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();
            $data['branch_id']  = session('branch_id');

            Category::create($data);

            DB::commit();
            return response()->json(['message' => 'Inventory Category Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function categoryUpdateInventory(Request $request)
    {
        $request->validate([
            'id'   => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();

            $data['use_for']    = 'Instrument';
            $data['updated_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();

            Category::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Inventory Category Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function categoryDeleteInventory(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Category::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Inventory Category Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getCategoriesInventory(Request $request)
    {
        $categoriesInventory = DB::table('categories as a')
        ->where('a.use_for','Instrument')
        ->whereNull('a.deleted_at');

        $categoriesInventory->select("a.*");

        $categoriesInventory =  $categoriesInventory->orderBy('a.id', 'desc')->lazy();

        return response()->json($categoriesInventory);
    }
////Unit for Inventory Controller

    public function unitEntryInventory()
    {
        return view('admin.inventory.unit_entry_inventory');
    }

    public function unitStoreInventory(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();

            $data['use_for']    = 'Instrument';
            $data['created_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();
            $data['branch_id']  = session('branch_id');

            Unit::create($data);

            DB::commit();
            return response()->json(['message' => 'Inventory Unit Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function unitUpdateInventory(Request $request)
    {
        $request->validate([
            'id'   => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();

            $data['use_for']    = 'Instrument';
            $data['updated_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();

            Unit::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Inventory Unit Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function unitDeleteInventory(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Unit::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Inventory Unit Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getUnitsInventory(Request $request)
    {
        $unitsInventory = DB::table('units as a')
        ->where('a.use_for','Instrument')
        ->whereNull('a.deleted_at');

        $unitsInventory->select("a.*");

        $unitsInventory =  $unitsInventory->orderBy('a.id', 'desc')->lazy();

        return response()->json($unitsInventory);
    }

    public function instrumentEntry()
    {
        return view('admin.inventory.instrument_entry');
    }

    public function instrumentStore(Request $request)
    {
        $instrument = json_decode($request->instruments);

        $validator = Validator::make((array) $instrument, [
            'instrument_code' => 'required|string|unique:instruments',
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|integer',
            'unit_id'         => 'required|integer',
            'reorder_level'   => 'required|numeric',
            'purchase_price'  => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
           
            $data                  = New Instrument();
            $data->name            = $instrument->name;
            $data->instrument_code = $instrument->instrument_code;
            $data->category_id     = $instrument->category_id;
            $data->unit_id         = $instrument->unit_id;
            $data->purchase_price  = $instrument->purchase_price;
            $data->reorder_level   = $instrument->reorder_level;
            $data->created_by      = auth()->user()->id;
            $data->ip_address      = $request->ip();
            $data->branch_id       = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Instrument Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function instrumentUpdate(Request $request)
    {
        $instrument = json_decode($request->instruments);

        $validator = Validator::make((array) $instrument, [
            'id'              => 'required|integer',
            'instrument_code' => ['required','string',Rule::unique('instruments')->ignore($instrument->id,'id')],
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|integer',
            'unit_id'         => 'required|integer',
            'reorder_level'   => 'required|numeric',
            'purchase_price'  => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        
        try {
            $data=Instrument::find($instrument->id);
           
            $data->name            = $instrument->name;
            $data->instrument_code = $instrument->instrument_code;
            $data->category_id     = $instrument->category_id;
            $data->unit_id         = $instrument->unit_id;
            $data->purchase_price  = $instrument->purchase_price;
            $data->reorder_level   = $instrument->reorder_level;
            $data->updated_by      = auth()->user()->id;
            $data->ip_address      = $request->ip();
            $data->branch_id       = session('branch_id');
            $data->save(); 
            DB::commit();
            return response()->json(['message' => 'Instrument Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function instrumentDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Instrument::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Instrument Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getInstruments(Request $request)
    {
        $getInstrument = DB::table('instruments as ins')
        ->whereNull('ins.deleted_at')
        ->selectRaw("ins.*,c.name as category_name,u.name as unit_name, concat(ins.name, ' - ', ins.instrument_code) as display_text")
        ->leftJoin('categories as c', 'c.id', '=', 'ins.category_id')
        ->leftJoin('units as u', 'u.id', '=', 'ins.unit_id')
        ->orderBy('ins.id', 'desc')->lazy();

        return response()->json($getInstrument);
    }

    public function getInstrumentCode()
    {
        return response()->json(generateInstrumentCode());
    }


    public function supplierInventoryEntry()
    {
        return view('admin.inventory.inventory_supplier_entry');
    }

    public function supplierInventoryStore(Request $request)
    {
        $supplierInventory = json_decode($request->supplierinventorys);

        $validator = Validator::make((array) $supplierInventory, [
            'supplier_code' => 'required|string|unique:suppliers',
            'name'          => 'required|string|max:255',
            'owner_name'    => 'required|string|max:255',
            'mobile'        => 'required|string|size:11'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data                = New Supplier();
            $data->name          = $supplierInventory->name;
            $data->supplier_code = $supplierInventory->supplier_code;
            $data->owner_name    = $supplierInventory->owner_name;
            $data->mobile        = $supplierInventory->mobile;
            $data->address       = $supplierInventory->address;
            $data->remark        = $supplierInventory->remark;
            $data->use_for       = 'Instrument';
            $data->created_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Inventory Supplier Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function supplierInventoryUpdate(Request $request)
    {
        

        $supplierInventory = json_decode($request->supplierinventorys);

        $validator = Validator::make((array) $supplierInventory, [
            'id'            => 'required|integer',
            'supplier_code' => ['required','string',Rule::unique('suppliers')->ignore($supplierInventory->id,'id')],
            'name'          => 'required|string|max:255',
            'owner_name'    => 'required|string|max:255',
            'mobile'        => 'required|string|size:11'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        
        try {
            $data                = Supplier::find($supplierInventory->id);
            $data->name          = $supplierInventory->name;
            $data->supplier_code = $supplierInventory->supplier_code;
            $data->owner_name    = $supplierInventory->owner_name;
            $data->mobile        = $supplierInventory->mobile;
            $data->address       = $supplierInventory->address;
            $data->remark        = $supplierInventory->remark;
            $data->use_for       = 'Instrument';
            $data->updated_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 
            DB::commit();
            return response()->json(['message' => 'Inventory Supplier Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function supplierInventoryDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Supplier::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Inventory Supplier Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getSupplierInventorys(Request $request)
    {
        $getSupplierInventory = DB::table('suppliers as si')
        ->whereNull('si.deleted_at')
        ->selectRaw("si.*,concat_ws(' - ', si.supplier_code , si.name) as display_name")
        ->where('si.use_for','Instrument')
        ->orderBy('si.id', 'desc')->lazy();
        return response()->json($getSupplierInventory);
    }
    public function getSupplierInventoryCode()
    {
        return response()->json(generateSupplierInventoryCode());
    }

    public function purchaseOrderInventoryEntry()
    {
        $id = 0;
        $invoice = generatePurchaseOrderInventoryCode();
        return view('admin.inventory.purchase_order_inventory_entry',compact('id','invoice'));
    }

    public function damageInventoryEntry()
    {
        $code = generateDamageInventoryCode();
        return view('admin.inventory.damage_inventory_entry',compact('code'));
    }
    public function damageInventoryList()
    {
        return view('admin.inventory.damage_inventory_list');
    }
    public function purchaseInventoryRecord()
    {
        return view('admin.inventory.purchase_inventory_record');
    }
    public function issueInventoryRecord()
    {
        return view('admin.inventory.issue_inventory_record');
    }
    public function stockInventory()
    {
        return view('admin.inventory.stock_inventory');
    }
    public function purchaseOrderInventoryEdit($id)
    {
        $id = $id;
        $purs = Purchase::findOrFail($id);
        $invoice = $purs->invoice_number;
        return view('admin.inventory.purchase_order_inventory_entry',compact('id','invoice'));
    }
    public function issueOrderInventoryEdit($id)
    {
        $id = $id;
        $purs = Issue::findOrFail($id);
        $invoice = $purs->invoice_number;
        return view('admin.inventory.issue_inventory_entry',compact('id','invoice'));
    }
    public function purchaseOrderInventoryInvoice($id)
    {
        $id = $id;
        return view('admin.inventory.purchase_inventory_invoice',compact('id'));
    }
    public function issueInventoryInvoice($id)
    {
        $id = $id;
        return view('admin.inventory.issue_inventory_invoice',compact('id'));
    }
    public function purchaseInventoryInvoiceSearch()
    {
        return view('admin.inventory.purchase_inventory_invoice_search');
    }
    public function purchaseInventoryReturn() {
        $id = 0;
        return view('admin.inventory.purchase_inventory_returns',compact('id'));
    }
    public function issueInventoryInvoiceSearch()
    {
        return view('admin.inventory.issue_inventory_invoice_search');
    }

    public function getPurchaseOrderInventoryCode()
    {
        return response()->json(generatePurchaseOrderInventoryCode());
    }


    public function getInstrumentStock(Request $request)
    {
        $stock = inventoryStock($request->productId);
       // dd($stock);
        return response()->json($stock);
    }

    public function purchaseInventoryStore(Request $request)
    {
        $purcahse = $request->purchase;
        $productCart = $request->cartProducts;
        $validator = Validator::make((array) $purcahse, [
            'invoice_number'  => 'required|string|unique:purchases',
            'supplier_id'     => 'required|integer',
            'order_date'      => 'required|date',
            'subtotal'        => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'vat_percent'     => 'required|numeric',
            'vat_amount'      => 'required|numeric',
            'transport_cost'  => 'required|numeric',
            'total'           => 'required|numeric',
            'paid'            => 'required|numeric',
            'due'             => 'required|numeric',
            'previous_due'    => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data                   = New Purchase();
            $data->invoice_number   = $purcahse['invoice_number'];
            $data->supplier_id      = $purcahse['supplier_id'];
            $data->order_date       = $purcahse['order_date'];
            $data->subtotal         = $purcahse['subtotal'];
            $data->discount_percent = $purcahse['discount_percent'];
            $data->discount_amount  = $purcahse['discount_amount'];
            $data->vat_percent      = $purcahse['vat_percent'];
            $data->vat_amount       = $purcahse['vat_amount'];
            $data->transport_cost   = $purcahse['transport_cost'];
            $data->total            = $purcahse['total'];
            $data->paid             = $purcahse['paid'];
            $data->due              = $purcahse['due'];
            $data->previous_due     = $purcahse['previous_due'];
            $data->remark           = $purcahse['note'];
            $data->use_for          = 'Instrument';
            $data->created_by       = auth()->user()->id;
            $data->ip_address       = $request->ip();
            $data->branch_id        = session('branch_id');
            $data->save(); 


            foreach ($productCart as $value) {
                PurchaseDetail::create(array(
                    'purchase_id'      => $data->id,
                    'item_id'          => $value['productId'],
                    'quantity'         => $value['quantity'],
                    'purchase_rate'    => $value['purchase_price'],
                    'total_amount'     => $value['total'],
                    'use_for'          => 'Instrument',
                    'created_by'       => auth()->user()->id,
                    'ip_address'       => $request->ip(),
                    'branch_id'        => session('branch_id')
                ));

                $inventoryCount = DB::table('instrument_stocks')->where('instrument_id', $value['productId'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount == 0){
                    InstrumentStock::create(array(
                        'instrument_id'     => $value['productId'],
                        'purchase_quantity' => $value['quantity'],
                        'stock_quantity'    => $value['quantity'],
                        'branch_id'         => session('branch_id')
                    ));
                }else{
                    DB::statement("
                    update instrument_stocks set 
                    purchase_quantity = purchase_quantity + ?, 
                    stock_quantity = stock_quantity + ? 
                    where instrument_id = ? 
                    and branch_id = ?
                ", [$value['quantity'], $value['quantity'], $value['productId'], session('branch_id')]);

                    DB::statement("
                    update instruments set 
                    purchase_price = ? 
                    where id = ?
                ", [$value['purchase_price'],$value['productId']]);
                }
            }


            DB::commit();
            return response()->json(['message' => 'Inventory Purhcase Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function purchaseInventoryUpdate(Request $request)
    {
        $purcahse    = $request->purchase;
        //dd($purcahse['id']);
        $productCart = $request->cartProducts;
        $validator   = Validator::make((array) $purcahse, [
            'id'              => 'required|integer',
            'invoice_number'  => ['required','string',Rule::unique('purchases')->ignore($purcahse['id'],'id')],
            'supplier_id'     => 'required|integer',
            'order_date'      => 'required|date',
            'subtotal'        => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'vat_percent'     => 'required|numeric',
            'vat_amount'      => 'required|numeric',
            'transport_cost'  => 'required|numeric',
            'total'           => 'required|numeric',
            'paid'            => 'required|numeric',
            'due'             => 'required|numeric',
            'previous_due'    => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data                   = Purchase::find($purcahse['id']);
            $data->invoice_number   = $purcahse['invoice_number'];
            $data->supplier_id      = $purcahse['supplier_id'];
            $data->order_date       = $purcahse['order_date'];
            $data->subtotal         = $purcahse['subtotal'];
            $data->discount_amount  = $purcahse['discount_amount'];
            $data->discount_percent = $purcahse['discount_percent'];
            $data->vat_percent      = $purcahse['vat_percent'];
            $data->vat_amount       = $purcahse['vat_amount'];
            $data->transport_cost   = $purcahse['transport_cost'];
            $data->total            = $purcahse['total'];
            $data->paid             = $purcahse['paid'];
            $data->due              = $purcahse['due'];
            $data->previous_due     = $purcahse['previous_due'];
            $data->remark           = $purcahse['note'];
            $data->use_for          = 'Instrument';
            $data->updated_by       = auth()->user()->id;
            $data->ip_address       = $request->ip();
            $data->branch_id        = session('branch_id');
            $data->save(); 

            $oldPurchaseDetails = PurchaseDetail::where('purchase_id',$purcahse['id'])->get();

            $deletePurchaseDetails=PurchaseDetail::where('purchase_id',$purcahse['id']);
            $deletePurchaseDetails->forceDelete();

            
            foreach ($oldPurchaseDetails as $value) {
                DB::statement("
                update instrument_stocks set 
                purchase_quantity = purchase_quantity - ?, 
                stock_quantity = stock_quantity - ? 
                where instrument_id = ? 
                and branch_id = ?
            ", [$value->quantity, $value->quantity, $value->item_id, session('branch_id')]);

                DB::statement("
                update instruments set 
                purchase_price = ? 
                where id = ?
            ", [$value->purchase_rate,$value->item_id]);

            }
            
            foreach ($productCart as $value) {
                PurchaseDetail::create(array(
                    'purchase_id'      => $purcahse['id'],
                    'item_id'          => $value['productId'],
                    'quantity'         => $value['quantity'],
                    'purchase_rate'    => $value['purchase_price'],
                    'total_amount'     => $value['total'],
                    'use_for'          => 'Instrument',
                    'created_by'       => auth()->user()->id,
                    'ip_address'       => $request->ip(),
                    'branch_id'        => session('branch_id')
                ));

                $inventoryCount = DB::table('instrument_stocks')->where('instrument_id', $value['productId'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount == 0){
                    InstrumentStock::create(array(
                        'instrument_id'     => $value['productId'],
                        'purchase_quantity' => $value['quantity'],
                        'stock_quantity'    => $value['quantity'],
                        'branch_id'         => session('branch_id')
                    ));
                }else{
                    DB::statement("
                    update instrument_stocks set 
                    purchase_quantity = purchase_quantity + ?, 
                    stock_quantity = stock_quantity + ? 
                    where instrument_id = ? 
                    and branch_id = ?
                ", [$value['quantity'], $value['quantity'], $value['productId'], session('branch_id')]);

                    DB::statement("
                    update instruments set 
                    purchase_price = ? 
                    where id = ?
                ", [$value['purchase_price'],$value['productId']]);
                }
            }


            DB::commit();
            return response()->json(['message' => 'Inventory Purchase Updated','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    

    public function getPurchaseOrderInventory(Request $request)
    {
        $clauses = "";
        if($request->purchaseId && $request->purchaseId != ''){
            $clauses .= " and p.id = '$request->purchaseId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and p.order_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->supplier_id && $request->supplier_id != ''){
            $clauses .= " and p.supplier_id = '$request->supplier_id'";
        }
        if($request->userId && $request->userId != ''){
            $clauses .= " and p.created_by = '$request->userId'";
        }
        
        //dd($request->purchaseId);
        $result = DB::select(
            "SELECT p.*,
            concat_ws(' - ', p.invoice_number, s.name) as invoice_text,
            concat_ws(' - ', s.supplier_code , s.name) as display_name,
            s.supplier_code as supplier_code,
            s.name as supplier_name,
            s.mobile as supplier_mobile,
            s.address as supplier_address,
            u.name as user_name,
            s.id as supplierId

            from purchases p
            left join suppliers s on s.id = p.supplier_id
            left join users u on u.id = p.created_by
            where p.deleted_at is null
            and p.branch_id = ?
            and p.use_for = 'Instrument'
            $clauses
        ", [session('branch_id')]);

        //dd($result);
        
        if($request->with_details){
            foreach($result as $value){
                $value->purchaseDetails = DB::select(
                    "SELECT pd.*,
                    ins.instrument_code  as code,
                    ins.name as product_name,
                    u.name as unit_name,
                    concat(ins.name, ' - ', ins.instrument_code) as display_text
                    from purchase_details pd
                    left join instruments ins on ins.id = pd.item_id
                    left join units u on u.id = ins.unit_id
                    where pd.purchase_id = '$value->id'
                    and pd.use_for = 'Instrument'
                ");
            }
        }
        return response()->json($result);
    }

    public function getDamageInventory(Request $request){

        $clauses = "";
        if($request->damageId && $request->damageId != ''){
            $clauses .= " and d.item_id = '$request->damageId'";
        }
        $result = DB::select(
            "SELECT
                d.*,
                ins.name as product_name,
                ins.instrument_code as code,
                concat(ins.name, ' - ', ins.instrument_code) as display_text
            from damages d
            left join instruments ins on ins.id = d.item_id
            where d.deleted_at is null
            and d.use_for = 'Instrument'
            $clauses
        ");
        return response()->json($result);
    }
    
    public function damageInventorytStore(Request $request)
    {
        $damage = json_decode($request->damages);
        $validator = Validator::make((array) $damage, [
            'damage_code'   => 'required|string|unique:damages',
            'item_id'       => 'required|integer',
            'damage_date'   => 'required|date',
            'quantity'      => 'required|numeric',
            'purchase_rate' => 'required|numeric',
            'total_amount'  => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data                = New Damage();
            $data->damage_code   = $damage->damage_code;
            $data->item_id       = $damage->item_id;
            $data->damage_date   = $damage->damage_date;
            $data->quantity      = $damage->quantity;
            $data->purchase_rate = $damage->purchase_rate;
            $data->total_amount  = $damage->total_amount;
            $data->remark        = $damage->remark;
            $data->use_for       = 'Instrument';
            $data->created_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 

            $inventoryCount = DB::table('instrument_stocks')->where('instrument_id', $damage->item_id)->where('branch_id', session('branch_id'))->count();
            // dd($inventoryCount);
            if( $inventoryCount == 0) {
                InstrumentStock::create(array(
                    'instrument_id'   => $damage->item_id,
                    'damage_quantity' => $damage->quantity,
                    'stock_quantity'  => $damage->stock_quantity,
                    'branch_id'       => session('branch_id')
                ));
            }else{
                DB::statement("
                    update instrument_stocks set 
                    damage_quantity = damage_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where instrument_id = ? 
                    and branch_id = ?
                ", [$damage->quantity, $damage->quantity, $damage->item_id, session('branch_id')]);
            }
            
            DB::commit();
            return response()->json(['message' => 'Inventory Damage Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }



    
    public function damageInventorytUpdate(Request $request)
    {
        $damage = json_decode($request->damages);
        $validator = Validator::make((array) $damage, [
            'id'            => 'required|integer',
            'damage_code'   => ['required','string',Rule::unique('damages')->ignore($damage->id,'id')],
            'item_id'       => 'required|integer',
            'damage_date'   => 'required|date',
            'quantity'      => 'required|numeric',
            'purchase_rate' => 'required|numeric',
            'total_amount'  => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {

            $oldDamage= Damage::where('item_id',$damage->item_id)->first();

            DB::statement("
                    update instrument_stocks set 
                    damage_quantity = damage_quantity - ?, 
                    stock_quantity = stock_quantity + ? 
                    where instrument_id = ? 
                    and branch_id = ?
            ", [$oldDamage->quantity, $oldDamage->quantity, $oldDamage->item_id, session('branch_id')]);
            

            $data                = Damage::find($damage->id);
            $data->damage_code   = $damage->damage_code;
            $data->item_id       = $damage->item_id;
            $data->damage_date   = $damage->damage_date;
            $data->quantity      = $damage->quantity;
            $data->purchase_rate = $damage->purchase_rate;
            $data->total_amount  = $damage->total_amount;
            $data->remark        = $damage->remark;
            $data->use_for       = 'Instrument';
            $data->updated_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 

          
            DB::statement("
                    update instrument_stocks set 
                    damage_quantity = damage_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where instrument_id = ? 
                    and branch_id = ?
            ", [$damage->quantity, $damage->quantity, $damage->item_id, session('branch_id')]);
            
            DB::commit();
            return response()->json(['message' => 'Inventory Damage Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }


    public function getPurchaseInventoryDetails(Request $request){
        
        $clauses = "";
        if($request->supplierId && $request->supplierId != ''){
            $clauses .= " and s.id = '$request->supplierId'";
        }

        if($request->productId && $request->productId != ''){
            $clauses .= " and ins.id = '$request->productId'";
        }

        if($request->categoryId && $request->categoryId != ''){
            $clauses .= " and pc.id = '$request->categoryId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and p.order_date between '$request->dateFrom' and '$request->dateTo'";
        }
        if($request->purchaseId && $request->purchaseId != '') {
            $clauses .= " and pd.purchase_id = '$request->purchaseId'";
        }

        $result = DB::select(
            "SELECT pd.*,
                pd.purchase_rate as return_rate,
                concat(ins.name, ' - ', ins.instrument_code) as display_text,
                ins.name as product_name,
                pc.name as category_name,
                p.invoice_number,
                p.order_date,
                concat_ws(' - ', s.supplier_code , s.name) as display_name,
                s.supplier_code as supplier_code,
                s.name as supplier_name,
                s.mobile as supplier_mobile,
                s.address as supplier_address,
                (
                    SELECT ifnull(sum(prd.quantity), 0) 
                    from purchase_return_details prd
                    join purchase_returns pr on pr.id = prd.purchase_return_id
                    where pr.purchase_id = p.id
                    and prd.item_id = pd.item_id
                ) as returned_quantity,
                (
                    SELECT ifnull(sum(prd.total_amount), 0) 
                    from purchase_return_details prd
                    join purchase_returns pr on pr.id = prd.purchase_return_id
                    where pr.purchase_id = p.id
                    and prd.item_id = pd.item_id
                ) as returned_amount
            from purchase_details pd
            left join instruments ins on ins.id = pd.item_id
            left join categories pc on pc.id = ins.category_id
            left join purchases p on p.id = pd.purchase_id
            left join suppliers s on s.id = p.supplier_id
            where p.deleted_at is null
            and pd.use_for = 'Instrument'
            and pd.branch_id = ?
            $clauses
        ",[session('branch_id')]);

        return response()->json($result);
    }

    // purchase return inventory started

    public function getPurchaseReturnInventory(Request $request)
    {
        $clauses = "";
        if($request->purchaseReturnId && $request->purchaseReturnId != ''){
            $clauses .= " and pr.id = '$request->purchaseReturnId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and pr.return_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->supplier_id && $request->supplier_id != ''){
            $clauses .= " and pr.supplier_id = '$request->supplier_id'";
        }
       
        
        //dd($request->purchaseId);
        $result = DB::select(
            "SELECT pr.*,
            concat_ws(' - ', p.invoice_number, s.name) as invoice_text,
            concat_ws(' - ', s.supplier_code , s.name) as display_name,
            s.supplier_code as supplier_code,
            s.name as supplier_name,
            s.mobile as supplier_mobile,
            s.address as supplier_address,
            u.name as user_name,
            p.invoice_number as invoice_number

            from purchase_returns pr
            left join purchases p on p.id = pr.purchase_id
            left join suppliers s on s.id = pr.supplier_id
            left join users u on u.id = p.created_by
            where pr.deleted_at is null
            and pr.branch_id = ?
            and pr.use_for = 'Instrument'
            $clauses
        ", [session('branch_id')]);

        //dd($result);
        
        if($request->with_details){
            foreach($result as $value){
                $value->purchaseReturnDetails = DB::select(
                    "SELECT prd.*,
                    i.instrument_code as code,
                    i.name as product_name,
                    u.name as unit_name,
                    concat(i.name, ' - ', i.instrument_code) as display_text
                    from purchase_return_details prd
                    left join instruments i on i.id = prd.item_id
                    left join units u on u.id = i.unit_id
                    where prd.purchase_return_id = '$value->id'
                    and prd.use_for = 'Instrument'
                ");
            }
        }

        return response()->json($result);
    }

    // purchase return started here
    public function  getPurchaseReturnInventoryDetails(Request $request){
        
        $result = DB::select("
            SELECT 
                pd.*,
                pd.purchase_rate as return_rate,
                i.name as product_name,
                pc.name as category_name,
                (
                    SELECT ifnull(sum(prd.quantity), 0) 
                    from purchase_return_details prd
                    join purchase_returns pr on pr.id = prd.purchase_return_id
                    where pr.purchase_id = p.id
                    and prd.item_id = pd.item_id
                ) as returned_quantity,
                (
                    SELECT ifnull(sum(prd.total_amount), 0) 
                    from purchase_return_details prd
                    join purchase_returns pr on pr.id = prd.purchase_return_id
                    where pr.purchase_id = p.id
                    and prd.item_id = pd.item_id
                ) as returned_amount
            from purchase_details pd
            left join purchases p on p.id = pd.purchase_id
            left join instruments i on i.id = pd.item_id
            left join categories pc on pc.id = i.category_id
            where p.id = $request->purchaseId
            and pd.use_for = 'Instrument'
            and p.branch_id = ?

        ",[session('branch_id')]);

        return response()->json($result);
    }

    public function purchaseReturnInventoryStore(Request $request)
    {
        $purchaseReturn = $request->purchaseReturn;
        $productCart = $request->cart;
        $validator = Validator::make((array) $purchaseReturn, [
            'purchase_id'  => 'required|integer',
            'supplier_id'  => 'required|integer',
            'return_date'  => 'required|date',
            'total_amount' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data               = New PurchaseReturn();
            $data->purchase_id  = $purchaseReturn['purchase_id'];
            $data->supplier_id  = $purchaseReturn['supplier_id'];
            $data->return_date  = $purchaseReturn['return_date'];
            $data->total_amount = $purchaseReturn['total_amount'];
            $data->remark       = $purchaseReturn['note'];
            $data->use_for      = 'Instrument';
            $data->created_by   = auth()->user()->id;
            $data->ip_address   = $request->ip();
            $data->branch_id    = session('branch_id');
            $data->save(); 

            foreach ($productCart as $value) {
                PurchaseReturnDetail::create(array(
                    'purchase_return_id' => $data->id,
                    'item_id'            => $value['item_id'],
                    'quantity'           => $value['return_quantity'],
                    'return_rate'        => $value['return_rate'],
                    'converter_name'     => $value['converter_name'],
                    'convert_quantity'   => $value['convert_quantity'],
                    'total_amount'       => $value['return_amount'],
                    'use_for'            => 'Instrument',
                    'created_by'         => auth()->user()->id,
                    'ip_address'         => $request->ip(),
                    'branch_id'          => session('branch_id')
                ));

                $inventoryCount = DB::table('instrument_stocks')->where('instrument_id', $value['item_id'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount != 0){
                    DB::statement("
                    update instrument_stocks set 
                    purchase_return_quantity = 	purchase_return_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where instrument_id = ? 
                    and branch_id = ?
                ", [$value['return_quantity'], $value['return_quantity'], $value['item_id'], session('branch_id')]);

                }
            }

            DB::commit();
            return response()->json(['message' => 'Instrument purchase return insertion','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function purchaseReturnInventoryUpdate(Request $request)
    {
        $purchaseReturn = $request->purchaseReturn;
        $productCart = $request->cart;
        $validator = Validator::make((array) $purchaseReturn, [
            'purchase_id'  => 'required|integer',
            'supplier_id'  => 'required|integer',
            'return_date'  => 'required|date',
            'total_amount' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data               = PurchaseReturn::find($purchaseReturn['id']);
            $data->purchase_id  = $purchaseReturn['purchase_id'];
            $data->supplier_id  = $purchaseReturn['supplier_id'];
            $data->return_date  = $purchaseReturn['return_date'];
            $data->total_amount = $purchaseReturn['total_amount'];
            $data->remark       = $purchaseReturn['note'];
            $data->use_for      = 'Instrument';
            $data->updated_by   = auth()->user()->id;
            $data->ip_address   = $request->ip();
            $data->branch_id    = session('branch_id');
            $data->save();  

            $oldPurchaseReturnDetails = PurchaseReturnDetail::where('purchase_return_id',$purchaseReturn['id'])->get();

            $deletePurchaseReturnDetails=PurchaseReturnDetail::where('purchase_return_id',$purchaseReturn['id']);
            $deletePurchaseReturnDetails->forceDelete();

            
            foreach ($oldPurchaseReturnDetails as $value) {
                
                    DB::statement("
                    update instrument_stocks set 
                    purchase_return_quantity = purchase_return_quantity - ?, 
                    stock_quantity = stock_quantity + ? 
                    where instrument_id = ? 
                    and branch_id = ?
                    ", [$value->quantity, $value->quantity, $value->item_id, session('branch_id')]);
                
                    
            }
            
            foreach ($productCart as $value) {
                PurchaseReturnDetail::create(array(
                    'purchase_return_id' => $data->id,
                    'item_id'            => $value['item_id'],
                    'quantity'           => $value['return_quantity'],
                    'return_rate'        => $value['return_rate'],
                    'converter_name'     => $value['converter_name'],
                    'convert_quantity'   => $value['convert_quantity'],
                    'total_amount'       => $value['return_amount'],
                    'use_for'            => 'Instrument',
                    'created_by'         => auth()->user()->id,
                    'ip_address'         => $request->ip(),
                    'branch_id'          => session('branch_id')
                ));

                $inventoryCount = DB::table('instrument_stocks')->where('instrument_id', $value['item_id'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount != 0){
                    DB::statement("
                    update instrument_stocks set 
                    purchase_return_quantity = 	purchase_return_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where instrument_id = ? 
                    and branch_id = ?
                ", [$value['return_quantity'], $value['return_quantity'], $value['item_id'], session('branch_id')]);

                }
            }


            DB::commit();
            return response()->json(['message' => 'Instrument Purchase Return Updated','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function purchaseReturnInventoryDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {

            $purchaseReturnDetails = PurchaseReturnDetail::where('purchase_return_id', $request->id)->get();
           
            foreach($purchaseReturnDetails as $product){
                DB::statement("
                    update instrument_stocks set 
                    purchase_return_quantity = purchase_return_quantity - ?, 
                    stock_quantity = stock_quantity + ? 
                    where instrument_id = ? 
                    and branch_id = ?
                ", [$product->quantity, $product->quantity, $product->item_id, session('branch_id')]);
            }

            PurchaseReturn::where('id', $request->id)->delete();
            PurchaseReturnDetail::where('purchase_return_id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Inventory Purchase Return Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function purchaseInventoryReturnInvoice($id)
    {
        $id = $id;
        return view('admin.inventory.purchase_return_inventory_invoice',compact('id'));
    }

    public function purchaseReturnInventoryRecord()
    {
        return view('admin.inventory.purchase_return_inventory_list');
    }

    public function checkPurchaseInventroyReturn($id)
    {
        $result = ['found'=>false];

        $returnCount = 0; // purchase return queary available.....
        
        if($returnCount != 0) {
            $result = ['found'=>true];
        }
        return response()->json($result);
    }
    public function checkIssueInventroyReturn($id)
    {
        $result = ['found'=>false];

        $returnCount = 0; // purchase return queary available.....
        
        if($returnCount != 0) {
            $result = ['found'=>true];
        }
        return response()->json($result);
    }

    public function purchaseInventorytDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {

            $purchase = Purchase::where('id', $request->id)->first();
            if($purchase->deleted_at != null){
                return response()->json(['message' => 'Purchase not found']);
                exit;
            }

            $purchaseCount = 0;// purchase return queary available.....

            if($purchaseCount != 0) {
                return response()->json(['message' => 'Unable to delete. Purchase return found']);
                exit;
            }

            $purchaseDetails = PurchaseDetail::where('purchase_id', $request->id)->get();
            foreach($purchaseDetails as $detail) {
                $stock = inventoryStock($detail->item_id);
                if($detail->quantity > $stock) {
                    return response()->json(['success'=>false,'message' => 'Product out of stock, Purchase can not be deleted']);
                    exit;
                }
            }

            foreach($purchaseDetails as $product){
                DB::statement("
                    update instrument_stocks set 
                    purchase_quantity = purchase_quantity - ?, 
                    stock_quantity = stock_quantity - ? 
                    where instrument_id = ? 
                    and branch_id = ?
                ", [$product->quantity, $product->quantity, $product->item_id, session('branch_id')]);
            }

            Purchase::where('id', $request->id)->delete();
            PurchaseDetail::where('purchase_id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Inventory Purchase Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function issueInventorytDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {

            $issue = Issue::where('id', $request->id)->first();
            if($issue->deleted_at != null){
                return response()->json(['message' => 'Issue not found']);
                exit;
            }

            $issueCount = 0;// purchase return queary available.....

            if($issueCount != 0) {
                return response()->json(['message' => 'Unable to delete. Issue return found']);
                exit;
            }

            $issueDetails = IssueDetail::where('issue_id', $request->id)->get();
         
            foreach($issueDetails as $product){
                DB::statement("
                    update instrument_stocks set 
                    issue_quantity = issue_quantity - ?, 
                    stock_quantity = stock_quantity + ? 
                    where instrument_id = ? 
                    and branch_id = ?
                ", [$product->quantity, $product->quantity, $product->instrument_id, session('branch_id')]);
            }

            Issue::where('id', $request->id)->delete();
            IssueDetail::where('issue_id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Inventory Issue Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }


    public function dagameInventorytDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {

            $oldDamage= Damage::where('id',$request->id)->first();

            DB::statement("
                    update instrument_stocks set 
                    damage_quantity = damage_quantity - ?, 
                    stock_quantity = stock_quantity + ? 
                    where instrument_id = ? 
                    and branch_id = ?
            ", [$oldDamage->quantity, $oldDamage->quantity, $oldDamage->item_id, session('branch_id')]);

            Damage::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Inventory Purchase Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    ////// Issue
    public function issueInventoryEntry()
    {
        $id = 0;
        $invoice = generateIssueInventoryCode();
        return view('admin.inventory.issue_inventory_entry',compact('id','invoice'));
    }

    public function issueInventoryStore(Request $request)
    {
        $issue = $request->issues;
        $productCart = $request->cartProducts;
        $validator = Validator::make((array) $issue, [
            'invoice_number'  => 'required|string|unique:issues',
            'employee_id'     => 'required|integer',
            'issue_date'      => 'required|date'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data                   = New Issue();
            $data->invoice_number   = $issue['invoice_number'];
            $data->employee_id      = $issue['employee_id'];
            $data->issue_date       = $issue['issue_date'];
            $data->remark           = $issue['note'];
            $data->created_by       = auth()->user()->id;
            $data->ip_address       = $request->ip();
            $data->branch_id        = session('branch_id');
            $data->save(); 


            foreach ($productCart as $value) {
                IssueDetail::create(array(
                    'issue_id'      => $data->id,
                    'instrument_id' => $value['productId'],
                    'quantity'      => $value['quantity'],
                    'purchase_rate' => $value['purchase_price'],
                    'created_by'    => auth()->user()->id,
                    'ip_address'    => $request->ip(),
                    'branch_id'     => session('branch_id')
                ));

                $inventoryCount = DB::table('instrument_stocks')->where('instrument_id', $value['productId'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount != 0){
                   
                    DB::statement("
                    update instrument_stocks set 
                    issue_quantity = issue_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where instrument_id = ? 
                    and branch_id = ?
                ", [$value['quantity'], $value['quantity'], $value['productId'], session('branch_id')]);         
                }
            }


            DB::commit();
            return response()->json(['message' => 'Inventory Issue Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function issueInventorytUpdate(Request $request)
    {
       
        $issue = $request->issues;
        $productCart = $request->cartProducts;
        $validator = Validator::make((array) $issue, [
            'id'             => 'required|integer',
            'invoice_number' => ['required','string',Rule::unique('issues')->ignore($issue['id'],'id')],
            'employee_id'    => 'required|integer',
            'issue_date'     => 'required|date'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data                   = Issue::find($issue['id']);
            $data->invoice_number   = $issue['invoice_number'];
            $data->employee_id      = $issue['employee_id'];
            $data->issue_date       = $issue['issue_date'];
            $data->remark           = $issue['note'];
            $data->updated_by       = auth()->user()->id;
            $data->ip_address       = $request->ip();
            $data->branch_id        = session('branch_id');
            $data->save(); 

            $oldIssueDetails = IssueDetail::where('issue_id',$issue['id'])->get();

            foreach ($oldIssueDetails as $value) {
                DB::statement("
                update instrument_stocks set 
                issue_quantity = issue_quantity - ?, 
                stock_quantity = stock_quantity + ? 
                where instrument_id = ? 
                and branch_id = ?
                ", [$value->quantity, $value->quantity, $value->instrument_id, session('branch_id')]);
            }
            
            $deleteIssueDetails=IssueDetail::where('issue_id',$issue['id']);
            $deleteIssueDetails->forceDelete();

            
            foreach ($productCart as $value) {
                IssueDetail::create(array(
                    'issue_id'      => $data->id,
                    'instrument_id' => $value['productId'],
                    'quantity'      => $value['quantity'],
                    'purchase_rate' => $value['purchase_price'],
                    'created_by'    => auth()->user()->id,
                    'ip_address'    => $request->ip(),
                    'branch_id'     => session('branch_id')
                ));

                $inventoryCount = DB::table('instrument_stocks')->where('instrument_id', $value['productId'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount != 0){
                   
                    DB::statement("
                    update instrument_stocks set 
                    issue_quantity = issue_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where instrument_id = ? 
                    and branch_id = ?
                ", [$value['quantity'], $value['quantity'], $value['productId'], session('branch_id')]);         
                }
            }


            DB::commit();
            return response()->json(['message' => 'Inventory Issue Updated','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }


    public function getIssueInventory(Request $request)
    {
        $clauses = "";
        if($request->issueId && $request->issueId != ''){
            $clauses .= " and i.id = '$request->issueId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and i.issue_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->employee_id && $request->employee_id != ''){
            $clauses .= " and i.employee_id = '$request->employee_id'";
        }
        if($request->userId && $request->userId != ''){
            $clauses .= " and i.created_by = '$request->userId'";
        }
        
        //dd($request->purchaseId);
        $result = DB::select(
            "SELECT i.*,
            concat_ws(' - ', i.invoice_number, em.name) as invoice_text,
            concat_ws(' - ', em.employee_code , em.name) as display_name,
            em.employee_code as employee_code,
            em.name as employee_name,
            em.mobile_number as employee_mobile,
            em.present_address as employee_address,
            u.name as user_name

            from issues i
            left join employees em on em.id = i.employee_id
            left join users u on u.id = i.created_by
            where i.deleted_at is null
            and i.branch_id = ?
            $clauses
        ", [session('branch_id')]);

        //dd($result);
        
        if($request->with_details){
            foreach($result as $value){
                $value->issueDetails = DB::select(
                    "SELECT isd.*,
                    ins.instrument_code  as code,
                    ins.name as product_name,
                    u.name as unit_name,
                    concat(ins.name, ' - ', ins.instrument_code) as display_text
                    from issue_details isd
                    left join instruments ins on ins.id = isd.instrument_id 
                    left join units u on u.id = ins.unit_id
                    where isd.issue_id = '$value->id'
                ");
            }
        }

        return response()->json($result);
    }

    public function  getIssueInventoryDetails(Request $request){
        
        $clauses = "";
        if($request->employeeId && $request->employeeId != ''){
            $clauses .= " and em.id = '$request->employeeId'";
        }

        if($request->productId && $request->productId != ''){
            $clauses .= " and ins.id = '$request->productId'";
        }

        if($request->categoryId && $request->categoryId != ''){
            $clauses .= " and pc.id = '$request->categoryId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and i.issue_date between '$request->dateFrom' and '$request->dateTo'";
        }

        $result = DB::select(
            "SELECT isd.*,
                concat(ins.name, ' - ', ins.instrument_code) as display_text,
                pc.name as category_name,
                u.name as unit_name,
                i.invoice_number,
                i.issue_date,
                concat_ws(' - ', em.employee_code , em.name) as display_name,
                em.employee_code as employee_code,
                em.name as employee_name,
                em.mobile_number as employee_mobile,
                em.present_address as employee_address
            from issue_details isd
            left join instruments ins on ins.id = isd.instrument_id
            left join categories pc on pc.id = ins.category_id
            left join issues i on i.id = isd.issue_id
            left join units u on u.id = ins.unit_id
            left join employees em on em.id = i.employee_id
            where i.deleted_at is null
            and isd.branch_id = ?
            $clauses
        ",[session('branch_id')]);

        return response()->json($result);
    }
    public function  getCurrentStockInventory(Request $request){
        
        $clauses = "";
        if(isset($request->stockType) && $request->stockType == 'low'){
            $clauses .= " and current_quantity <= reorder_level";
        }

       //dd($clauses);
        $stock = currentStock($clauses);
        $result['stock'] = $stock;
        $result['totalValue'] = array_sum(
            array_map(function($product){
                return $product->stock_value;
            }, $stock));
        return response()->json($result);
    }
    public function  getTotalStockInventory(Request $request){
        
     
        $branchId = session('branch_id');
        $clauses = "";
        if($request->categoryId && $request->categoryId != null){
            $clauses .= " and p.category_id  = '$request->categoryId'";
        }

        if($request->productId && $request->productId != null){
            $clauses .= " and p.id = '$request->productId'";
        }


        $stock =  DB::SELECT("
            SELECT
                p.*,
                pc.name as category_name,
                u.name as unit_name,
                (SELECT ifnull(sum(pd.quantity), 0) 
                    from purchase_details pd 
                    left join purchases pr on pr.id = pd.purchase_id
                    where pd.item_id = p.id
                    and pd.branch_id = '$branchId'
                    and pd.use_for = 'Instrument'
                    and pd.deleted_at is null
                    " . (isset($request->date) && $request->date != null ? " and pr.order_date <= '$request->date'" : "") . "
                ) as purchased_quantity,

                (SELECT ifnull(sum(prd.quantity), 0) 
                    from purchase_return_details prd 
                    left join purchase_returns pr on pr.id = prd.purchase_return_id 
                    where prd.item_id = p.id
                    and prd.branch_id = '$branchId'
                    and prd.use_for = 'Instrument'
                    and prd.deleted_at is null
                    " . (isset($request->date) && $request->date != null ? " and pr.return_date <= '$request->date'" : "") . "
                ) as purchased_return_quantity,
                        
                
                (SELECT ifnull(sum(isud.quantity), 0) 
                    from issue_details isud
                    left join issues isu on isu.id = isud.issue_id
                    where isud.instrument_id = p.id
                    and isud.branch_id  = '$branchId'
                    and isud.deleted_at is null
                    " . (isset($request->date) && $request->date != null ? " and isu.issue_date <= '$request->date'" : "") . "
                ) as sold_quantity,
                        

                (SELECT ifnull(sum(dm.quantity), 0) 
                    from damages dm
                    where dm.item_id  = p.id
                    and dm.deleted_at is null
                    and dm.use_for = 'Instrument'
                    and dm.branch_id = '$branchId'
                    " . (isset($request->date) && $request->date != null ? " and dm.damage_date <= '$request->date'" : "") . "
                ) as damaged_quantity,
            
                        
                (SELECT (purchased_quantity) - (sold_quantity +  damaged_quantity + purchased_return_quantity)) as current_quantity,
                (SELECT p.purchase_price * current_quantity) as stock_value
            from instruments p
            left join categories pc on pc.id = p.category_id
            left join units u on u.id = p.unit_id
            where p.deleted_at is null
            $clauses
        ");
      //  dd($stock);
        $result['stock'] = $stock;
        $result['totalValue'] = array_sum(
            array_map(function($product){
                return $product->stock_value;
            }, $stock));


        return response()->json($result);
    }

    public function purchaseReturnInventoryEdit($id)
    {
        $id = $id;
        $pursReturn = PurchaseReturn::findOrFail($id);
        $invoice = $pursReturn->invoice_number;
        return view('admin.inventory.purchase_inventory_returns',compact('id','invoice'));
    }

    //////suppler Payment
    public function supplierPaymentInventory()
    {
        return view('admin.inventory.inventory_supplier_payment_entry');
    }

    public function getSupplierPaymentInventoryCode()
    {
        return response()->json(generateSupplierPaymentInventoryCode());
    }

    public function getSupplierPaymentInventory(Request $request)
    {
        $getSupplierPaymentTransaction = DB::table('supplier_payments as sp')
        ->selectRaw("sp.*, concat( ba.account_name, ' - ', ba.account_number,' (', ba.bank_name,')') as display_text, concat( s.supplier_code, ' - ', s.name) as supplier_text")
        ->leftJoin('bank_accounts as ba', 'ba.id', '=', 'sp.account_id' )
        ->leftJoin('suppliers as s', 's.id', '=', 'sp.supplier_id' )
        ->whereNull('sp.deleted_at')
        ->where('sp.use_for','Instrument');

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $getSupplierPaymentTransaction->whereBetween('sp.payment_date', [$request->dateFrom, $request->dateTo]);
        }

        if($request->date && $request->date != ''){
            $getSupplierPaymentTransaction->where('sp.payment_date', $request->date);
        }

        if($request->transactionType == 'Received'){
            $getSupplierPaymentTransaction->where('sp.transaction_type', '=' , 'Received');
        }

        if($request->transactionType == 'Payment'){
            $getSupplierPaymentTransaction->where('sp.transaction_type', '=' , 'Payment');
        }
        
        if($request->accountId && $request->accountId != ''){
            $getSupplierPaymentTransaction->where('sp.account_id', $request->accountId);
        }
        $getSupplierPaymentTransaction= $getSupplierPaymentTransaction->orderBy('sp.id', 'desc')->lazy();

        return response()->json($getSupplierPaymentTransaction);
    }

    public function supplierPaymentInventoryStore(Request $request)
    {
        $supplierpayment = $request->supplierpayment;
        $validator = Validator::make((array) $supplierpayment, [
            'transaction_number' => 'required|string|unique:supplier_payments',
            'supplier_id'        => 'required|integer',
            'payment_date'       => 'required|date',
            'transaction_type'   => ['required', Rule::in(['Payment', 'Received'])],
            'payment_type'       => ['required', Rule::in(['Cash', 'Bank'])],
            'amount'             => 'required|numeric',
            'previous_due'       => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data                     = New SupplierPayment();
            $data->transaction_number = $supplierpayment['transaction_number'];
            $data->supplier_id        = $supplierpayment['supplier_id'];
            $data->account_id         = $supplierpayment['account_id'];
            $data->payment_date       = $supplierpayment['payment_date'];
            $data->transaction_type   = $supplierpayment['transaction_type'];
            $data->payment_type       = $supplierpayment['payment_type'];
            $data->amount             = $supplierpayment['amount'];
            $data->previous_due       = $supplierpayment['previous_due'];
            $data->remark             = $supplierpayment['remark'];
            $data->use_for            = 'Instrument';
            $data->created_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 
 

            DB::commit();
            return response()->json(['message' => 'Inventory Supplier Payment Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function supplierPaymentInventoryUpdate(Request $request)
    {

        $supplierpayment = $request->supplierpayment;
        $validator = Validator::make((array) $supplierpayment, [
            'id'                 => ['required', 'integer'],
            'transaction_number' => ['required','string',Rule::unique('supplier_payments')->ignore($supplierpayment['id'],'id')],
            'supplier_id'        => 'required|integer',
            'payment_date'       => 'required|date',
            'transaction_type'   => ['required', Rule::in(['Payment', 'Received'])],
            'payment_type'       => ['required', Rule::in(['Cash', 'Bank'])],
            'previous_due'       => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data                     = SupplierPayment::find($supplierpayment['id']);
            $data->transaction_number = $supplierpayment['transaction_number'];
            $data->supplier_id        = $supplierpayment['supplier_id'];
            $data->account_id         = $supplierpayment['account_id'];
            $data->payment_date       = $supplierpayment['payment_date'];
            $data->transaction_type   = $supplierpayment['transaction_type'];
            $data->payment_type       = $supplierpayment['payment_type'];
            $data->amount             = $supplierpayment['amount'];
            $data->previous_due       = $supplierpayment['previous_due'];
            $data->remark             = $supplierpayment['remark'];
            $data->use_for            = 'Instrument';
            $data->updated_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 
            


            DB::commit();
            return response()->json(['message' => 'Inventory Supplier Payment Updated','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function supplierPaymentDeleteInventory(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            SupplierPayment::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Inventory Supplier Payment Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    //////supplier due list
    public function supplierDueList()
    {
        return view('admin.inventory.supplier_due_report');
    }

    public function getSupplierDue(Request $request)
    {
        $clauses = "";
        if($request->supplierId && $request->supplierId != null){
            $clauses .= " and s.id = '$request->supplierId'";
        }
        if($request->usefor == 'Instrument'){
            $clauses .= " and s.use_for = 'Instrument'";
        }

        $getDues = getSupplierDue($clauses);

        $res['getDues'] =  $getDues;

        return response()->json($res);
    }



}
