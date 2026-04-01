<style>
    #legend {
        display: flex;
        flex-wrap: wrap;
    }

    .mbox {
        display: inline-block;
        width: 15px;
        height: 15px;
        margin: 30px 55px 30px 25px;
        padding-left: 4px;
    }

    .mbox>label {
        margin-left: 20px;
    }
</style>
<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="card">
        <div class="header">
            <h2><strong>Payment </strong> Vouchers

            </h2>
        </div>
        <div class="body" id="site_sales_chart_div">
         
            <h5>Current Year Data <input type="checkbox" hidden="hidden" id="pv_range_change_checkbox">
                <label class="switch" for="pv_range_change_checkbox"></label> Complete Data
            </h5>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12">

                    <h6>Bill Party - <span id="pv_bp_total"></span></h6>
                    <h6>Sites - <span id="pv_site_total"></span></h6>
                    <h6>Material Supplier - <span id="pv_mat_total"></span></h6>
                    <h6>Other Party - <span id="pv_op_total"></span></h6>
                    <h6>Total - <span id="pv_all_total"></span></h6>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">

                    <div id="payment_voucher_donut_chart" style="height:200px;"></div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div id="legend"></div><br>
                    <small style="position:absolute;left:50%;transform:translateX(-50%);">Change Color By Clicking On
                        Label Name</small>
                </div>

            </div>

            <div id="payment_voucher_chart" class="graph"></div>
        </div>
    </div>
</div>
