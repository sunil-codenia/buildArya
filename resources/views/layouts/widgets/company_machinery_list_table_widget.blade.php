<div class="col-lg-6 col-md-6 col-sm-12">
    <div class="card">
        <div class="header">
            <h2><strong>Machineries</strong> List

            </h2>
        </div>
        @php
            $data = get_company_machinery_list_table_widget($from ?? null, $to ?? null);
            $count = 0;
        @endphp
        <div class="body">

            <table class=" dashboardTable table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Head</th>
                        <th>Site</th>
                        <th>At Site Since</th>
                        <th>Next Service</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dd)
                        <tr>
                            <td>{{ ++$count }}</td>
                            <td>
                                {{ $dd->name }}
                            </td>
                            <td>
                                {{ $dd->head }}
                            </td>
                            <td>
                                {{ $dd->site }}
                            </td>
                            <td>
                                {{ getmachineryLastTransfer($dd->id)->create_datetime }}
                            </td>
                            <td>{{getMachineryNextService($dd->id)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
