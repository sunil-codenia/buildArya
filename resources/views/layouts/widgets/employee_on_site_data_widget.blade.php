<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="body">
            <div style="    text-align-last: center;">
                <i class="zmdi zmdi-accounts-alt col-purple" style="    font-size: 110px;"></i></div>
            <h3 class="number count-to" data-from="0" data-to="2000" data-speed="2000"
            data-fresh-interval="2000">
               {{get_employee_on_site_data_widget($id)}}
            </h3>
            <p class="text-muted">Employees On Site</p>
            <div class="progress">
                <div class="progress-bar l-parpl" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100" style="width: 100%;"></div>
            </div>
            {{-- <small>Change 13%</small> --}}
        </div>
    </div>
</div>