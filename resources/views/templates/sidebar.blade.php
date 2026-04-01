<div class="overlay"></div>
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <div class="image"><a href="{{url('/dashboard')}}"><img src="{{ asset('/' . Session::get('image')) }}" alt="User"></a></div>
                    <div class="detail">
                        <h4>{{Session::get('name')}}</h4>
                        <small>{{getRoleDetailsById(Session::get('role'))->name}}</small>                        
                    </div>
                    <a href="{{url('/dashboard')}}" title="Events"><i class="zmdi zmdi-home"></i></a>
                    <a href="{{url('/contacts')}}" title="Contact List"><i class="zmdi zmdi-account-box-phone"></i></a>
                    <a href="{{url('/file-structure')}}" title="Chat App"><i class="zmdi zmdi-folder-star"></i></a>
                    <a href="{{url('/activity')}}" title="Chat App"><i class="zmdi zmdi-chart"></i></a>
                   
                </div>
            </li>
            <li class="header">MAIN</li>
            <li class="active open"><a href="{{url('/dashboard')}}"><i class="zmdi zmdi-view-dashboard"></i><span>Dashboard</span></a></li> 

            {{-- Module 1: Sites & Users --}}
            @if (canViewModule(1))
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-city"></i><span>Sites & Users</span> </a>
                <ul style="list-style-type: none; display:none;">
                    <li><a href="{{url('/users')}}"> <i class="zmdi zmdi-face"></i> Users</a></li>
                    <li><a href="{{url('/sites')}}"> <i class="zmdi zmdi-city"></i> Sites</a></li>
                    <li><a href="{{url('/user_roles')}}"> <i class="zmdi zmdi-accounts-list"></i> Roles</a></li>
                   
                </ul>
            </li>
            @endif

            {{-- Module 2: Expenses --}}
            @if (canViewModule(2))
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-receipt"></i><span>Expenses</span> </a>
                <ul style="list-style-type: none; display:none;">
                    <li><a href="{{url('/expense_party')}}"> <i class="zmdi zmdi-face"></i> Expense Parties</a></li>
                    <li><a href="{{url('/expense_head')}}"> <i class="zmdi zmdi-puzzle-piece"></i> Expense Head</a></li>
                    @if (isSuperAdmin() || checkmodulepermission(2, 'can_add') == 1)
                    <li><a href="{{url('/new_expense')}}"> <i class="zmdi zmdi-plus-circle"></i> New Expenses</a></li>
                    @endif
                    <li><a href="{{url('/pending_expense')}}"> <i class="zmdi zmdi-dot-circle"></i> Pending Expense</a></li>
                    <li><a href="{{url('/verified_expense')}}"> <i class="zmdi zmdi-check-circle"></i> Verified Expense</a></li>
                    @if (isSuperAdmin() || checkmodulepermission(2, 'can_report') == 1)
                    <li><a href="{{url('/expense_reports')}}"> <i class="zmdi zmdi-chart"></i> Reports</a></li>                   
                    @endif
                </ul>
            </li>
            @endif

            {{-- Module 3: Material Purchase --}}
            @if (canViewModule(3))
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-landscape"></i><span>Material Purchase</span> </a>
                <ul style="list-style-type: none; display:none;">
                    <li><a href="{{url('/materialsupplier')}}"> <i class="zmdi zmdi-face"></i> Material Suppliers</a></li>
                    <li><a href="{{url('/material')}}"> <i class="zmdi zmdi-landscape"></i> Materials</a></li>
                    <li><a href="{{url('/materialunit')}}"> <i class="zmdi zmdi-ruler"></i> Units</a></li>
                    @if (isSuperAdmin() || checkmodulepermission(3, 'can_add') == 1)
                    <li><a href="{{url('/new_material')}}"> <i class="zmdi zmdi-plus-circle"></i> New Materials Entry</a></li>
                    @endif
                    <li><a href="{{url('/pending_material')}}"> <i class="zmdi zmdi-dot-circle"></i> Pending Materials Entry</a></li>
                    <li><a href="{{url('/verified_material')}}"> <i class="zmdi zmdi-check-circle"></i> Verified Materials Entry</a></li>

                    @if (isSuperAdmin() || checkmodulepermission(3, 'can_report') == 1)
                    <li><a href="{{url('/materials_report')}}"> <i class="zmdi zmdi-chart"></i>Reports</a></li>
                    @endif

                </ul>

            </li>
            @endif

            {{-- Module 3 (Stock): Manage Stock uses same module_id as Material --}}
            @if (canViewModule(3))
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-landscape"></i><span>Manage Stock</span> </a>
                <ul style="list-style-type: none; display:none;">
                    <li><a href="{{url('/stock_dashboard')}}"> <i class="zmdi zmdi-landscape"></i> Stock Dashboard</a></li>

                    @if (isSuperAdmin() || checkmodulepermission(3, 'can_add') == 1)
                    <li><a href="{{url('/new_consumption')}}"> <i class="zmdi zmdi-plus-circle"></i> New Consumption / Wastage</a></li>
                    @endif
                    <li><a href="{{url('/pending_consumption')}}"> <i class="zmdi zmdi-dot-circle"></i> Pending Consumption / Wastage</a></li>
                    <li><a href="{{url('/verified_consumption')}}"> <i class="zmdi zmdi-check-circle"></i> Verified Consumption / Wastage</a></li>

                    <li><a href="{{url('/stock_site_transfer')}}"> <i class="zmdi zmdi-arrow-split"></i> Stock Site Transfer</a></li>
                    <li><a href="{{url('/stock_unit_conversion')}}"> <i class="zmdi zmdi-swap"></i> Stock Unit Conversion</a></li>

                    <li><a href="{{url('/reconsilation_list')}}"> <i class="zmdi zmdi-shape"></i> Stock Reconsilation</a></li>
                </ul>

            </li>
            @endif

            {{-- Module 4: Site Bills --}}
            @if (canViewModule(4))
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-collection-text"></i><span>Site Bills</span> </a>
                <ul style="list-style-type: none; display:none;">
                    <li><a href="{{url('/billparty')}}"> <i class="zmdi zmdi-face"></i> Bill Parties</a></li>
                    <li><a href="{{url('/billwork')}}"> <i class="zmdi zmdi-shape"></i> Works</a></li>
                    <li><a href="{{url('/billrate')}}"> <i class="zmdi zmdi-money-box"></i> Works Rate</a></li>
                    @if (isSuperAdmin() || checkmodulepermission(4, 'can_add') == 1)
                    <li><a href="{{url('/new_bill')}}"> <i class="zmdi zmdi-plus-circle"></i> New Bill</a></li>
                    @endif
                    <li><a href="{{url('/pending_bill')}}"> <i class="zmdi zmdi-dot-circle"></i> Pending Bills</a></li>
                    <li><a href="{{url('/verified_bill')}}"> <i class="zmdi zmdi-check-circle"></i> Verified Bills</a></li>
                    @if (isSuperAdmin() || checkmodulepermission(4, 'can_report') == 1)
                    <li><a href="{{url('/bill_report')}}"> <i class="zmdi zmdi-chart"></i>Reports</a></li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- Module 6: Machinery --}}
            @if (canViewModule(6))
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-truck"></i><span>Machinery</span> </a>
                <ul style="list-style-type: none; display:none;">
                   
                    <li><a href="{{url('/machinery_head')}}"> <i class="zmdi zmdi-truck"></i> Machineries</a></li>
                    <li><a href="{{url('/machinery_expense_head')}}"> <i class="zmdi zmdi-shape"></i> Machinery's Expense Head</a></li>
                    @if (isSuperAdmin() || checkmodulepermission(6, 'can_report') == 1)
                    <li><a href="{{url('/machinery_report')}}"> <i class="zmdi zmdi-chart"></i> Reports</a></li>
                    @endif
              
                </ul>
            </li>
            @endif

            {{-- Module 5: Assets --}}
            @if (canViewModule(5))
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-wrench"></i><span>Assets</span> </a>
                <ul style="list-style-type: none; display:none;">
                    <li><a href="{{url('/asset_head')}}"> <i class="zmdi zmdi-wrench"></i> Assets</a></li>
                    <li><a href="{{url('/asset_expense_head')}}"> <i class="zmdi zmdi-shape"></i> Asset's Expense Head</a></li>
                    @if (isSuperAdmin() || checkmodulepermission(5, 'can_report') == 1)
                    <li><a href="{{url('/assets_report')}}"> <i class="zmdi zmdi-chart"></i>Reports</a></li>
                  
                    @endif
                </ul>
            </li>
            @endif

            {{-- Module 7: Sales --}}
            @if (canViewModule(7))
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-city"></i><span>Sales</span> </a>
                <ul style="list-style-type: none; display:none;">
                    <li><a href="{{url('/sales_inv_head')}}"> <i class="zmdi zmdi-exposure"></i> Invoice Heads</a></li>
                    <li><a href="{{url('/sales_parties')}}"> <i class="zmdi zmdi-face"></i> Sales Party</a></li>
                    <li><a href="{{url('/sales_project')}}"> <i class="zmdi zmdi-city"></i> Projects</a></li>
                    <li><a href="{{url('/all_sales_invoice')}}"> <i class="zmdi zmdi-collection-text"></i> All Sale Invoice</a></li>
                    @if (isSuperAdmin() || checkmodulepermission(7, 'can_report') == 1)
                    <li><a href="{{url('/sales_report')}}"> <i class="zmdi zmdi-chart"></i> Reports</a></li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- Module 8: Payment Vouchers --}}
            @if (canViewModule(8))
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-balance-wallet"></i><span>Payment Vouchers</span> </a>
                <ul style="list-style-type: none; display:none;">
                    <li><a href="{{url('/new_paymentvoucher')}}"> <i class="zmdi zmdi-plus-circle"></i>Generate Voucher</a></li>
                    <li><a href="{{url('/pending_paymentvoucher')}}"> <i class="zmdi zmdi-dot-circle"></i> Pending Voucher</a></li>
                    <li><a href="{{url('/verified_paymentvoucher')}}"> <i class="zmdi zmdi-check-circle"></i> Verified Voucher</a></li>
                    <li><a href="{{url('/paid_paymentvoucher')}}"> <i class="zmdi zmdi-balance-wallet"></i> Paid Voucher</a></li>
                    <li><a href="{{url('/otherparty')}}"> <i class="zmdi zmdi-face"></i> Other Parties</a></li>
                    @if (isSuperAdmin() || checkmodulepermission(8, 'can_report') == 1)
                    <li><a href="{{url('/payment_report')}}"> <i class="zmdi zmdi-chart"></i> Reports</a></li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- Module 11: Document Management --}}
            @if (canViewModule(11))
            <li class=" open"><a href="{{url('/file-structure')}}"><i class="zmdi zmdi-folder-star"></i><span>Document Management</span></a></li> 
            @endif

            {{-- Module 10: Contact Management --}}
            @if (canViewModule(10))
            <li class=" open"><a href="{{url('/contacts')}}"><i class="zmdi zmdi-account-box-phone"></i><span>Contact Management</span></a></li> 
            @endif

            {{-- Module 9: Management/Settings - SuperAdmin or can_view --}}
            @if (canViewModule(9))
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-settings"></i><span>Management</span> </a>
                <ul style="list-style-type: none; display:none;">
                    <li><a href="{{url('/settings')}}"> <i class="zmdi zmdi-settings"></i> Settings</a></li>
                    <li><a href="{{url('/sales_companies')}}"> <i class="zmdi zmdi-city"></i> My Companies</a></li>
                    <li><a href="{{url('/activity')}}"> <i class="zmdi zmdi-chart"></i> System Activity</a></li>

                    {{-- <li><a href="{{url('/management_report')}}"> <i class="zmdi zmdi-city"></i>Reports</a></li> --}}
                    
                </ul>
            </li>
            @endif
         </ul>
    </div>
</aside>
<!-- Right Sidebar -->
@if (isSuperAdmin() || checkmodulepermission(9, 'can_edit') == 1)

<aside id="rightsidebar" class="right-sidebar">
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#setting"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active slideRight" id="setting">
            <div class="slim_scroll">
                <div class="card">
                    <h6>Skins</h6>
                    <form method="post" action="{{url('/changecolor')}}" enctype="multipart/form-data">
                        @csrf
                        <label for="primary_color">Primary Color</label>&nbsp;
                    <input type="color" name="primary_color" value="{{Session::get('primary_color')[0]}}" id="primary_color">
                    <br>
                    <label for="secondry_color">Secondry Color</label>&nbsp;
                    <input type="color" name="secondry_color" value="{{Session::get('secondry_color')[0]}}" id="secondry_color">
                    <br>
                    <label for="gradient_start">Gradient Start</label>&nbsp;
                    <input type="color" name="gradient_start" value="{{Session::get('gradient_start')[0]}}" id="gradient_start">
                    <br>
                    <label for="gradient_end">Gradient End</label>&nbsp;
                    <input type="color" name="gradient_end" value="{{Session::get('gradient_end')[0]}}" id="gradient_end">
                    <br>
                    <button type="submit" class="btn btn-primary btn-simple btn-round waves-effect"><a >Submit</a></button>
                    </form>
                </div>
                <div class="card">
                    <h6>Left Menu</h6>
                    <ul class="list-unstyled theme-light-dark">
                        <li>
                            <div class="t-light btn btn-default btn-simple btn-round">Light</div>
                        </li>
                        <li>
                            <div class="t-dark btn btn-default btn-round">Dark</div>
                        </li>
                    </ul>
                </div>
               
            </div>                
        </div>       
        
    </div>
</aside>
@endif