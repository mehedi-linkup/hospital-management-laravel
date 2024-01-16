<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Damage;
use App\Models\Generic;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\MedicineStock;
use App\Models\PurchaseDetail;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetail;
use App\Models\SupplierPayment;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PharmacyController extends Controller
{

    public function brandEntry()
    {
        return view('admin.pharmacy.brand_entry');
    }

    public function brandStore(Request $request)
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

            Brand::create($data);

            DB::commit();
            return response()->json(['message' => 'Brand Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function brandUpdate(Request $request)
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

            Brand::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Brand Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function brandDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Brand::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Brand Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getBrands(Request $request)
    {
        $brands = DB::table('brands as a')
        ->whereNull('a.deleted_at');

        $brands->select("a.*");

        $brands =  $brands->orderBy('a.id', 'desc')->lazy();

        return response()->json($brands);
    }
    ////Generic Controller

    public function genericEntry()
    {
        return view('admin.pharmacy.generic_entry');
    }

    public function genericStore(Request $request)
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

            Generic::create($data);

            DB::commit();
            return response()->json(['message' => 'Generic Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function genericUpdate(Request $request)
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

            Generic::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Generic Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function genericDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Generic::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Generic Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getGenerics(Request $request)
    {
        $generics = DB::table('generics as a')
        ->whereNull('a.deleted_at');

        $generics->select("a.*");

        $generics =  $generics->orderBy('a.id', 'desc')->lazy();

        return response()->json($generics);
    }
////Category for Medicine Controller

    public function categoryEntryMedicine()
    {
        return view('admin.pharmacy.category_entry_medicine');
    }

    public function categoryStoreMedicine(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();

            $data['use_for']    = 'Medicine';
            $data['created_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();
            $data['branch_id']  = session('branch_id');

            Category::create($data);

            DB::commit();
            return response()->json(['message' => 'Medicine Category Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function categoryUpdateMedicine(Request $request)
    {
        $request->validate([
            'id'   => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();

            $data['use_for']    = 'Medicine';
            $data['updated_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();

            Category::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Medicine Category Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function categoryDeleteMedicine(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Category::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Medicine Category Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getCategoriesMedicine(Request $request)
    {
        $categoriesMedicine = DB::table('categories as a')
        ->where('a.use_for','Medicine')
        ->whereNull('a.deleted_at');

        $categoriesMedicine->select("a.*");

        $categoriesMedicine =  $categoriesMedicine->orderBy('a.id', 'desc')->lazy();

        return response()->json($categoriesMedicine);
    }
////Unit for Medicine Controller

    public function unitEntryMedicine()
    {
        return view('admin.pharmacy.unit_entry_medicine');
    }

    public function unitStoreMedicine(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();

            $data['use_for']    = 'Medicine';
            $data['created_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();
            $data['branch_id']  = session('branch_id');

            Unit::create($data);

            DB::commit();
            return response()->json(['message' => 'Medicine Unit Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function unitUpdateMedicine(Request $request)
    {
        $request->validate([
            'id'   => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        
        try {
            $data = (array) $request->all();

            $data['use_for']    = 'Medicine';
            $data['updated_by'] = auth()->user()->id;
            $data['ip_address'] = $request->ip();

            Unit::where('id', $request->id)->update($data);

            DB::commit();
            return response()->json(['message' => 'Medicine Unit Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function unitDeleteMedicine(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Unit::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Medicine Unit Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getUnitsMedicine(Request $request)
    {
        $unitsMedicine = DB::table('units as a')
        ->where('a.use_for','Medicine')
        ->whereNull('a.deleted_at');

        $unitsMedicine->select("a.*");

        $unitsMedicine =  $unitsMedicine->orderBy('a.id', 'desc')->lazy();

        return response()->json($unitsMedicine);
    }

    public function medicineEntry()
    {
        return view('admin.pharmacy.medicine_entry');
    }

    public function medicineStore(Request $request)
    {
        $medicine = json_decode($request->medicines);

        $validator = Validator::make((array) $medicine, [
            'medicine_code'  => 'required|string|unique:medicines',
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|integer',
            'generic_id'     => 'required|integer',
            'brand_id'       => 'required|integer',
            'unit_id'        => 'required|integer',
            'reorder_level'  => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_price'     => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
           
            $data                   = New Medicine();
            $data->name             = $medicine->name;
            $data->medicine_code    = $medicine->medicine_code;
            $data->category_id      = $medicine->category_id;
            $data->generic_id       = $medicine->generic_id;
            $data->brand_id         = $medicine->brand_id;
            $data->unit_id          = $medicine->unit_id;
            $data->sale_price       = $medicine->sale_price;
            $data->is_convert       = $medicine->is_convert;
            $data->converter_name   = $medicine->is_convert == true ? $medicine->converter_name : null;
            $data->convert_quantity = $medicine->is_convert == true ? $medicine->convert_quantity : 0;
            $data->purchase_price   = $medicine->purchase_price;
            $data->sale_price       = $medicine->sale_price;
            $data->reorder_level    = $medicine->reorder_level;
            $data->created_by       = auth()->user()->id;
            $data->ip_address       = $request->ip();
            $data->branch_id        = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Medicine Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function medicineUpdate(Request $request)
    {
        $medicine = json_decode($request->medicines);

        $validator = Validator::make((array) $medicine, [
            'id'             => 'required|integer',
            'medicine_code'  => ['required','string',Rule::unique('medicines')->ignore($medicine->id,'id')],
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|integer',
            'generic_id'     => 'required|integer',
            'brand_id'       => 'required|integer',
            'unit_id'        => 'required|integer',
            'reorder_level'  => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_price'     => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        
        try {
            $data=Medicine::find($medicine->id);
           
            $data->name             = $medicine->name;
            $data->medicine_code    = $medicine->medicine_code;
            $data->category_id      = $medicine->category_id;
            $data->generic_id       = $medicine->generic_id;
            $data->brand_id         = $medicine->brand_id;
            $data->unit_id          = $medicine->unit_id;
            $data->sale_price       = $medicine->sale_price;
            $data->is_convert       = $medicine->is_convert;
            $data->converter_name   = $medicine->is_convert == true ? $medicine->converter_name : null;
            $data->convert_quantity = $medicine->is_convert == true ? $medicine->convert_quantity : 0;
            $data->purchase_price   = $medicine->purchase_price;
            $data->sale_price       = $medicine->sale_price;
            $data->reorder_level    = $medicine->reorder_level;
            $data->updated_by       = auth()->user()->id;
            $data->ip_address       = $request->ip();
            $data->branch_id        = session('branch_id');
            $data->save(); 
            DB::commit();
            return response()->json(['message' => 'Medicine Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function medicineDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Medicine::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Medicine Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getMedicines(Request $request)
    {
        $getMedicine = DB::table('medicines as m')
        ->whereNull('m.deleted_at')
        ->select(DB::raw("m.*,concat_ws(' - ', m.name, m.medicine_code) as display_text, c.name as category_name, b.name as brand_name,g.name as generic_name,u.name as unit_name"))
        ->leftJoin('categories as c', 'c.id', '=', 'm.category_id')
        ->leftJoin('brands as b', 'b.id', '=', 'm.brand_id')
        ->leftJoin('generics as g', 'g.id', '=', 'm.generic_id')
        ->leftJoin('units as u', 'u.id', '=', 'm.unit_id');
        if($request->categoryId && $request->categoryId != null ){
            $getMedicine->where('m.category_id', '=' , $request->categoryId);
        }
         $getMedicine=  $getMedicine->orderBy('m.id', 'desc')->lazy();

        return response()->json($getMedicine);
    }
    public function getMedicineCode()
    {
        return response()->json(generateMedicineCode());
    }

    public function supplierPharmacyEntry()
    {
        return view('admin.pharmacy.pharmacy_supplier_entry');
    }

    public function supplierPharmacyStore(Request $request)
    {
        $supplierPharmacy = json_decode($request->supplierpharmacys);

        $validator = Validator::make((array) $supplierPharmacy, [
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
            $data->name          = $supplierPharmacy->name;
            $data->supplier_code = $supplierPharmacy->supplier_code;
            $data->owner_name    = $supplierPharmacy->owner_name;
            $data->mobile        = $supplierPharmacy->mobile;
            $data->address       = $supplierPharmacy->address;
            $data->remark        = $supplierPharmacy->remark;
            $data->use_for       = 'Medicine';
            $data->created_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 

            DB::commit();
            return response()->json(['message' => 'Medicine Supplier Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function supplierPharmacyUpdate(Request $request)
    {
        

        $supplierPharmacy = json_decode($request->supplierpharmacys);

        $validator = Validator::make((array) $supplierPharmacy, [
            'id'            => 'required|integer',
            'supplier_code' => ['required','string',Rule::unique('suppliers')->ignore($supplierPharmacy->id,'id')],
            'name'          => 'required|string|max:255',
            'owner_name'    => 'required|string|max:255',
            'mobile'        => 'required|string|size:11'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        
        try {
            $data                = Supplier::find($supplierPharmacy->id);
            $data->name          = $supplierPharmacy->name;
            $data->supplier_code = $supplierPharmacy->supplier_code;
            $data->owner_name    = $supplierPharmacy->owner_name;
            $data->mobile        = $supplierPharmacy->mobile;
            $data->address       = $supplierPharmacy->address;
            $data->remark        = $supplierPharmacy->remark;
            $data->use_for       = 'Medicine';
            $data->updated_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 
            DB::commit();
            return response()->json(['message' => 'Medicine Supplier Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function supplierPharmacyDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            Supplier::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Medicine Supplier Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    public function getSupplierPharmacys(Request $request)
    {
        $getSupplierPharmacy = DB::table('suppliers as si')
        ->whereNull('si.deleted_at')
        ->selectRaw("si.*,concat_ws(' - ', si.supplier_code , si.name) as display_name")
        ->where('si.use_for','Medicine')
        ->orderBy('si.id', 'desc')->lazy();
        return response()->json($getSupplierPharmacy);
    }
    public function getSupplierPharmacyCode()
    {
        return response()->json(generateSupplierPharmacyCode());
    }

    public function purchaseMedicineEntry()
    {
        $id = 0;
        $invoice = generatePurchaseMedicineCode();
        return view('admin.pharmacy.purchase_medicine_entry',compact('id','invoice'));
    }

    public function purchaseMedicineStore(Request $request)
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
            $data->remark           = $purcahse['note'];
            $data->use_for          = 'Medicine';
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
                    'use_for'          => 'Medicine',
                    'created_by'       => auth()->user()->id,
                    'ip_address'       => $request->ip(),
                    'branch_id'        => session('branch_id')
                ));

                $inventoryCount = DB::table('medicine_stocks')->where('medicine_id', $value['productId'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount == 0){
                    MedicineStock::create(array(
                        'medicine_id'       => $value['productId'],
                        'purchase_quantity' => $value['quantity'],
                        'stock_quantity'    => $value['quantity'],
                        'branch_id'         => session('branch_id')
                    ));
                }else{
                    DB::statement("
                    update medicine_stocks set 
                    purchase_quantity = purchase_quantity + ?, 
                    stock_quantity = stock_quantity + ? 
                    where medicine_id = ? 
                    and branch_id = ?
                ", [$value['quantity'], $value['quantity'], $value['productId'], session('branch_id')]);

                    DB::statement("
                    update medicines set 
                    purchase_price = ? 
                    where id = ?
                ", [$value['purchase_price'],$value['productId']]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Medicine Purhcase Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function purchaseMedicineUpdate(Request $request)
    {
        $purcahse    = $request->purchase;
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
            $data->remark           = $purcahse['note'];
            $data->use_for          = 'Medicine';
            $data->created_by       = auth()->user()->id;
            $data->ip_address       = $request->ip();
            $data->branch_id        = session('branch_id');
            $data->save(); 

            $oldPurchaseDetails = PurchaseDetail::where('purchase_id',$purcahse['id'])->get();

            $deletePurchaseDetails=PurchaseDetail::where('purchase_id',$purcahse['id']);
            $deletePurchaseDetails->forceDelete();

            
            foreach ($oldPurchaseDetails as $value) {
                DB::statement("
                update medicine_stocks set 
                purchase_quantity = purchase_quantity - ?, 
                stock_quantity = stock_quantity - ? 
                where medicine_id = ? 
                and branch_id = ?
            ", [$value->quantity, $value->quantity, $value->item_id, session('branch_id')]);

                DB::statement("
                update medicines set 
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
                    'use_for'          => 'Medicine',
                    'created_by'       => auth()->user()->id,
                    'ip_address'       => $request->ip(),
                    'branch_id'        => session('branch_id')
                ));

                $inventoryCount = DB::table('medicine_stocks')->where('medicine_id', $value['productId'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount == 0){
                    MedicineStock::create(array(
                        'medicine_id'       => $value['productId'],
                        'purchase_quantity' => $value['quantity'],
                        'stock_quantity'    => $value['quantity'],
                        'branch_id'         => session('branch_id')
                    ));
                }else{
                    DB::statement("
                    update medicine_stocks set 
                    purchase_quantity = purchase_quantity + ?, 
                    stock_quantity = stock_quantity + ? 
                    where medicine_id = ? 
                    and branch_id = ?
                ", [$value['quantity'], $value['quantity'], $value['productId'], session('branch_id')]);

                    DB::statement("
                    update medicines set 
                    purchase_price = ? 
                    where id = ?
                ", [$value['purchase_price'],$value['productId']]);
                }
            }


            DB::commit();
            return response()->json(['message' => 'Medicine Purchase Updated','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function getMadicineSupplierDue(Request $request)
    {
        $clauses = "";
        if($request->supplierId && $request->supplierId != null){
            $clauses = " and s.id = '$request->supplierId'";
        }
        $supplierDues =  supplierDue($clauses);
        return response()->json($supplierDues);
    }
    public function getMadicinePatientDue(Request $request)
    {
        $clauses = "";
        if($request->patientId && $request->patientId != null){
            $clauses = " and p.id = '$request->patientId'";
        }
        $patientDues =  patientDue($clauses);
        return response()->json($patientDues);
    }

    public function purchaseMedicineInvoice($id)
    {
        $id = $id;
        return view('admin.pharmacy.purchase_medicine_invoice',compact('id'));
    }
    public function purchaseMedicineInvoiceSearch()
    {
        return view('admin.pharmacy.purchase_medicine_invoice_search');
    }
    public function purchaseMedicineRecord()
    {
        return view('admin.pharmacy.purchase_medicine_record');
    }

    public function getPurchaseMedicine(Request $request)
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
            and p.use_for = 'Medicine'
            $clauses
        ", [session('branch_id')]);

        //dd($result);
        
        if($request->with_details){
            foreach($result as $value){
                $value->purchaseDetails = DB::select(
                    "SELECT pd.*,
                    m.medicine_code as code,
                    m.name as product_name,
                    u.name as unit_name,
                    concat(m.name, ' - ', m.medicine_code) as display_text
                    from purchase_details pd
                    left join medicines m on m.id = pd.item_id
                    left join units u on u.id = m.unit_id
                    where pd.purchase_id = '$value->id'
                    and pd.use_for = 'Medicine'
                ");
            }
        }

        return response()->json($result);
    }

    public function  getPurchaseMedicineDetails(Request $request){
        
        $clauses = "";
        if($request->supplierId && $request->supplierId != ''){
            $clauses .= " and s.id = '$request->supplierId'";
        }

        if($request->productId && $request->productId != ''){
            $clauses .= " and m.id = '$request->productId'";
        }

        if($request->categoryId && $request->categoryId != ''){
            $clauses .= " and pc.id = '$request->categoryId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and p.order_date between '$request->dateFrom' and '$request->dateTo'";
        }

        $result = DB::select(
            "SELECT pd.*,
                concat(m.name, ' - ', m.medicine_code) as display_text,
                pc.name as category_name,
                p.invoice_number,
                p.order_date,
                concat_ws(' - ', s.supplier_code , s.name) as display_name,
                s.supplier_code as supplier_code,
                s.name as supplier_name,
                s.mobile as supplier_mobile,
                s.address as supplier_address
            from purchase_details pd
            left join medicines m on m.id = pd.item_id
            left join categories pc on pc.id = m.category_id
            left join purchases p on p.id = pd.purchase_id
            left join suppliers s on s.id = p.supplier_id
            where p.deleted_at is null
            and pd.use_for = 'Medicine'
            and pd.branch_id = ?
            $clauses
        ",[session('branch_id')]);

        return response()->json($result);
    }

    public function purchaseMedicinetDelete(Request $request)
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

            $returnCount =  DB::table('purchase_returns as pr')
            ->whereNull('pr.deleted_at')
            ->where('pr.purchase_id',$request->id)
            ->where('pr.use_for','Medicine')
            ->count();

            if($returnCount != 0) {
                return response()->json(['message' => 'Unable to delete. Purchase return found']);
                exit;
            }

            $purchaseDetails = PurchaseDetail::where('purchase_id', $request->id)->get();
            foreach($purchaseDetails as $detail) {
                $stock = medicineStock($detail->item_id);
                if($detail->quantity > $stock) {
                    return response()->json(['success'=>false,'message' => 'Product out of stock, Purchase can not be deleted']);
                    exit;
                }
            }

            foreach($purchaseDetails as $product){
                DB::statement("
                    update medicine_stocks set 
                    purchase_quantity = purchase_quantity - ?, 
                    stock_quantity = stock_quantity - ? 
                    where medicine_id = ? 
                    and branch_id = ?
                ", [$product->quantity, $product->quantity, $product->item_id, session('branch_id')]);
            }

            Purchase::where('id', $request->id)->delete();
            PurchaseDetail::where('purchase_id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Medicine Purchase Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function checkPurchaseMedicineReturn($id)
    {
        $result = ['found'=>false];

        
        $returnCount =  DB::table('purchase_returns as pr')
            ->whereNull('pr.deleted_at')
            ->where('pr.purchase_id',$id)
            ->where('pr.use_for','Medicine')
            ->count();
        
        if($returnCount != 0) {
            $result = ['found'=>true];
        }
        return response()->json($result);
    }

    public function purchaseOrderMedicineEdit($id)
    {
        $id = $id;
        $purs = Purchase::findOrFail($id);
        $invoice = $purs->invoice_number;
        return view('admin.pharmacy.purchase_medicine_entry',compact('id','invoice'));
    }
    public function damageMedicineEntry()
    {
        $code = generateDamageMedicineCode();
        return view('admin.pharmacy.damage_medicine_entry', compact('code'));
    }
    public function damageMedicineList()
    {
        return view('admin.pharmacy.damage_medicine_list');
    }

    public function getDamageMedicine(Request $request) {

        $clauses = "";
        if($request->damageId && $request->damageId != ''){
            $clauses .= " and d.item_id = '$request->damageId'";
        }
        $result = DB::select(
            "SELECT
                d.*, c.name as category_name,
                c.id as category_id, c.use_for as category_use_for,
                mdc.name as product_name, mdc.is_convert as product_is_convert,
                mdc.medicine_code as code, mdc.convert_quantity as product_convert_quantity,
                concat(mdc.name, ' - ', mdc.medicine_code) as display_text
            from damages d
            left join medicines mdc on mdc.id = d.item_id
            left join categories c on c.id = mdc.category_id
            where d.deleted_at is null
            and d.use_for = 'Medicine'
            $clauses
        ");
        return response()->json($result);
    }
    
    public function damageMedicineStore(Request $request)
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
            $data->use_for       = 'Medicine';
            $data->created_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 

            $medicineCount = DB::table('medicine_stocks')->where('medicine_id', $damage->item_id)->where('branch_id', session('branch_id'))->count();
            // dd($inventoryCount);
            if( $medicineCount = 0) {
                MedicineStock::create(array(
                    'medicine_id'   => $damage->item_id,
                    'damage_quantity' => $damage->quantity,
                    'stock_quantity'  => $damage->stock_quantity,
                    'branch_id'       => session('branch_id')
                ));
            }else{
                DB::statement("
                    update medicine_stocks set 
                    damage_quantity = damage_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where medicine_id = ? 
                    and branch_id = ?
                ", [$damage->quantity, $damage->quantity, $damage->item_id, session('branch_id')]);
            }
            
            DB::commit();
            return response()->json(['message' => 'Medicine Damage Added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    
    public function damageMedicineUpdate(Request $request)
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
                    update medicine_stocks set 
                    damage_quantity = damage_quantity - ?, 
                    stock_quantity = stock_quantity + ? 
                    where medicine_id = ? 
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
            $data->use_for       = 'Medicine';
            $data->created_by    = auth()->user()->id;
            $data->ip_address    = $request->ip();
            $data->branch_id     = session('branch_id');
            $data->save(); 

          
            DB::statement("
                    update medicine_stocks set 
                    damage_quantity = damage_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where medicine_id = ? 
                    and branch_id = ?
            ", [$damage->quantity, $damage->quantity, $damage->item_id, session('branch_id')]);
            
            DB::commit();
            return response()->json(['message' => 'Inventory Damage Updated']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function damageMedicineDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {

            $oldDamage= Damage::where('id',$request->id)->first();

            DB::statement("
                    update medicine_stocks set 
                    damage_quantity = damage_quantity - ?, 
                    stock_quantity = stock_quantity + ? 
                    where medicine_id = ? 
                    and branch_id = ?
            ", [$oldDamage->quantity, $oldDamage->quantity, $oldDamage->item_id, session('branch_id')]);

            Damage::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Medicine Purchase Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    ////// Sale
    public function saleMedicineEntry()
    {
        $id = 0;
        $invoice = generateSaleMedicineCode();
        return view('admin.pharmacy.sale_medicine_entry',compact('id','invoice'));
    }

    public function getMedicineStock(Request $request)
    {
        $stock = medicineStock($request->productId);
        return response()->json($stock);
    }

    public function saleMedicineStore(Request $request)
    {
        $sale = $request->sales;
        $productCart = $request->cart;
        $validator = Validator::make((array) $sale, [
            'invoice_number' => 'required|string|unique:sales',
            'patientId'      => 'required|integer',
            'salesDate'      => 'required|date',
            'subTotal'       => 'required|numeric',
            'discountper'    => 'required|numeric',
            'discount'       => 'required|numeric',
            'vatpercent'     => 'required|numeric',
            'vat'            => 'required|numeric',
            'transportCost'  => 'required|numeric',
            'total'          => 'required|numeric',
            'paid'           => 'required|numeric',
            'due'            => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {

            $admissiontId= Admission::where('patient_id',$sale['patientId'])->first();
            $data                   = New Sale();
            $data->invoice_number   = $sale['invoice_number'];
            $data->patient_id       = $sale['patientId'];

            if($admissiontId && $admissiontId->status == "Admited"){
                $data->admission_id       = $admissiontId->id;
            }else{
                $data->admission_id       = null;
            }

            $data->order_date       = $sale['salesDate'];
            $data->subtotal         = $sale['subTotal'];
            $data->discount_percent = $sale['discountper'];
            $data->discount_amount  = $sale['discount'];
            $data->vat_percent      = $sale['vatpercent'];
            $data->vat_amount       = $sale['vat'];
            $data->transport_cost   = $sale['transportCost'];
            $data->total            = $sale['total'];
            $data->paid             = $sale['paid'];
            $data->due              = $sale['due'];
            $data->remark           = $sale['note'];
            $data->created_by       = auth()->user()->id;
            $data->ip_address       = $request->ip();
            $data->branch_id        = session('branch_id');
            $data->save(); 

            foreach ($productCart as $value) {
                SaleDetail::create(array(
                    'sale_id'          => $data->id,
                    'medicine_id'      => $value['productId'],
                    'quantity'         => $value['quantity'],
                    'purchase_rate'    => $value['purchase_rate'],
                    'sale_rate'        => $value['salesRate'],
                    'total_sale_rate'  => $value['quantity'] * $value['salesRate'],
                    'discount_percent' => $value['salesRate'],
                    'discount_amount'  => $value['discount'],
                    'converter_name'   => $value['converter_name'],
                    'convert_quantity' => $value['convert_quantity'],
                    'discount_percent' => $value['discount_percent'],
                    'total_amount'     => $value['total'],
                    'created_by'       => auth()->user()->id,
                    'ip_address'       => $request->ip(),
                    'branch_id'        => session('branch_id')
                ));

                $inventoryCount = DB::table('medicine_stocks')->where('medicine_id', $value['productId'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount != 0){
                    DB::statement("
                    update medicine_stocks set 
                    sales_quantity = sales_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where medicine_id = ? 
                    and branch_id = ?
                    ", [$value['quantity'], $value['quantity'], $value['productId'], session('branch_id')]);
                }
            }
            DB::commit();
            return response()->json(['message' => 'Medicine Sale Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function saleMedicineUpdate(Request $request)
    {
        $sale = $request->sales;
        $productCart = $request->cart;
        $validator   = Validator::make((array) $sale, [
            'id'              => 'required|integer',
            'invoice_number'  => ['required','string',Rule::unique('sales')->ignore($sale['id'],'id')],
            'patientId'      => 'required|integer',
            'salesDate'      => 'required|date',
            'subTotal'       => 'required|numeric',
            'discountper'    => 'required|numeric',
            'discount'       => 'required|numeric',
            'vatpercent'     => 'required|numeric',
            'vat'            => 'required|numeric',
            'transportCost'  => 'required|numeric',
            'total'          => 'required|numeric',
            'paid'           => 'required|numeric',
            'due'            => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $admissiontId= Admission::where('patient_id',$sale['patientId'])->first();
            $data                   = Sale::find($sale['id']);
            $data->invoice_number   = $sale['invoice_number'];
            $data->patient_id       = $sale['patientId'];
            if($admissiontId && $admissiontId->status == "Admited"){
                $data->admission_id       = $admissiontId->id;
            }else{
                $data->admission_id       = null;
            }
            $data->order_date       = $sale['salesDate'];
            $data->subtotal         = $sale['subTotal'];
            $data->discount_percent = $sale['discountper'];
            $data->discount_amount  = $sale['discount'];
            $data->vat_percent      = $sale['vatpercent'];
            $data->vat_amount       = $sale['vat'];
            $data->transport_cost   = $sale['transportCost'];
            $data->total            = $sale['total'];
            $data->paid             = $sale['paid'];
            $data->due              = $sale['due'];
            $data->remark           = $sale['note'];
            $data->created_by       = auth()->user()->id;
            $data->ip_address       = $request->ip();
            $data->branch_id        = session('branch_id');
            $data->save();  

            $oldSaleDetails = SaleDetail::where('sale_id',$sale['id'])->get();

            $deleteSaleDetails=SaleDetail::where('sale_id',$sale['id']);
            $deleteSaleDetails->forceDelete();

            
            foreach ($oldSaleDetails as $value) {
                DB::statement("
                update medicine_stocks set 
                sales_quantity = sales_quantity - ?, 
                stock_quantity = stock_quantity + ? 
                where medicine_id = ? 
                and branch_id = ?
            ", [$value->quantity, $value->quantity, $value->medicine_id, session('branch_id')]);

            }
            
            foreach ($productCart as $value) {
                SaleDetail::create(array(
                    'sale_id'          => $data->id,
                    'medicine_id'      => $value['productId'],
                    'quantity'         => $value['quantity'],
                    'purchase_rate'    => $value['purchase_rate'],
                    'sale_rate'        => $value['salesRate'],
                    'total_sale_rate'  => $value['quantity'] * $value['salesRate'],
                    'discount_percent' => $value['salesRate'],
                    'discount_amount'  => $value['discount'],
                    'converter_name'   => $value['converter_name'],
                    'convert_quantity' => $value['convert_quantity'],
                    'discount_percent' => $value['discount_percent'],
                    'total_amount'     => $value['total'],
                    'created_by'       => auth()->user()->id,
                    'ip_address'       => $request->ip(),
                    'branch_id'        => session('branch_id')
                ));

                $inventoryCount = DB::table('medicine_stocks')->where('medicine_id', $value['productId'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount != 0){
                    DB::statement("
                    update medicine_stocks set 
                    sales_quantity = sales_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where medicine_id = ? 
                    and branch_id = ?
                    ", [$value['quantity'], $value['quantity'], $value['productId'], session('branch_id')]);
                }
            }
            DB::commit();
            return response()->json(['message' => 'Medicine Sale Updated','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function saleMedicineDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {

            $sale = Sale::where('id', $request->id)->first();
            if($sale->deleted_at != null){
                return response()->json(['message' => 'Sale not found']);
                exit;
            }
            $saleCount =  DB::table('sale_returns as sr')
            ->whereNull('sr.deleted_at')
            ->where('sr.sale_id',$request->id)
            ->count();

            if($saleCount != 0) {
                return response()->json(['message' => 'Unable to delete. Sale return found']);
                exit;
            }

            $saleDetails = SaleDetail::where('sale_id', $request->id)->get();
         
            foreach($saleDetails as $product){
                DB::statement("
                    update medicine_stocks set 
                    sales_quantity = sales_quantity - ?, 
                    stock_quantity = stock_quantity + ? 
                    where medicine_id = ? 
                    and branch_id = ?
                ", [$product->quantity, $product->quantity, $product->medicine_id, session('branch_id')]);
            }

            Sale::where('id', $request->id)->delete();
            SaleDetail::where('sale_id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Medicine Sale Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function saleMedicineInvoice($id)
    {
        $id = $id;
        return view('admin.pharmacy.sale_medicine_invoice',compact('id'));
    }

    public function saleMedicineEdit($id)
    {
        $id = $id;
        $sales = Sale::findOrFail($id);
        $invoice = $sales->invoice_number;
        return view('admin.pharmacy.sale_medicine_entry',compact('id','invoice'));
    }

    public function getSaleMedicine(Request $request)
    {
        $clauses = "";
        if($request->salesId && $request->salesId != ''){
            $clauses .= " and s.id = '$request->salesId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and s.order_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->patient_id && $request->patient_id != ''){
            $clauses .= " and s.patient_id = '$request->patient_id'";
        }
        if($request->userId && $request->userId != ''){
            $clauses .= " and s.created_by = '$request->userId'";
        }
        
        //dd($request->purchaseId);
        $result = DB::select(
            "SELECT s.*,
            concat_ws(' - ', s.invoice_number, p.name) as invoice_text,
            concat_ws(' - ', p.patient_code , p.name) as display_name,
            p.patient_code as patient_code,
            p.name as patient_name,
            p.mobile as patient_mobile,
            p.address as patient_address,
            u.name as user_name

            from sales s
            left join patients p on p.id = s.patient_id 
            left join users u on u.id = s.created_by
            where s.deleted_at is null
            and s.branch_id = ?
            $clauses
        ", [session('branch_id')]);

        //dd($result);
        
        if($request->with_details){
            foreach($result as $value){
                $value->saleDetails = DB::select(
                    "SELECT sd.*,
                    sd.id as product_id,
                    m.medicine_code  as code,
                    m.name as product_name,
                    u.name as unit_name,
                    concat(m.name, ' - ', m.medicine_code) as display_text
                    from sale_details sd
                    left join medicines m on m.id = sd.medicine_id  
                    left join units u on u.id = m.unit_id
                    where sd.sale_id = '$value->id'
                ");
            }
        }

        return response()->json($result);
    }
    public function  getSaleMedicineDetails(Request $request){
        
        $clauses = "";
        if($request->patient_id && $request->patient_id != ''){
            $clauses .= " and p.id = '$request->patient_id'";
        }

        if($request->productId && $request->productId != ''){
            $clauses .= " and m.id = '$request->productId'";
        }

        if($request->categoryId && $request->categoryId != ''){
            $clauses .= " and pc.id = '$request->categoryId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and s.order_date between '$request->dateFrom' and '$request->dateTo'";
        }

        $result = DB::select(
            "SELECT sd.*,
                concat(p.name, ' - ', m.medicine_code) as display_text,
                pc.name as category_name,
                u.name as unit_name,
                sd.id as product_id,
                s.invoice_number,
                s.order_date,
                concat_ws(' - ', p.patient_code , p.name) as display_name,
                p.patient_code as patient_code,
                p.name as patient_name,
                p.mobile as patient_mobile,
                p.address as patient_address
            from sale_details sd
            left join medicines m on m.id = sd.medicine_id
            left join categories pc on pc.id = m.category_id
            left join sales s on s.id = sd.sale_id
            left join units u on u.id = m.unit_id
            left join patients p on p.id = s.patient_id
            where s.deleted_at is null
            and sd.branch_id = ?
            $clauses
        ",[session('branch_id')]);

        return response()->json($result);
    }

    public function saleMedicineRecord()
    {
        return view('admin.pharmacy.sale_medicine_record');
    }
    public function saleMedicineInvoiceSearch()
    {
        return view('admin.pharmacy.sale_medicine_invoice_search');
    }

    public function purchaseReturnMedicineEntry()
    {
        $id = 0;
        return view('admin.pharmacy.purchase_return_medicine_entry',compact('id'));
    }

    public function  getPurchaseReturnMedicineDetails(Request $request){
        
        $result = DB::select("
            SELECT 
                pd.*,
                pd.purchase_rate as return_rate,
                m.name as product_name,
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
            left join medicines m on m.id = pd.item_id
            left join categories pc on pc.id = m.category_id
            where p.id = $request->purchaseId
            and pd.use_for = 'Medicine'
            and p.branch_id = ?

        ",[session('branch_id')]);

        return response()->json($result);
    }

    public function purchaseReturnMedicineStore(Request $request)
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
            $data->use_for      = 'Medicine';
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
                    'use_for'            => 'Medicine',
                    'created_by'         => auth()->user()->id,
                    'ip_address'         => $request->ip(),
                    'branch_id'          => session('branch_id')
                ));

                $inventoryCount = DB::table('medicine_stocks')->where('medicine_id', $value['item_id'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount != 0){
                    DB::statement("
                    update medicine_stocks set 
                    purchase_return_quantity = 	purchase_return_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where medicine_id = ? 
                    and branch_id = ?
                ", [$value['return_quantity'], $value['return_quantity'], $value['item_id'], session('branch_id')]);

                }
            }

            DB::commit();
            return response()->json(['message' => 'Medicine Purhcase Return Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function purchaseReturnMedicineUpdate(Request $request)
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
            $data                   = PurchaseReturn::find($purchaseReturn['id']);
            $data->purchase_id  = $purchaseReturn['purchase_id'];
            $data->supplier_id  = $purchaseReturn['supplier_id'];
            $data->return_date  = $purchaseReturn['return_date'];
            $data->total_amount = $purchaseReturn['total_amount'];
            $data->remark       = $purchaseReturn['note'];
            $data->use_for      = 'Medicine';
            $data->created_by   = auth()->user()->id;
            $data->ip_address   = $request->ip();
            $data->branch_id    = session('branch_id');
            $data->save();  

            $oldPurchaseReturnDetails = PurchaseReturnDetail::where('purchase_return_id',$purchaseReturn['id'])->get();

            $deletePurchaseReturnDetails=PurchaseReturnDetail::where('purchase_return_id',$purchaseReturn['id']);
            $deletePurchaseReturnDetails->forceDelete();

            
            foreach ($oldPurchaseReturnDetails as $value) {
                    DB::statement("
                    update medicine_stocks set 
                    purchase_return_quantity = purchase_return_quantity - ?, 
                    stock_quantity = stock_quantity + ? 
                    where medicine_id = ? 
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
                    'use_for'            => 'Medicine',
                    'created_by'         => auth()->user()->id,
                    'ip_address'         => $request->ip(),
                    'branch_id'          => session('branch_id')
                ));

                $inventoryCount = DB::table('medicine_stocks')->where('medicine_id', $value['item_id'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount != 0){
                    DB::statement("
                    update medicine_stocks set 
                    purchase_return_quantity = 	purchase_return_quantity + ?, 
                    stock_quantity = stock_quantity - ? 
                    where medicine_id = ? 
                    and branch_id = ?
                ", [$value['return_quantity'], $value['return_quantity'], $value['item_id'], session('branch_id')]);

                }
            }


            DB::commit();
            return response()->json(['message' => 'Medicine Purchase Return Updated','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function purchaseReturnMedicinetDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {

            $purchaseReturnDetails = PurchaseReturnDetail::where('purchase_return_id', $request->id)->get();
            // foreach($purchaseReturnDetails as $detail) {
            //     $stock = medicineStock($detail->item_id);
            //     if($detail->quantity > $stock) {
            //         return response()->json(['success'=>false,'message' => 'Product out of stock, Purchase can not be deleted']);
            //         exit;
            //     }
            // }

            foreach($purchaseReturnDetails as $product){
                DB::statement("
                    update medicine_stocks set 
                    purchase_return_quantity = purchase_return_quantity - ?, 
                    stock_quantity = stock_quantity - ? 
                    where medicine_id = ? 
                    and branch_id = ?
                ", [$product->quantity, $product->quantity, $product->item_id, session('branch_id')]);
            }

            PurchaseReturn::where('id', $request->id)->delete();
            PurchaseReturnDetail::where('purchase_return_id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Medicine Purchase Return Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function purchaseReturnMedicineInvoice($id)
    {
        $id = $id;
        return view('admin.pharmacy.purchase_return_medicine_invoice',compact('id'));
    }

    public function getPurchaseReturnMedicine(Request $request)
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
            and pr.use_for = 'Medicine'
            $clauses
        ", [session('branch_id')]);

        //dd($result);
        
        if($request->with_details){
            foreach($result as $value){
                $value->purchaseReturnDetails = DB::select(
                    "SELECT prd.*,
                    m.medicine_code as code,
                    m.name as product_name,
                    u.name as unit_name,
                    concat(m.name, ' - ', m.medicine_code) as display_text
                    from purchase_return_details prd
                    left join medicines m on m.id = prd.item_id
                    left join units u on u.id = m.unit_id
                    where prd.purchase_return_id = '$value->id'
                    and prd.use_for = 'Medicine'
                ");
            }
        }

        return response()->json($result);
    }
    
    public function purchaseReturnMedicineRecord()
    {
        return view('admin.pharmacy.purchase_return_medicine_list');
    }
    public function  getReturnMedicineDetails(Request $request){
        
        $clauses = "";
        if($request->supplierId && $request->supplierId != ''){
            $clauses .= " and s.id = '$request->supplierId'";
        }

        if($request->productId && $request->productId != ''){
            $clauses .= " and m.id = '$request->productId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and pr.return_date between '$request->dateFrom' and '$request->dateTo'";
        }

        $result = DB::select(
            "SELECT prd.*,
                concat(m.name, ' - ', m.medicine_code) as display_text,
                p.invoice_number,
                pr.return_date,
                concat_ws(' - ', s.supplier_code , s.name) as display_name,
                s.supplier_code as supplier_code,
                s.name as supplier_name,
                s.mobile as supplier_mobile,
                s.address as supplier_address
            from purchase_return_details prd
            left join medicines m on m.id = prd.item_id
            left join purchase_returns pr on pr.id = prd.purchase_return_id
            left join purchases p on p.id = pr.purchase_id
            left join suppliers s on s.id = pr.supplier_id
            where pr.deleted_at is null
            and prd.use_for = 'Medicine'
            and prd.branch_id = ?
            $clauses
        ",[session('branch_id')]);

        return response()->json($result);
    }

    public function purchaseReturnMedicineEdit($id)
    {
        $id = $id;
        $pursReturn = PurchaseReturn::findOrFail($id);
        $invoice = $pursReturn->invoice_number;
        return view('admin.pharmacy.purchase_return_medicine_entry',compact('id','invoice'));
    }

    ////sale Return
    public function saleReturnMedicineEntry()
    {
        $id = 0;
        return view('admin.pharmacy.sale_return_medicine_entry',compact('id'));
    }

    public function  getSaleReturnMedicineDetails(Request $request){
        
        $result = DB::select("
            SELECT 
                sd.*,
                sd.sale_rate as return_rate,
                m.name as product_name,
                pc.name as category_name,
                (
                    SELECT ifnull(sum(srd.quantity), 0) 
                    from sale_return_details srd
                    join sale_returns sr on sr.id = srd.sale_return_id
                    where sr.sale_id = s.id
                    and srd.medicine_id = sd.medicine_id
                ) as returned_quantity,
                (
                    SELECT ifnull(sum(srd.total_amount), 0) 
                    from sale_return_details srd
                    join sale_returns sr on sr.id = srd.sale_return_id
                    where sr.sale_id = s.id
                    and srd.medicine_id = sd.medicine_id
                ) as returned_amount
            from sale_details sd
            left join sales s on s.id = sd.sale_id
            left join medicines m on m.id = sd.medicine_id
            left join categories pc on pc.id = m.category_id
            where s.id = $request->saleId
            and s.branch_id = ?

        ",[session('branch_id')]);

        return response()->json($result);
    }

    public function saleReturnMedicineStore(Request $request)
    {
        $saleReturn = $request->saleReturn;
        $productCart = $request->cart;
        $validator = Validator::make((array) $saleReturn, [
            'sale_id'      => 'required|integer',
            'patient_id'   => 'required|integer',
            'return_date'  => 'required|date',
            'total_amount' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data               = New SaleReturn();
            $data->sale_id      = $saleReturn['sale_id'];
            $data->patient_id   = $saleReturn['patient_id'];
            $data->return_date  = $saleReturn['return_date'];
            $data->total_amount = $saleReturn['total_amount'];
            $data->remark       = $saleReturn['note'];
            $data->created_by   = auth()->user()->id;
            $data->ip_address   = $request->ip();
            $data->branch_id    = session('branch_id');
            $data->save(); 

            foreach ($productCart as $value) {
                SaleReturnDetail::create(array(
                    'sale_return_id'   => $data->id,
                    'medicine_id'      => $value['medicine_id'],
                    'quantity'         => $value['return_quantity'],
                    'return_rate'      => $value['return_rate'],
                    'converter_name'   => $value['converter_name'],
                    'convert_quantity' => $value['convert_quantity'],
                    'total_amount'     => $value['return_amount'],
                    'created_by'       => auth()->user()->id,
                    'ip_address'       => $request->ip(),
                    'branch_id'        => session('branch_id')
                ));

                $inventoryCount = DB::table('medicine_stocks')->where('medicine_id', $value['medicine_id'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount != 0){
                    DB::statement("
                    update medicine_stocks set 
                    sales_return_quantity = 	sales_return_quantity + ?, 
                    stock_quantity = stock_quantity + ? 
                    where medicine_id = ? 
                    and branch_id = ?
                ", [$value['return_quantity'], $value['return_quantity'], $value['medicine_id'], session('branch_id')]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Medicine Sale Return Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function saleReturnMedicineUpdate(Request $request)
    {
        $saleReturn = $request->saleReturn;
        $productCart = $request->cart;
        $validator = Validator::make((array) $saleReturn, [
            'sale_id'      => 'required|integer',
            'patient_id'   => 'required|integer',
            'return_date'  => 'required|date',
            'total_amount' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
       
        DB::beginTransaction();
        
        try {
            $data               = SaleReturn::find($saleReturn['id']);
            $data->sale_id      = $saleReturn['sale_id'];
            $data->patient_id   = $saleReturn['patient_id'];
            $data->return_date  = $saleReturn['return_date'];
            $data->total_amount = $saleReturn['total_amount'];
            $data->remark       = $saleReturn['note'];
            $data->created_by   = auth()->user()->id;
            $data->ip_address   = $request->ip();
            $data->branch_id    = session('branch_id');
            $data->save();  

            $oldSaleReturnDetails = SaleReturnDetail::where('sale_return_id',$saleReturn['id'])->get();

            $deleteSaleReturnDetails=SaleReturnDetail::where('sale_return_id',$saleReturn['id']);
            $deleteSaleReturnDetails->forceDelete();

            
            foreach ($oldSaleReturnDetails as $value) {
                
                    DB::statement("
                    update medicine_stocks set 
                    sales_return_quantity = sales_return_quantity - ?, 
                    stock_quantity = stock_quantity - ? 
                    where medicine_id = ? 
                    and branch_id = ?
                    ", [$value->quantity, $value->quantity, $value->medicine_id, session('branch_id')]);
                     
            }
            
            foreach ($productCart as $value) {
                SaleReturnDetail::create(array(
                    'sale_return_id'   => $data->id,
                    'medicine_id'      => $value['medicine_id'],
                    'quantity'         => $value['return_quantity'],
                    'return_rate'      => $value['return_rate'],
                    'converter_name'   => $value['converter_name'],
                    'convert_quantity' => $value['convert_quantity'],
                    'total_amount'     => $value['return_amount'],
                    'created_by'       => auth()->user()->id,
                    'ip_address'       => $request->ip(),
                    'branch_id'        => session('branch_id')
                ));

                $inventoryCount = DB::table('medicine_stocks')->where('medicine_id', $value['medicine_id'])->where('branch_id', session('branch_id'))->count();
               // dd($inventoryCount);
                if( $inventoryCount != 0){
                    DB::statement("
                    update medicine_stocks set 
                    sales_return_quantity = 	sales_return_quantity + ?, 
                    stock_quantity = stock_quantity + ? 
                    where medicine_id = ? 
                    and branch_id = ?
                ", [$value['return_quantity'], $value['return_quantity'], $value['medicine_id'], session('branch_id')]);
                }
            }


            DB::commit();
            return response()->json(['message' => 'Medicine Sale Return Updated','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function saleReturnMedicineInvoice($id)
    {
        $id = $id;
    return view('admin.pharmacy.sale_return_medicine_invoice',compact('id'));
    }


    public function getSaleReturnMedicine(Request $request)
    {
        $clauses = "";
        if($request->saleReturnId && $request->saleReturnId != ''){
            $clauses .= " and sr.id = '$request->saleReturnId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and sr.return_date between '$request->dateFrom' and '$request->dateTo'";
        }

        if($request->patient_id && $request->patient_id != ''){
            $clauses .= " and sr.patient_id = '$request->patient_id'";
        }
       
        
        //dd($request->purchaseId);
        $result = DB::select(
            "SELECT sr.*,
            concat_ws(' - ', s.invoice_number, p.name) as invoice_text,
            concat_ws(' - ', p.patient_code , p.name) as display_name,
            p.patient_code as patient_code,
            p.name as patient_name,
            p.mobile as patient_mobile,
            p.address as patient_address,
            u.name as user_name,
            s.invoice_number as invoice_number,
            s.discount_amount as discount_amount

            from sale_returns sr
            left join sales s on s.id = sr.sale_id
            left join patients p on p.id = sr.patient_id
            left join users u on u.id = s.created_by
            where sr.deleted_at is null
            and sr.branch_id = ?
            $clauses
        ", [session('branch_id')]);

        if($request->with_details){
            foreach($result as $value){
                $value->saleReturnDetails = DB::select(
                    "SELECT srd.*,
                    m.medicine_code as code,
                    m.name as product_name,
                    u.name as unit_name,
                    concat(m.name, ' - ', m.medicine_code) as display_text
                    from sale_return_details srd
                    left join medicines m on m.id = srd.medicine_id
                    left join units u on u.id = m.unit_id
                    where srd.sale_return_id = '$value->id'
                ");
            }
        }

        return response()->json($result);
    }

    public function  getSaleReturnMedicineRecordDetails(Request $request){
        
        $clauses = "";
        if($request->patient_id && $request->patient_id != ''){
            $clauses .= " and p.id = '$request->patient_id'";
        }

        if($request->productId && $request->productId != ''){
            $clauses .= " and m.id = '$request->productId'";
        }

        if($request->dateFrom && $request->dateFrom != '' && $request->dateTo && $request->dateTo != ''){
            $clauses .= " and sr.return_date between '$request->dateFrom' and '$request->dateTo'";
        }

        $result = DB::select(
            "SELECT srd.*,
                concat(m.name, ' - ', m.medicine_code) as display_text,
                s.invoice_number,
                sr.return_date,
                concat_ws(' - ', p.patient_code , p.name) as display_name,
                p.patient_code as patient_code,
                p.name as patient_name,
                p.mobile as patient_mobile,
                p.address as patient_address
            from sale_return_details srd
            left join medicines m on m.id = srd.medicine_id
            left join sale_returns sr on sr.id = srd.sale_return_id
            left join sales s on s.id = sr.sale_id
            left join patients p on p.id = sr.patient_id
            where sr.deleted_at is null
            and srd.branch_id = ?
            $clauses
        ",[session('branch_id')]);

        return response()->json($result);
    }

    public function saleReturnMedicinetDelete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {

            $saleReturnDetails = SaleReturnDetail::where('sale_return_id', $request->id)->get();
          

            foreach($saleReturnDetails as $product){
                DB::statement("
                    update medicine_stocks set 
                    sales_return_quantity = sales_return_quantity - ?, 
                    stock_quantity = stock_quantity + ? 
                    where medicine_id = ? 
                    and branch_id = ?
                ", [$product->quantity, $product->quantity, $product->medicine_id, session('branch_id')]);
            }

            SaleReturn::where('id', $request->id)->delete();
            SaleReturnDetail::where('sale_return_id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Medicine Sale Return Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function saleReturnMedicineRecord()
    {
        return view('admin.pharmacy.sale_return_medicine_list');
    }


    public function saleReturnMedicineEdit($id)
    {
        $id = $id;
        return view('admin.pharmacy.sale_return_medicine_entry',compact('id'));
    }

    public function stockMedicine()
    {
        return view('admin.pharmacy.stock_medicine');
    }

    public function  getCurrentStockMedicine(Request $request){
        
        $clauses = "";
        if(isset($request->stockType) && $request->stockType == 'low'){
            $clauses .= " and current_quantity <= reorder_level";
        }

       //dd($clauses);
        $stock = currentMedicineStock($clauses);
        $result['stock'] = $stock;
        $result['totalValue'] = array_sum(
            array_map(function($product){
                return $product->stock_value;
            }, $stock));
        return response()->json($result);
    }

    public function  getTotalStockMedicine(Request $request){
        
     
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
                    and pd.use_for = 'Medicine'
                    and pd.deleted_at is null
                    " . (isset($request->date) && $request->date != null ? " and pr.order_date <= '$request->date'" : "") . "
                ) as purchased_quantity,

                (SELECT ifnull(sum(prd.quantity), 0) 
                    from purchase_return_details prd 
                    left join purchase_returns pr on pr.id = prd.purchase_return_id 
                    where prd.item_id = p.id
                    and prd.branch_id = '$branchId'
                    and prd.use_for = 'Medicine'
                    and prd.deleted_at is null
                    " . (isset($request->date) && $request->date != null ? " and pr.return_date <= '$request->date'" : "") . "
                ) as purchased_return_quantity,
                        
                
                (SELECT ifnull(sum(sd.quantity), 0) 
                    from sale_details sd
                    left join sales s on s.id = sd.sale_id
                    where sd.medicine_id = p.id
                    and sd.branch_id  = '$branchId'
                    and sd.deleted_at is null
                    " . (isset($request->date) && $request->date != null ? " and s.order_date <= '$request->date'" : "") . "
                ) as sold_quantity,
                        
                (SELECT ifnull(sum(srd.quantity), 0) 
                    from sale_return_details srd
                    left join sale_returns srn on srn.id = srd.sale_return_id
                    where srd.medicine_id = p.id
                    and srd.branch_id  = '$branchId'
                    and srd.deleted_at is null
                    " . (isset($request->date) && $request->date != null ? " and srn.return_date <= '$request->date'" : "") . "
                ) as sold_return_quantity,
                        

                (SELECT ifnull(sum(dm.quantity), 0) 
                    from damages dm
                    where dm.item_id  = p.id
                    and dm.deleted_at is null
                    and dm.use_for = 'Medicine'
                    and dm.branch_id = '$branchId'
                    " . (isset($request->date) && $request->date != null ? " and dm.damage_date <= '$request->date'" : "") . "
                ) as damaged_quantity,
            
                        
                (SELECT (purchased_quantity + sold_return_quantity) - (sold_quantity +  damaged_quantity + purchased_return_quantity)) as current_quantity,
                (SELECT p.purchase_price * current_quantity) as stock_value
            from medicines p
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

    public function supplierPaymentMedicine()
    {
        return view('admin.pharmacy.pharmacy_supplier_payment_entry');
    }

    public function getSupplierPaymentMedicineCode()
    {
        return response()->json(generateSupplierPaymentMedicineCode());
    }
    public function getSupplierPaymentMedicine(Request $request)
    {
        $getSupplierPaymentTransaction = DB::table('supplier_payments as sp')
        ->selectRaw("sp.*, concat( ba.account_name, ' - ', ba.account_number,' (', ba.bank_name,')') as display_text, concat( s.supplier_code, ' - ', s.name) as supplier_text")
        ->leftJoin('bank_accounts as ba', 'ba.id', '=', 'sp.account_id' )
        ->leftJoin('suppliers as s', 's.id', '=', 'sp.supplier_id' )
        ->whereNull('sp.deleted_at')
        ->where('sp.use_for','Medicine');

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

    public function supplierPaymentMedicineStore(Request $request)
    {
        $supplierpayment = $request->supplierpayment;
        $validator = Validator::make((array) $supplierpayment, [
            'transaction_number' => 'required|string|unique:supplier_payments',
            'supplier_id'        => 'required|integer',
            'payment_date'       => 'required|date',
            'transaction_type'   => ['required', Rule::in(['Payment', 'Received'])],
            'payment_type'       => ['required', Rule::in(['Cash', 'Bank'])],
            'amount'             => 'required|numeric',
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
            $data->remark             = $supplierpayment['remark'];
            $data->use_for            = 'Medicine';
            $data->created_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 
 

            DB::commit();
            return response()->json(['message' => 'Medicine Supplier Payment Added','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function supplierPaymentMedicineUpdate(Request $request)
    {

        $supplierpayment = $request->supplierpayment;
        $validator = Validator::make((array) $supplierpayment, [
            'id'                 => ['required', 'integer'],
            'transaction_number' => ['required','string',Rule::unique('supplier_payments')->ignore($supplierpayment['id'],'id')],
            'supplier_id'        => 'required|integer',
            'payment_date'       => 'required|date',
            'transaction_type'   => ['required', Rule::in(['Payment', 'Received'])],
            'payment_type'       => ['required', Rule::in(['Cash', 'Bank'])],
            'amount'             => 'required|numeric',
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
            $data->remark             = $supplierpayment['remark'];
            $data->use_for            = 'Medicine';
            $data->updated_by         = auth()->user()->id;
            $data->ip_address         = $request->ip();
            $data->branch_id          = session('branch_id');
            $data->save(); 
            


            DB::commit();
            return response()->json(['message' => 'Medicine Supplier Payment Updated','id'=> $data->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }

    public function supplierPaymentDeleteMedicine(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        
        try {
            SupplierPayment::where('id', $request->id)->delete();

            DB::commit();
            return response()->json(['message' => 'Medicine Supplier Payment Deleted']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 406);
        }
    }
    

}
