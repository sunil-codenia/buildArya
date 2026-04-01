<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="card">
        <div class="header">
            <h2><strong>Sales </strong> Invoices
             
            </h2>
        </div>
        <div class="body" id="site_sales_chart_div">
            @php
            $data =get_site_sales_invoices_chart_data($id);
            @endphp
             <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
            <h5>Complete Data</h5>
            <h6>Base Sales - {{$data['base']}}</h6>
            <h6>GST - {{$data['tax']}}</h6>
            <h6>Total Sales - {{$data['amount']}}</h6>
                </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div id="sales_invoice_donut_chart" style="height:200px;"></div>

            </div>
             </div>

            <div id="site_sales_chart" class="graph"></div>
        </div>
    </div>
</div>