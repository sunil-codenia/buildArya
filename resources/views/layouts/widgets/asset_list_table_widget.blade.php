<div class="col-lg-6 col-md-6 col-sm-12">
    <div class="card">
        <div class="header">
            <h2><strong>Assets</strong> List

            </h2>
        </div>
        @php
            $data = get_asset_list_table_widget($id, $from ?? null, $to ?? null);
            $count = 0;
        @endphp
        <div class="body">

            <table class=" dashboardTable table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Head</th>
                        <th>At Site Since</th>
                        <th>Cost Price</th>
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
                                {{ getAssetLastTransfer($dd->id)->create_datetime }}
                            </td>
                            <td>
                                {{ $dd->cost_price }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
