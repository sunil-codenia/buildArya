<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="body">
            <div style="    text-align-last: center;">
            <i class="zmdi zmdi-balance-wallet col-orange" style="    font-size: 110px;"></i></div>
            <h3 class="number count-to" data-from="0" data-to="2521" data-speed="2000"
                data-fresh-interval="700">
                {{get_site_balance_data_widget($id, $to ?? null)}}
            </h3>
            <p class="text-muted">Site Balance</p>
            <div class="progress">
                <div class="progress-bar l-amber" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100" style="width: 100%;"></div>
            </div>
            {{-- <small>Change 17%</small> --}}
        </div>
    </div>
</div>