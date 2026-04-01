<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class BackupExport implements WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */


    protected $dbName;

    public function __construct($dbName)
    {
        $this->dbName = $dbName;
    }

    public function sheets(): array
    {
        $tdata =  [
            [
                "table" => "users",
                "query" => "SELECT users.`name`, `username`, `pass`, sites.name as site, roles.name as role, `pan_no`, users.`status`,`contact_no`, `mobile_only` FROM `users` INNER JOIN sites ON sites.id = users.site_id INNER JOIN roles ON roles.id = users.role_id",
                "headings" => ["Name", "Username", "Password","Site","Role","Pan No.","Status","Contact No.","Mobile Only User"],
                "sheet_name" => "Users Data"
            ],
            [
                "table" => "sites",
                "query" => "SELECT  sites.`name`, `address`, sites.`status`, `sites_type`, CASE WHEN sites.project_id = 0 THEN 'No Project' ELSE sales_project.name END FROM `sites` INNER JOIN sales_project ON sales_project.id = sites.project_id",
                "headings" => ["Name", "Address", "Status","Site Type","Project Name"],
                "sheet_name" => "Sites Data"
            ],
            [
                "table" => "roles",
                "query" => "SELECT  `name`, `is_superadmin`, `add_duration`, `view_duration`, `initial_entry_status`, `entry_at_site`, `visiblity_at_site` FROM `roles`",
                "headings" => ["Role Name","Is Super Admin","Add Duration","View Duration","Initial Entry Status","Entry At Site","Visibility At Site"],
                "sheet_name" => "User Roles Data"
            ],      
            [
                "table" => "sales_company",
                "query" => "SELECT  `name`, `address`, `phone`, `gst`, `state`, `state_code`, `status` FROM `sales_company`",
                "headings" => ["Name","Address","Phone","GST","State","State Code","Status"],
                "sheet_name" => "My Companies Info"
            ],       
            [
                "table" => "settings",
                "query" => "SELECT name,value FROM `settings`;",
                "headings" => ["Name","Value"],
                "sheet_name" => "Setting Data"
            ],   

             
                  
            [
                "table" => "site_payments",
                "query" => "SELECT  sites.name, `amount`, `remark`, `date` FROM `site_payments` INNER JOIN sites ON sites.id = site_payments.site_id ORDER BY sites.id",
                "headings" => ["Name","Amount","Remark","Date"],
                "sheet_name" => "Site Payments Data"
            ],           
            [
                "table" => "sites_transaction",
                "query" => "SELECT sites.name,type,CASE WHEN expense_id IS NOT NULL THEN expenses.amount  WHEN payment_id IS NOT NULL THEN site_payments.amount  WHEN payment_voucher_id IS NOT NULL THEN payment_vouchers.amount ELSE 0 END as `amount`,CASE WHEN expense_id IS NOT NULL THEN expenses.date  WHEN payment_id IS NOT NULL THEN site_payments.date  WHEN payment_voucher_id IS NOT NULL THEN payment_vouchers.date ELSE NULL END as `date`,CASE WHEN expense_id IS NOT NULL THEN CONCAT('Expense - ',expenses.particular)  WHEN payment_id IS NOT NULL THEN CONCAT('Payment Transfer - ',site_payments.remark)  WHEN payment_voucher_id IS NOT NULL THEN CONCAT('Payment Voucher Generated - ',payment_vouchers.remark) ELSE 'Unknown Transaction' END as `details` FROM `sites_transaction` LEFT JOIN sites ON sites.id = sites_transaction.site_id LEFT JOIN expenses ON expenses.id = sites_transaction.expense_id LEFT JOIN site_payments ON site_payments.id = sites_transaction.payment_id LEFT JOIN payment_vouchers ON payment_vouchers.id = sites_transaction.payment_voucher_id ORDER BY sites_transaction.site_id",
                "headings" => ["Site Name", "Transaction Type","Amount","Date","Transaction Details"],
                "sheet_name" => "Site Transactions Data"
            ],           

            [
                "table" => "expense_party",
                "query" => "SELECT expense_party.name,expense_party.address,expense_party.pan_no,sites.name as site_name,expense_party.status FROM `expense_party` INNER JOIN sites ON sites.id = expense_party.site_id",
                "headings" => ["Name","Address","Pan No.","Site Name","Status"],
                "sheet_name" => "Expense Party Data"
            ],      
            [
                "table" => "expense_head",
                "query" => "SELECT `name` FROM `expense_head`",
                "headings" => ["Name"],
                "sheet_name" => "Expense Head Data"
            ],   
            [
                "table" => "expenses",
                "query" => "SELECT sites.name as site_name,CASE WHEN expenses.party_type = 'expense' THEN expense_party.name WHEN expenses.party_type = 'bill' THEN bills_party.name END as party_name, expenses.`party_type`, expense_head.name as head_name, expenses.`particular`, expenses.`amount`, expenses.`remark`,  users.name as user_name, expenses.`status`, expenses.`location`, expenses.`date` FROM `expenses`  INNER JOIN expense_head ON expense_head.id = expenses.head_id INNER JOIN sites ON sites.id = expenses.site_id INNER JOIN users ON users.id = expenses.user_id LEFT JOIN expense_party ON expense_party.id = expenses.party_id LEFT JOIN bills_party ON bills_party.id = expenses.party_id ORDER BY expenses.site_id",
                "headings" => ["Site Name","Party Name","Party Type","Head Name","Particular","Amount","Remark","User","Status","Location","Date"],
                "sheet_name" => "Expense Record Data"
            ],

            [
                "table" => "material_supplier",
                "query" => "SELECT  `name`, `address`, `gstin`, `bank_ac`, `bank_ifsc`, `bank_name`, `bank_ac_holder`, `status` FROM `material_supplier`",
                "headings" => ["Name","Address","GST","Bank A/C","Bank IFSC","Bank Name","Bank A/C Holder","Status"],
                "sheet_name" => "Material Suplier List Data"
            ],           
            [
                "table" => "material_supplier_statement",
                "query" => "SELECT material_supplier.name as supplier, material_supplier_statement.`type`, CASE WHEN material_supplier_statement.payment_voucher_id IS NOT NULL THEN payment_vouchers.date WHEN entry_id IS NOT NULL THEN material_entry.date ELSE NULL END as `date`, CASE WHEN material_supplier_statement.payment_voucher_id IS NOT NULL THEN CONCAT('Payment Voucher - ',payment_vouchers.remark) WHEN entry_id IS NOT NULL THEN CONCAT('New Material Entry - ',material_entry.remark) ELSE 'Entry Not Found' END as `details`,CASE WHEN material_supplier_statement.payment_voucher_id IS NOT NULL THEN payment_vouchers.amount WHEN entry_id IS NOT NULL THEN material_entry.amount ELSE NULL END as `amount`  FROM `material_supplier_statement` INNER JOIN material_supplier ON material_supplier.id = material_supplier_statement.supplier_id LEFT JOIN material_entry ON material_entry.id = material_supplier_statement.entry_id LEFT JOIN payment_vouchers ON payment_vouchers.id = material_supplier_statement.payment_voucher_id ORDER BY material_supplier_statement.supplier_id",
                "headings" => ["Supplier","Transaction Type","Date","Details","Amount"],
                "sheet_name" => "Material Supplier Transactions Data"
            ],           
            [
                "table" => "material_entry",
                "query" => "SELECT  material_supplier.name as supplier_name, materials.name as material_name, material_entry.`unit`, material_entry.`qty`, material_entry.`vehical`, material_entry.`remark`, material_entry.`location`, sites.name as site_name, material_entry.`status`, users.name as user_name, material_entry.`rate`, material_entry.`amount`, material_entry.`tax`, material_entry.`bill_no`, material_entry.`date` FROM `material_entry` INNER JOIN material_supplier ON material_supplier.id = material_entry.supplier INNER JOIN materials ON materials.id = material_entry.material_id INNER JOIN sites ON sites.id = material_entry.site_id INNER JOIN users ON users.id = material_entry.user_id ORDER BY material_entry.site_id",
                "headings" => ["Supplier","Material","Unit","Qty","Vehical","Remark","Location","Site Name","Status","User Name","Rate","Amount","Tax","Bill No.","Date"],
                "sheet_name" => "Material Entries Data"
            ],           
            [
                "table" => "materials",
                "query" => "SELECT name FROM `materials`",
                "headings" => ["Material Name"],
                "sheet_name" => "Materials List Data"
            ],    
            [
                "table" => "units",
                "query" => "SELECT `name` FROM `units`",
                "headings" => ["Name"],
                "sheet_name" => "Material Units Data"
            ],

            [
                "table" => "bills_party",
                "query" => "SELECT  `name`, `address`, `panno`,`status`, `bank_ac`, `ifsc`, `bankname`,  `ac_holder_name` FROM `bills_party`",
                "headings" => ["Party Name","Address","Pan No.","Status","Bank A/C","Bank IFSC","Bank Name","Bank A/C Holder"],
                "sheet_name" => "Bills Party List Data"
            ],  

            [
                "table" => "new_bill_entry",
                "query" => "SELECT  new_bill_entry.`bill_no`,bills_party.name as party,  sites.name as site, new_bill_entry.`billdate`, new_bill_entry.`bill_period`, users.name as user, new_bill_entry.`location`, new_bill_entry.`status`, new_bill_entry.`amount`, new_bill_entry.`remark` FROM `new_bill_entry` INNER JOIN bills_party ON bills_party.id = new_bill_entry.party_id INNER JOIN sites ON sites.id = new_bill_entry.site_id INNER JOIN users ON users.id = new_bill_entry.user_id",
                "headings" => ["Bill No.","Party","Site","Date","Period","User","Location","Status","Amount","Remark"],
                "sheet_name" => "Site Bills Data"
            ],           
            [
                "table" => "new_bills_item_entry",
                "query" => "SELECT  new_bill_entry.bill_no,bills_work.name as work, new_bills_item_entry.`unit`, new_bills_item_entry.`rate`, new_bills_item_entry.`qty`, new_bills_item_entry.`amount` FROM `new_bills_item_entry` INNER JOIN new_bill_entry ON new_bill_entry.id = new_bills_item_entry.bill_id INNER JOIN bills_work ON bills_work.id = new_bills_item_entry.work_id ORDER BY new_bills_item_entry.bill_id",
                "headings" => ["Bill No.","Work Name","Unit","Rate","Qty","Amount"],
                "sheet_name" => "Site Bills Items Data"
            ],   
            [
                "table" => "bills_rate",
                "query" => "SELECT sites.name as site_name, bills_work.name as work_name, bills_rate.rate,bills_work.unit  FROM `bills_rate` INNER JOIN bills_work ON bills_work.id = bills_rate.work_id INNER JOIN sites ON sites.id = bills_rate.site_id ORDER BY bills_rate.site_id",
                "headings" => ["Site Name","Work Name","Rate","Unit"],
                "sheet_name" => "Site Bills Work Rate Data"
            ],           
         
            [
                "table" => "bill_party_payments",
                "query" => "SELECT bills_party.name as party, amount,remark,date FROM `bill_party_payments` INNER JOIN bills_party ON bills_party.id = bill_party_payments.party_id ORDER BY bill_party_payments.party_id",
                "headings" => ["Party Name","Amount","Remark","Date"],
                "sheet_name" => "Bills Party Direct Payment Data"
            ],   
            [
                "table" => "bill_party_statement",
                "query" => 'SELECT bills_party.name as party_name, bill_party_statement.`type`, bill_party_statement.`particular`, CASE WHEN bill_party_statement.bill_no IS NOT NULL THEN new_bill_entry.billdate WHEN bill_party_statement.expense_id IS NOT NULL THEN expenses.date WHEN bill_party_statement.payment_id IS NOT NULL THEN bill_party_payments.date WHEN bill_party_statement.payment_voucher_id IS NOT NULL THEN payment_vouchers.date ELSE NULL END as `date`, CASE WHEN bill_party_statement.bill_no IS NOT NULL THEN new_bill_entry.amount WHEN bill_party_statement.expense_id IS NOT NULL THEN expenses.amount WHEN bill_party_statement.payment_id IS NOT NULL THEN bill_party_payments.amount WHEN bill_party_statement.payment_voucher_id IS NOT NULL THEN payment_vouchers.amount ELSE NULL END as `amount`, CASE WHEN bill_party_statement.bill_no IS NOT NULL THEN CONCAT("Bill - ",new_bill_entry.bill_no) WHEN bill_party_statement.expense_id IS NOT NULL THEN CONCAT("Payment Via Expense - ",expenses.particular) WHEN bill_party_statement.payment_id IS NOT NULL THEN CONCAT("Direct Payment - ",bill_party_payments.remark) WHEN bill_party_statement.payment_voucher_id IS NOT NULL THEN CONCAT("Payment Voucher Generated - ",payment_vouchers.voucher_no) ELSE "Entry Not Found" END as `details` FROM `bill_party_statement` INNER JOIN bills_party ON bills_party.id = bill_party_statement.party_id LEFT JOIN new_bill_entry ON new_bill_entry.id = bill_party_statement.bill_no LEFT JOIN expenses ON expenses.id = bill_party_statement.expense_id LEFT JOIN bill_party_payments ON bill_party_payments.id = bill_party_statement.payment_id LEFT JOIN payment_vouchers ON payment_vouchers.id = bill_party_statement.payment_voucher_id  ORDER BY bill_party_statement.party_id',
                "headings" => ["Party Name", "Transaction Type","Particular","Date","Amount","Details"],
                "sheet_name" => "Bill Party Transactions Data"
            ],   
           

            [
                "table" => "machinery_head",
                "query" => "SELECT name FROM `machinery_head`",
                "headings" => ["Head"],
                "sheet_name" => "Machinery Head List Data"
            ],   
            [
                "table" => "machinery_details",
                "query" => "SELECT  machinery_details.`name` as machine_name,machinery_head.name as head_name, machinery_details.`status`, sites.name as site_name, `cost_price`, `sale_price` FROM `machinery_details` INNER JOIN machinery_head ON machinery_head.id = machinery_details.head_id INNER JOIN sites ON sites.id = machinery_details.site_id ORDER BY machinery_details.site_id",
                "headings" => ["Machine Name","Head Name","Status","Site Name","Cost Price","Sale Price"],
                "sheet_name" => "Machinery Details Data"
            ],   


            [
                "table" => "machinery_transaction",
                "query" => "SELECT machinery_details.name, CASE WHEN machinery_transaction.from_site IS NOT NULL THEN f_site.name ELSE '' END as from_site, CASE WHEN machinery_transaction.to_site IS NOT NULL THEN t_site.name ELSE '' END as to_site, machinery_transaction.`transaction_type`, machinery_transaction.`remark`, machinery_transaction.`create_datetime` FROM `machinery_transaction` INNER JOIN machinery_details ON machinery_details.id = machinery_transaction.machinery_id LEFT JOIN sites as f_site ON f_site.id = machinery_transaction.from_site LEFT JOIN sites as t_site ON t_site.id = machinery_transaction.to_site ORDER BY machinery_transaction.machinery_id",
                "headings" => ["Machine Name","From Site","To Site","Transaction Type","Remark","Date Time"],
                "sheet_name" => "Machinery Transaction Data"
            ],           
            [
                "table" => "machinery_services",
                "query" => "SELECT  machinery_details.name as machine, users.name as user_name, `maintainence_item`, `create_date`,  `next_service_on`, `remark` FROM `machinery_services` INNER JOIN machinery_details ON machinery_details.id = machinery_services.machinery_id INNER JOIN users ON users.id = machinery_services.user_id ORDER BY machinery_services.machinery_id",
                "headings" => ["Machine Name","User","Maintainence Items","Maintainence Date","Next Service On","Remark"],
                "sheet_name" => "Machinery Services Data"
            ],           
                   
            
            [
                "table" => "machinery_documents",
                "query" => "SELECT  machinery_details.name as machine_name, machinery_documents.`name` as doc_name, machinery_documents.`issue_date`, machinery_documents.`end_date`, machinery_documents.`remark` FROM `machinery_documents` INNER JOIN machinery_details ON machinery_details.id = machinery_documents.machinery_id ORDER BY machinery_id;",
                "headings" => ["Machine Name","Doc Name","Issue Date","End Date","Remark"],
                "sheet_name" => "Machinery Documents Data"
            ],           

        
            [
                "table" => "asset_head",
                "query" => "SELECT name FROM `asset_head`",
                "headings" => ["Asset Head Name"],
                "sheet_name" => "Assets Heads List"
            ],  
            [
                "table" => "assets",
                "query" => "SELECT assets.name as asset_name, asset_head.name as head_name,sites.name as sitename,assets.status, assets.cost_price, assets.sale_price FROM `assets` INNER JOIN asset_head ON asset_head.id = assets.head_id LEFT JOIN sites ON sites.id = assets.site_id ORDER BY assets.id",
                "headings" => ["Asset Name","Head Name","Site Name","Status","Cost Price","Sale Price"],
                "sheet_name" => "Assets Details Data"
            ],   
            [
                "table" => "asset_transaction",
                "query" => "SELECT assets.name, CASE WHEN asset_transaction.from_site IS NOT NULL THEN f_site.name ELSE '' END as from_site, CASE WHEN asset_transaction.to_site IS NOT NULL THEN t_site.name ELSE '' END as to_site, asset_transaction.`transaction_type`, asset_transaction.`remark`, asset_transaction.`create_datetime` FROM `asset_transaction` INNER JOIN assets ON assets.id = asset_transaction.asset_id LEFT JOIN sites as f_site ON f_site.id = asset_transaction.from_site LEFT JOIN sites as t_site ON t_site.id = asset_transaction.to_site ORDER BY asset_transaction.asset_id",
                "headings" => ["Asset Name","From Site","To Site","Transaction Type","Transaction Type","Remark","Date Time"],
                "sheet_name" => "Assets Transaction Data"
            ],   

            [
                "table" => "other_parties",
                "query" => "SELECT `name`, `panno`, `address`, `bank_ac`, `bank_name`, `bank_ac_holder`, `bank_ifsc`, `status` FROM `other_parties`",
                "headings" => ["Name","Pan No.","Address","Bank A/C","Bank Name","Bank A/C Holder","Bank IFSC","Status"],
                "sheet_name" => "Other Parties Data"
            ],           
            [
                "table" => "other_party_statement",
                "query" => "SELECT other_parties.name, `type`, payment_vouchers.amount,payment_vouchers.remark,payment_vouchers.date,payment_vouchers.voucher_no FROM `other_party_statement` INNER JOIN other_parties ON other_parties.id = other_party_statement.party_id INNER JOIN payment_vouchers ON payment_vouchers.id = other_party_statement.payment_voucher_id ORDER BY other_party_statement.party_id",
                "headings" => ["Party Name","Transaction Type","Amount","Details","Date","Voucher No."],
                "sheet_name" => "Other Parties Payment Data"
            ],      
            [
                "table" => "payment_vouchers",
                "query" => "SELECT pv.`voucher_no`, pv.`amount`, pv.`date`, sales_company.name as `company`, sites.name as `site`, pv.`party_type`, CASE WHEN pv.party_type = 'site' THEN p_site.name WHEN pv.party_type = 'material' THEN material_supplier.name WHEN pv.party_type = 'bill' THEN bills_party.name WHEN pv.party_type = 'other' THEN other_parties.name ELSE 'No Party Found' END as `party_name`, pv.`payment_details`, pv.`payment_date`, pv.`remark`, c_user.name as `created_by`, a_user.name as `approved_by`, p_user.name as `paid_by`, pv.`status` FROM `payment_vouchers` as pv INNER JOIN sales_company ON sales_company.id = pv.company_id INNER JOIN sites ON sites.id = pv.site_id INNER JOIN users as c_user ON c_user.id = pv.created_by INNER JOIN users as a_user ON a_user.id = pv.approved_by INNER JOIN users as p_user ON p_user.id = pv.paid_by LEFT JOIN sites as p_site ON p_site.id = pv.party_id LEFT JOIN material_supplier ON material_supplier.id = pv.party_id LEFT JOIN bills_party ON bills_party.id = pv.party_id LEFT JOIN other_parties ON other_parties.id = pv.party_id ORDER BY pv.party_id",
                "headings" => ["Voucher No.","Amount","Date","Company Name","Site Name","Party Type","Party Name","Payment Details","Payment Date","Remark","Created By","Approved By","Paid By","Status"],
                "sheet_name" => "Payment Vouchers Data"
            ],      

            [
                "table" => "sales_party",
                "query" => "SELECT name,address,phone,gst,state,state_code,status FROM `sales_party`",
                "headings" => ["Name","Address","Phone","GST","State","State Code","Status"],
                "sheet_name" => "Sales Party Data"
            ],      
            [
                "table" => "sales_project",
                "query" => "SELECT name,details,status FROM `sales_project`",
                "headings" => ["Name","Details","Status"],
                "sheet_name" => "Sales Projects Data"
            ],           
               
            [
                "table" => "sales_invoice",
                "query" => "SELECT sales_invoice.`invoice_no`,sales_invoice.`date` , sales_company.name as `company`,sales_project.name as `project`,sales_party.name as `party`,sales_invoice.`financial_year`,sales_invoice.`gst_rate`,sales_invoice.`taxable_value`,sales_invoice.`amount`,sales_invoice.`status`FROM `sales_invoice` INNER JOIN sales_company ON sales_company.id = sales_invoice.company_id INNER JOIN sales_project ON sales_project.id = sales_invoice.project_id INNER JOIN sales_party ON sales_party.id = sales_invoice.party_id",
                "headings" => ["Invoice No.","Date","Company","Project","Party","Financial Year","GST Rate","Taxable Value","Amount","Status"],
                "sheet_name" => "Sales Invoice Data"
            ],           
            [
                "table" => "sales_manage_invoice",
                "query" => "SELECT sales_invoice.invoice_no,sales_dedadd.name,CASE WHEN sales_dedadd.type = 'ded' THEN 'Deduction' ELSE 'Addition' END,sales_manage_invoice.amount,sales_manage_invoice.date FROM `sales_manage_invoice` INNER JOIN sales_invoice ON sales_invoice.id = sales_manage_invoice.invoice_id INNER JOIN sales_dedadd ON sales_dedadd .id = sales_manage_invoice.type_id ORDER BY invoice_id",
                "headings" => ["Invoice No.","Head Name","Transaction Type","Amount","Date"],
                "sheet_name" => "Sales Invoice Transactions Data"
            ],           
                 
  
              
             
                    
         
            [
                "table" => "doc_head",
                "query" => "SELECT name FROM `doc_head`",
                "headings" => ["Head Name"],
                "sheet_name" => "Documents Head List"
            ],   
            [
                "table" => "doc_head_option",
                "query" => "SELECT doc_head.name as head_name, doc_head_option.name as option_name FROM `doc_head_option` INNER JOIN doc_head ON doc_head.id = doc_head_option.head_id ORDER BY doc_head_option.head_id",
                "headings" => ["Head Name","Option Name"],
                "sheet_name" => "Documents Head Option List"
            ],     
            [
                "table" => "doc_upload",
                "query" => "SELECT doc_upload.`name`, doc_upload.`date`, doc_upload.`particular`, doc_upload.`remark`, users.name as user, doc_upload.`status` FROM `doc_upload` INNER JOIN users ON users.id = doc_upload.created_by",
                "headings" => ["Document","Date","Particular","Remark","User","Status"],
                "sheet_name" => "Documents Uploaded Data"
            ],   
     
            [
                "table" => "contact_profile",
                "query" => "SELECT comp_name,contact_name,mobile,email,category FROM `contact_profile`",
                "headings" => ["Company Name","Contact Name","Mobile","Email","Category"],
                "sheet_name" => "Contact Profiles Data"
            ],      
            [
                "table" => "contact",
                "query" => "SELECT contact_profile.comp_name as compName, contact.name as contact, contact.`phone`, contact.`email`, contact.`position` FROM `contact` INNER JOIN contact_profile ON contact_profile.id = contact.profile_id ORDER BY contact.profile_id",
                "headings" => ["Company Name","Contact Name","Mobile","Email","Position"],
                "sheet_name" => "Contact Data"
            ]
           
         
        ];
        $sheets = [];
        foreach ($tdata as $table) {
            $sheets[] = new TableSheetExport($this->dbName, $table['headings'], $table['query'], $table['sheet_name']);
        }

        return $sheets;
    }
}
