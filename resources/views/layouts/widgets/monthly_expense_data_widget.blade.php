<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="body">
            <div style="    text-align-last: center;">
                <i class="zmdi zmdi-receipt col-green" style="    font-size: 110px;"></i></div>
            <h3 class="number count-to" data-from="0" data-to="758" data-speed="2000"
                data-fresh-interval="700">
               {{get_monthly_expense_data_widget($id, $from ?? null, $to ?? null)}} </h3>
            <p class="text-muted">{{ isset($from) && isset($to) ? 'Selected Period' : 'Current Month' }} Expenses</p>
            <div class="progress">
                <div class="progress-bar l-green" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100" style="width: 100%;"></div>
            </div>
        </div>
    </div>
</div>