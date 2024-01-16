@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')
@section('body')

@php 
 $role = auth()->user()->role;
 $permissions = auth()->user()->permissions;
 $module = session()->has('module') ? session('module') : '';
 $branch_id = session()->has('branch_id') ? session('branch_id') : auth()->user()->branch_id;
 $all_access_role = ['Super Admin', 'Admin'];
 $doctor_role = ['Doctor'];
@endphp

@if($module == 'Dashboard' || $module == '')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="col-md-12 header" style="height: 130px;">
            <img src="{{asset('assets/img/hospital-management-logo.png')}}" class="img img-responsive center-block">
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#e1e1ff;" onmouseover="this.style.background = '#d2d2ff'" onmouseout="this.style.background = '#e1e1ff'">
                    <a href="{{route('module', 'FrontDesk')}}">
                        <div class="logo">
                            <i class="fa fa-hospital-o"></i>
                        </div>
                        <div class="textModule">
                            Front Desk
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#dcf5ea;" onmouseover="this.style.background = '#bdecd7'" onmouseout="this.style.background = '#dcf5ea'">
                    <a href="{{route('module', 'Doctor')}}">
                        <div class="logo">
                            <i class="fa fa-user-md"></i>
                        </div>
                        <div class="textModule">
                            Doctor Module
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#e1e1ff;" onmouseover="this.style.background = '#d2d2ff'" onmouseout="this.style.background = '#e1e1ff'">
                    <a href="{{route('module', 'Pathology')}}">
                        <div class="logo">
                            <i class="fa fa-stethoscope"></i>
                        </div>
                        <div class="textModule">
                            Pathology Module
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#dcf5ea;" onmouseover="this.style.background = '#bdecd7'" onmouseout="this.style.background = '#dcf5ea'">
                    <a href="{{route('module', 'Inventory')}}">
                        <div class="logo">
                            <i class="fa fa-cubes"></i>
                        </div>
                        <div class="textModule">
                            Inventory Module
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#c6e2ff;" onmouseover="this.style.background = '#91c8ff'" onmouseout="this.style.background = '#c6e2ff'">
                    <a href="{{route('module', 'Accounts')}}">
                        <div class="logo">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="textModule">
                            Accounts Module
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#e1e1ff;" onmouseover="this.style.background = '#d2d2ff'" onmouseout="this.style.background = '#e1e1ff'">
                    <a href="{{route('module', 'HRPayroll')}}">
                        <div class="logo">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="textModule">
                            HR & Payroll Module
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#A7ECFB;" onmouseover="this.style.background = '#A7ECFB'" onmouseout="this.style.background = '#ecffd9'">
                    <a href="{{route('module', 'Pharmacy')}}">
                        <div class="logo">
                            <i class="fa fa-medkit"></i>
                        </div>
                        <div class="textModule">
                            Pharmacy Module
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#c6e2ff;" onmouseover="this.style.background = '#91c8ff'" onmouseout="this.style.background = '#c6e2ff'">
                    <a href="{{route('module', 'Reports')}}">
                        <div class="logo">
                            <i class="fa fa-calendar-check-o"></i>
                        </div>
                        <div class="textModule">
                            Reports Module
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#e1e1ff;" onmouseover="this.style.background = '#d2d2ff'" onmouseout="this.style.background = '#e1e1ff'">
                    <a href="{{route('module', 'Others')}}">
                        <div class="logo">
                            <i class="fa fa-snowflake-o"></i>
                        </div>
                        <div class="textModule">
                            Others Module
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#A7ECFB;" onmouseover="this.style.background = '#A7ECFB'" onmouseout="this.style.background = '#ecffd9'">
                    <a href="{{route('module', 'Doctor')}}">
                        <div class="logo">
                            <i class="fa fa-cogs"></i>
                        </div>
                        <div class="textModule">
                            Administration
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#e1e1ff;" onmouseover="this.style.background = '#d2d2ff'" onmouseout="this.style.background = '#e1e1ff'">
                    <a href="{{route('module', 'Doctor')}}">
                        <div class="logo">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                        <div class="textModule">
                            Business Monitor
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-xs-6 section4">
                <div class="col-md-12 section122" style="background-color:#A7ECFB;" onmouseover="this.style.background = '#A7ECFB'" onmouseout="this.style.background = '#ecffd9'">
                    <form id="logout_form" method="POST" action="{{ route('logout') }}">
                        @csrf
                    </form>
                    <a href="javascript:" onclick="event.preventDefault();$('#logout_form').submit();">
                        <div class="logo">
                            <i class="fa fa fa-power-off"></i>
                        </div>
                        <div class="textModule">
                           Logout
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

@elseif($module == 'FrontDesk')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- Header Logo -->
            <div class="col-md-12 header">
                <h3> FrontDesk Module </h3>
            </div>
            @if (array_search("outdoor_patient", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('outdoor_patient')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-user-circle-o"></i>
                            </div>
                            <div class="textModule">
                                Outdoor Patient
                            </div>
                        </a>
                    </div>
                </div>
           @endif
        @if(array_search("patient_admission", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('patient_admission')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-user-circle-o"></i>
                            </div>
                            <div class="textModule">
                                Patient Admission
                            </div>
                        </a>
                    </div>
                </div>
           @endif
        @if(array_search("patient_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('patient_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-user-plus"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Patient Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif
        @if(array_search("patient_list", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('patient_list')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Patient List</span>
                            </div>
                        </a>
                    </div>
                </div>
        @endif
        @if(array_search("bill_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('bill_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-file-text-o"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Bill Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
        @endif
        @if(array_search("seat_shift", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('seat_shift')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-exchange"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Seat Shift</span>
                            </div>
                        </a>
                    </div>
                </div>
        @endif
        @if(array_search("seat_status", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('seat_status')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list-alt"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Seat Status</span>
                            </div>
                        </a>
                    </div>
                </div>
        @endif
        @if(array_search("slip_bill_search", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('slip_bill_search')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-search"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 11px;">  Release Slip Search</span>
                            </div>
                        </a>
                    </div>
                </div>
        @endif
        @if(array_search("slip_bill_payment_search", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('slip_bill_payment_search')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-bars"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"  style="font-size: 10.5px;">  Release Slip Payment</span>
                            </div>
                        </a>
                    </div>
                </div>
        @endif
        @if(array_search("release_slip_record", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('release_slip_record')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list-alt"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"  style="font-size: 11px;">   Release Slip Record</span>
                            </div>
                        </a>
                    </div>
                </div>
        @endif
        @if(array_search("billtype_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('billtype_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-cog"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">  Bill Type Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
        @endif
        @if(array_search("appointment_report", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('appointment_report')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list-alt"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 11px;">  Appointment Report</span>
                            </div>
                        </a>
                    </div>
                </div>
        @endif
            
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
@elseif($module == 'Doctor')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- Header Logo -->
            <div class="col-md-12 header">
                <h3> Doctor Module </h3>
            </div>
            @if(auth()->user()->role == 'Doctor')
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('prescription')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa fa-file"></i>
                            </div>
                            <div class="textModule">
                                Prescription Entry
                            </div>
                        </a>
                    </div>
                </div>
           @endif
           @if(auth()->user()->role == 'Doctor')
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('prescription_record')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule" style="font-size: 11px;">
                                Prescription Record
                            </div>
                        </a>
                    </div>
                </div>
           @endif
           @if(auth()->user()->role == 'Doctor')
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('dose_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-check-circle-o"></i>
                            </div>
                            <div class="textModule">
                                Dose Entry
                            </div>
                        </a>
                    </div>
                </div>
           @endif
           @if(auth()->user()->role == 'Doctor')
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('duration_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-clock-o"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Duration Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif
           @if(auth()->user()->role == 'Doctor')
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('cheif_complain_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-creative-commons"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Cheif Complains</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif
           @if(auth()->user()->role == 'Doctor')
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('advice_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-adn"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Advice Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif
           @if(auth()->user()->role == 'Doctor')
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('doctor_appointment_list')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Appointment List</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif
           @if(auth()->user()->role == 'Doctor')
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="#">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Prescription List</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif
            @if (array_search("doctor_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('doctor_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-user-circle-o"></i>
                            </div>
                            <div class="textModule">
                                Doctor Entry
                            </div>
                        </a>
                    </div>
                </div>
           @endif
        
            
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->

@elseif($module == 'Pathology')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- Header Logo -->
            <div class="col-md-12 header">
                <h3> Pathology Module </h3>
            </div>
            @if (array_search("test_receipt", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('test_receipt')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-cubes"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Test Receipt</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
            @if (array_search("test_receipt_record", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('test_receipt_record')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 11px">Test Receipt Record</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("test_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('test_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-stethoscope"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Test Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
@elseif($module == 'Inventory')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- Header Logo -->
            <div class="col-md-12 header">
                <h3> Inventory Module </h3>
            </div>
            @if (array_search("issue_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('test_receipt')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-file"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Issue Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
            @if (array_search("issue_inventory_record", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('issue_inventory_record')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Issue Record</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("issue_invoice_search", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('issue_invoice_search')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Issue Invoice</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("purchase_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('purchase_inventory')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-shopping-cart"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Purchase Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("purchase_inventory_record", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('purchase_inventory_record')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Purchase Record</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("purchase_invoice_search", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('purchase_invoice_search')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-search"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Purchase Invoice</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("purchase_return_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('purchase_return_inventory')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-rotate-right"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Purchase Returns</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("purchase_return_inventory_record", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('purchase_return_inventory_record')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-history"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 11px">Pur. Return Record</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("damage_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('damage_inventory')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-retweet"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Damage Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("damage_inventory_list", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('damage_inventory_list')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Damage List</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("supplier_due_list", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('supplier_due_list')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Due List</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif         
           @if (array_search("supplier_payment_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('supplier_payment_inventory')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-money"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 9px"> Supplier Due Collection</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif    
           @if (array_search("instrument_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('instrument_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list-alt"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Instrument Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("current_stock_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('current_stock_inventory')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-cubes"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Stock Report</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("supplier_inventory_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('supplier_inventory_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list-alt"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 9px">  Supplier Inventory Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("category_entry_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('category_entry_inventory')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 11px"> Inventory Category</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("unit_entry_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('unit_entry_inventory')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list-alt"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 11px"> Inventory Unit</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("unit_entry_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('unit_entry_inventory')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list-alt"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 11px"> Inventory Unit</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->

@elseif($module == 'Accounts')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- Header Logo -->
            <div class="col-md-12 header">
                <h3> Accounts Module </h3>
            </div>
            @if (array_search("cash_transaction_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('cash_transaction_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-money"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Cash Transection</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
            @if (array_search("", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="#">
                            <div class="logo">
                                <i class="menu-icon fa fa-money"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 10px"> Commission Payment</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
            @if (array_search("bank_transaction_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('cash_transaction_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-bank"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Bank Transection</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
            @if (array_search("", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="#">
                            <div class="logo">
                                <i class="menu-icon fa fa-money"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Due Collection</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
                       
            @if (array_search("cash_view_report", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('cash_view_report')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-money"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Cash View</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
            @if (array_search("account_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('account_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-align-right"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 10px">Transaction Accounts</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
            @if (array_search("bank_account_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('bank_account_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-align-justify"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 10px">Transaction Accounts</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("cash_transaction_report", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('cash_transaction_report')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-cube"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 9px">Cash Transaction Report</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("bank_transaction_report", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('bank_transaction_report')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-bank"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 9px">Bank Transaction Report</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("cash_ledger_report", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('cash_ledger_report')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-file-text"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Cash Ledger</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
           @if (array_search("bank_ledger_report", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('bank_ledger_report')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-file-text"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Bank Ledger</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif            
            
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
@elseif($module == 'HRPayroll')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- Header Logo -->
            <div class="col-md-12 header">
                <h3> HR & Payroll Module </h3>
            </div>
            @if (array_search("salary_payment", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('salary_payment')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-money"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Salary Payment</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif           
            @if (array_search("employee_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('employee_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-users"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Add Employee</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif           
            @if (array_search("designation_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('designation_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-binoculars"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Add Designation</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif           
            @if (array_search("department_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('department_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-plus-square"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Add Department</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif           
            @if (array_search("month_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('month_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-calendar"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Add Month</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif           
            @if (array_search("employee_list", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('employee_list')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-user-circle-o"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> All Employee List</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif           
            @if (array_search("employee_active_list", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('employee_active_list')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-address-card"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 9px;"> Active Employee List</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif           
            @if (array_search("employee_deactive_list", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('employee_deactive_list')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-address-card-o"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 9px;"> Deactive Employee List</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif           
            @if (array_search("salary_payment_report", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('salary_payment_report')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-braille"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 9px;">  Salary Payment Report</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif           
            
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
@elseif($module == 'Pharmacy')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- Header Logo -->
            <div class="col-md-12 header">
                <h3> Pharmacy Module </h3>
            </div>
            @if (array_search("sale_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('sale_medicine')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-file"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Sale Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("sale_medicine_record", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('sale_medicine_record')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list-alt"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Sale Record</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("sale_medicine_invoice", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('sale_medicine_invoice')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-search"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Sale Invoice</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("sale_return_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('sale_return_medicine')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-mail-forward"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">  Sale Return Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("sale_return_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('sale_return_medicine')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">   Sale Return Record</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("purchase_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('purchase_medicine')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-file"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Purchase Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("purchase_medicine_record", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('purchase_medicine_record')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list-alt"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Purchase Record</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif         
           @if (array_search("purchase_medicine_invoice", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('purchase_medicine_invoice')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-search"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">  Purchase Invoice</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("purchase_return_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('purchase_return_medicine')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-mail-reply"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">  Purchase Return Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("purchase_return_medicine_record", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('purchase_return_medicine_record')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Purchase Return Record</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("damage_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('damage_medicine')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-file-o"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Damage Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("damage_medicine_list", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('damage_medicine_list')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list-ul"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Damage Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
               
           @if (array_search("medicine_current_stock", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('medicine_current_stock')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Stock</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("supplier_payment_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('supplier_payment_medicine')}}" style="font-size:10px">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Supplier Due Collection</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
               
           @if (array_search("medicine_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('medicine_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-book"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Medicine Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("supplier_pharmacy_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('supplier_pharmacy_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-users"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Medicine Supplier Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("category_entry_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('category_entry_medicine')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-bookmark"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">  Medicine Category</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("unit_entry_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('unit_entry_medicine')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-balance-scale"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">  Medicine Unit</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("brand_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('brand_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-bold"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">  Brand Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
           @if (array_search("generic_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('generic_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-ge"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">  Generic Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif          
            
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
@elseif($module == 'Others')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- Header Logo -->
            <div class="col-md-12 header">
                <h3> Others Module </h3>
            </div>
              
           @if (array_search("", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="#">
                            <div class="logo">
                                <i class="menu-icon fa fa-usd"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> ICU</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
           @if (array_search("ambulance_bill", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('ambulance_bill')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-ambulance"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Ambulance Bill</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
          
           @if (array_search("ambulance_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('ambulance_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-file"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Ambulance Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
           @if (array_search("driver_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('driver_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-user"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">  Driver Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
           @if (array_search("ot_schedule_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('ot_schedule_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-file-o"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Schedule Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
           @if (array_search("ot_schedule_pending_list", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('ot_schedule_pending_list')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-question-circle"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">Pending Schedule</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
           @if (array_search("ot_schedule_complete_list", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('ot_schedule_complete_list')}}">
                            <div class="logo">
                                <i class="menu-icon fa  fa-check-circle"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text" style="font-size: 11px;">Complete Schedule</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   

        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
@elseif($module == 'Administration')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- Header Logo -->
            <div class="col-md-12 header">
                <h3> Administration Module </h3>
            </div>
              
           @if (array_search("agent_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('agent_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-user"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Agent Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
           @if (array_search("floor_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('floor_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-building-o"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Floor Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   

           @if (array_search("room_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('room_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-bank"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Room Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
           @if (array_search("seat_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('seat_entry')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-bed"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Seat Entry</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
           @if (array_search("company_profile", $permissions) > -1  && $branch_id == 1)
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('company_profile')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-bed"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Company Profile</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
           @if (in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('register')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-plus"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">  Create User </span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
           @if ($role == 'Super Admin' && $branch_id == 1)
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('user_activity')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-list"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text">  User Activity</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   
           @if (array_search("database_backup", $permissions) > -1 || in_array($role, $all_access_role))
                <div class="col-md-2 col-xs-6 ">
                    <div class="col-md-12 section20">
                        <a href="{{route('database_backup')}}">
                            <div class="logo">
                                <i class="menu-icon fa fa-database"></i>
                            </div>
                            <div class="textModule">
                                <span class="menu-text"> Database Backup</span>
                            </div>
                        </a>
                    </div>
                </div>
           @endif   

        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endif

@endsection

@push('css')
@include('partials.dashboard_style')
@endpush