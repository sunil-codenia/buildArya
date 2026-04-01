<div class="card">
    <div class="header">
        <h2><strong>Company Bills</strong> Report</h2>
    </div>
    @php $data = get_company_site_bill_area_chart_widget_data($from ?? null, $to ?? null);
    $workdata = get_company_site_bills_area_chart_work_table($from ?? null, $to ?? null);
    $count=0;
    @endphp
    <div class="body">
       
        <div class="row text-center">
            <div class="col-sm-4 col-6">
                <h4 class="m-t-0">
                    @if($data['filteredBill'])
                        <span class="badge badge-info mb-1" style="font-size: 14px;">Filtered Range: {{ $data['filteredBill'] }}</span><br>
                    @endif
                    {{$data['todaybill']}}
                </h4>
                <p class="text-muted"> Today's</p>
            </div>

            <div class="col-sm-4 col-6">
                <h4 class="m-t-0">
                    {{$data['weeklybill']}}
                                               
                </h4>
                <p class="text-muted">This Week's</p>
            </div>
            <div class="col-sm-4 col-6">
                <h4 class="m-t-0">
                    {{$data['monthbill']}}
                    
                </h4>
                <p class="text-muted">This Month's</p>
            </div>
            <div class="col-sm-6 col-6">
                <h4 class="m-t-0">
                    {{$data['yearbill']}}
                    
                </h4>
                <p class="text-muted">This Year's</p>
            </div>
            <div class="col-sm-6 col-6">
                <h4 class="m-t-0">
                    {{$data['completeBill']}}
                    
                </h4>
                <p class="text-muted">Till Date</p>
            </div>
        </div>
        <div id="site_bills_area_chart"></div><br>
        <table  class="dashboardTable table table-hover">
            <thead>
                <th>#</th>
                <th>Work Name</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Amount</th>


            </thead>
            <tbody>
                @foreach ($workdata as $dd)
                <tr>
                    <td>{{++$count}}</td>
                    <td><?= $dd->name ?></td>
                    <td><?= $dd->total_qty ?></td>
                    <td><?= $dd->unit ?></td>
                    <td><?= $dd->total_amount ?></td>

                </tr>
            @endforeach
          
            </tbody>
        </table>
    </div>
</div>
