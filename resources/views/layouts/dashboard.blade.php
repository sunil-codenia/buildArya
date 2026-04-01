@extends('app')
@section('content')
    @include('templates.header')
    @include('templates.blockheader', ['pagename' => 'Site Dashboard'])



    <div class="container-fluid">
        <div class="row clearfix">


            @include('layouts.widgets.dashboard_filter_widget')
            @include('layouts.widgets.site_balance_data_widget')

            @include('layouts.widgets.monthly_expense_data_widget')
            @include('layouts.widgets.employee_on_site_data_widget')

        </div>
        @include('layouts.widgets.pending_flags_site_data_widget')



        <div class="row clearfix">
            @include('layouts.widgets.site_sales_invoices_chart_widget')
            @include('layouts.widgets.payment_voucher_chart_widget')


        </div>


        <div class="row clearfix">
            <div class="col-lg-6 col-md-12">
                @include('layouts.widgets.site_expense_area_chart_widget')


            </div>
            <div class="col-lg-6 col-md-12">
                @include('layouts.widgets.site_bills_area_chart_with_work_table')

            </div>
        </div>
        <div class="row"> @include('layouts.widgets.asset_list_table_widget')
            @include('layouts.widgets.machinery_list_table_widget')</div>
    </div>
@endsection


@section('chart_scripts')
    @php
        $monthlyExpensesFormatted = get_monthlyExpensesFormatted_chart_widget($id, $from_chart, $to_chart);
        $sale_invoices_data = get_site_sales_invoices_chart_widget($id, $from_chart, $to_chart); 
        $site_bills_yearly_data = get_site_bills_area_chart($id, $from_chart, $to_chart);
        $payment_voucher_chart_yearly_data = get_payment_voucher_chart_widget($id, $from_chart, $to_chart);
        $payment_voucher_chart_complete_data = get_payment_voucher_chart_complete_widget($id);

        if (isset($compare_site_id) && $compare_site_id != '') {
            $compare_monthlyExpenses = get_monthlyExpensesFormatted_chart_widget($compare_site_id, $from_chart, $to_chart);
            $compare_site_bills = get_site_bills_area_chart($compare_site_id, $from_chart, $to_chart);
            $compare_name = DB::connection(session('comp_db_conn_name'))->table('sites')->where('id', $compare_site_id)->first()->name;
        }
    @endphp

    <script type="text/javascript">
        $(document).ready(function() {
            ExpenseAreaChart();
            SalesInvoiceChart();
            SiteBillsYearlyAreaChart();
            PaymentVoucherChart(PaymentVoucherData);

        })
        var pv_color_chart_line = ['#f96332', '#72c2ff', '#9ce89d', '#04060c', '#992ef7'];
        var pv_color_chart_pie = ['#72c2ff', '#9ce89d', '#04060c', '#992ef7'];
        const checkbox = document.getElementById('pv_range_change_checkbox');
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                PaymentVoucherChart(PaymentVoucherCompleteData);;
            } else {
                PaymentVoucherChart(PaymentVoucherData);
            }
        });
        const monthlyExpenses = @json($monthlyExpensesFormatted);
        const salesInvoiceData = @json($sale_invoices_data);
        const SiteBillsYearlyData = @json($site_bills_yearly_data);
        const PaymentVoucherData = @json($payment_voucher_chart_yearly_data);
        const PaymentVoucherCompleteData = @json($payment_voucher_chart_complete_data);
        const color = "{{ session('primary_color')[0] }}";
        const sec_color = "{{ session('secondry_color')[0] }}";
        const gred_start_color = "{{ session('gradient_start')[0] }}";
        const gred_end_color = "{{ session('gradient_end')[0] }}";


        const compareMonthlyExpenses = @json($compare_monthlyExpenses ?? []);
        const compareSiteBills = @json($compare_site_bills ?? []);
        const compareName = "{{ $compare_name ?? '' }}";

        function ExpenseAreaChart() {
            let chartData = monthlyExpenses;
            let ykeys = ['expense'];
            let labels = ['Expense'];
            let lineColors = [sec_color];

            if (compareMonthlyExpenses.length > 0) {
                let merged = {};
                monthlyExpenses.forEach(d => merged[d.period] = { ...d, compare_expense: 0 });
                compareMonthlyExpenses.forEach(d => {
                    if (merged[d.period]) {
                        merged[d.period].compare_expense = d.expense;
                    } else {
                        merged[d.period] = { period: d.period, expense: 0, compare_expense: d.expense };
                    }
                });
                chartData = Object.values(merged);
                chartData.sort((a, b) => {
                    if (a.period === 'Start') return -1;
                    if (b.period === 'Start') return 1;
                    return new Date(a.period) - new Date(b.period);
                });
                ykeys.push('compare_expense');
                labels.push(compareName + ' Expense');
                lineColors.push('#f96332'); // A distinct color for comparison
            }

            Morris.Area({
                element: 'expense_area_chart',
                data: chartData,
                lineColors: lineColors,
                xkey: 'period',
                parseTime: false,
                ykeys: ykeys,
                labels: labels,
                    parseTime: false,
                pointSize: 4,
                lineWidth: 2,
                resize: true,
                fillOpacity: 0.2,
                behaveLikeLine: true,
                gridLineColor: '#e0e0e0',
                hideHover: 'auto',
                hoverCallback: function(index, options, content) {
                    var data = options.data[index];
                    let html = 'Month : <b>' + data.period + '</b><br>';
                    html += 'Original Site: ' + formatAmountInRs(data.expense);
                    if (data.compare_expense !== undefined) {
                        html += '<br>' + compareName + ': ' + formatAmountInRs(data.compare_expense);
                    }
                    return html;
                },
            });

        }

        function SalesInvoiceChart() {

            Morris.Bar({
                element: 'site_sales_chart',
                data: salesInvoiceData,
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Amount', 'Balance'],
                barColors: [gred_start_color, gred_end_color],
                hideHover: 'auto',
                gridLineColor: '#e0e0e0',
                resize: true,
                fillOpacity: 0.8,
                hoverCallback: function(index, options, content) {
            var data = options.data[index];
            return '<b>' + data.y + '</b><br>Amount : ' + formatAmountInRs(data.a) +'<br>Balance : ' + formatAmountInRs(data.b) ; // Customize this string as needed
        },

            });
            var donutdata = [];

            salesInvoiceData.forEach(function(item, i) {

                var dd = {
                    label: item.y,
                    value: item.a
                };
                donutdata.push(dd);
            })
            Morris.Donut({
                element: 'sales_invoice_donut_chart',
                data: donutdata,
                formatter: function(value, data) {
                    return formatAmountInRs(value); // Adds the "%" sign after the value
                },
                colors: generateColorShades(color, donutdata.length),
                resize: true,
            });

        }

        function shadeColor(color, percent) {
            var num = parseInt(color.slice(1), 16),
                amt = Math.round(2.55 * percent),
                R = (num >> 16) + amt,
                G = (num >> 8 & 0x00FF) + amt,
                B = (num & 0x0000FF) + amt;
            return (
                "#" +
                (
                    0x1000000 +
                    (R < 255 ? (R < 1 ? 0 : R) : 255) * 0x10000 +
                    (G < 255 ? (G < 1 ? 0 : G) : 255) * 0x100 +
                    (B < 255 ? (B < 1 ? 0 : B) : 255)
                )
                .toString(16)
                .slice(1)
            );
        }

        // Function to generate random shades based on the number of data entries
        function generateColorShades(baseColor, numShades) {
            var shades = [];
            for (var i = 0; i < numShades; i++) {
                // Generate random percentage between -50 (darker) and +50 (lighter)
                var randomPercent = Math.floor(Math.random() * 101) - 50;
                shades.push(shadeColor(baseColor, randomPercent));
            }
            return shades;
        }

        function SiteBillsYearlyAreaChart() {
            let chartData = SiteBillsYearlyData;
            let ykeys = ['expense'];
            let labels = ['Amount'];
            let lineColors = [sec_color];

            if (compareSiteBills.length > 0) {
                let merged = {};
                SiteBillsYearlyData.forEach(d => merged[d.period] = { ...d, compare_expense: 0 });
                compareSiteBills.forEach(d => {
                    if (merged[d.period]) {
                        merged[d.period].compare_expense = d.total || d.expense;
                    } else {
                        merged[d.period] = { period: d.period, expense: 0, compare_expense: d.total || d.expense };
                    }
                });
                chartData = Object.values(merged);
                chartData.sort((a, b) => {
                    if (a.period === 'Start') return -1;
                    if (b.period === 'Start') return 1;
                    return new Date(a.period) - new Date(b.period);
                });
                ykeys.push('compare_expense');
                labels.push(compareName + ' Amount');
                lineColors.push('#f96332');
            }

            Morris.Area({
                element: 'site_bills_area_chart',
                data: chartData,
                lineColors: lineColors,
                xkey: 'period',
                parseTime: false,
                ykeys: ykeys,
                labels: labels,
                    parseTime: false,
                pointSize: 4,
                lineWidth: 2,
                resize: true,
                fillOpacity: 0.2,
                behaveLikeLine: true,
                gridLineColor: '#e0e0e0',
                hideHover: 'auto',
                hoverCallback: function(index, options, content) {
                    var data = options.data[index];
                    let html = 'Month : <b>' + data.period + '</b><br>';
                    html += 'Original Site: ' + formatAmountInRs(data.expense);
                    if (data.compare_expense !== undefined) {
                        html += '<br>' + compareName + ': ' + formatAmountInRs(data.compare_expense);
                    }
                    return html;
                },

            });

        }

        function PaymentVoucherChart(pvdata) {
            document.getElementById('payment_voucher_chart').innerHTML = '';
            document.getElementById('payment_voucher_donut_chart').innerHTML = '';
            document.getElementById('legend').innerHTML = '';
            var Pvchart = Morris.Area({
                element: 'payment_voucher_chart',
                data: pvdata,
                xkey: 'period',
                ykeys: ['total', 'bp', 'site', 'mat', 'other'],
                labels: ['Total', 'Bill Party', 'Site', 'Material Supplier', 'Other Party'],
                pointStrokeColors: pv_color_chart_line,
                lineColors: pv_color_chart_line,
                behaveLikeLine: true,
                parseTime: false,
                gridLineColor: '#e0e0e0',
                pointSize: 4,
                fillOpacity: 0,
                lineWidth: 2,
                hideHover: 'auto',
                resize: true,
                hoverCallback: function(index, options, content) {
            var data = options.data[index];
            return 'Month : <b>' + data.period + '</b><br>Total Payment : ' + formatAmountInRs(data.total) + '<br>Bill Party : ' + formatAmountInRs(data.bp) + '<br>Site : ' + formatAmountInRs(data.site) + '<br>Material Supplier : ' + formatAmountInRs(data.mat) + '<br>Other Party : ' + formatAmountInRs(data.other)  ; // Customize this string as needed
        },
       
            });

            Pvchart.options.labels.forEach(function(label, i) {
                var legendlabel = $('<label for="legend_color' + i + '" style="display: inline-block;">' + label +
                    '</label><input type="color"  onchange="changelegendcolor(' + i +
                    ')" style="opacity: 0; visibility: hidden; position: absolute;" id="legend_color' + i + '">'
                    )
                var legendItem = $('<div class="mbox"></div>').css('background-color', Pvchart.options.lineColors[
                        i])
                    .append(legendlabel)
                $('#legend').append(legendItem);

            });
            var totalbp = 0;
            var totalsite = 0;
            var totalop = 0;
            var totalmat = 0;

            pvdata.forEach(item => {
                totalbp += item.bp;
                totalmat += item.mat;
                totalop += item.other;
                totalsite += item.site;
            });

            var total_pv_val = totalbp + totalmat + totalop + totalsite;
            Morris.Donut({
                element: 'payment_voucher_donut_chart',
                data: [{
                    label: "Bill Party",
                    value: parseFloat((totalbp / total_pv_val) * 100).toFixed(2),

                }, {
                    label: "Sites",
                    value: parseFloat((totalsite / total_pv_val) * 100).toFixed(2),

                }, {
                    label: "Material Suppliers",
                    value: parseFloat((totalmat / total_pv_val) * 100).toFixed(2),
                }, {
                    label: "Other Party",
                    value: parseFloat((totalop / total_pv_val) * 100).toFixed(2),
                }],
                formatter: function(value, data) {
                    return value + "%"; // Adds the "%" sign after the value
                },
                resize: true,
                colors: pv_color_chart_pie
            });
            document.getElementById('pv_bp_total').innerHTML = formatAmountInRs(totalbp);
            document.getElementById('pv_site_total').innerHTML = formatAmountInRs(totalsite);
            document.getElementById('pv_mat_total').innerHTML = formatAmountInRs(totalmat);
            document.getElementById('pv_op_total').innerHTML = formatAmountInRs(totalop);
            document.getElementById('pv_all_total').innerHTML = formatAmountInRs(total_pv_val);

        }

        function changelegendcolor(i) {
            var update_color = document.getElementById("legend_color" + i).value;
            console.log(update_color);
            pv_color_chart_line[i] = update_color;
            if (i != 0) {
                pv_color_chart_pie[i - 1] = update_color;
            }

            if (checkbox.checked) {
                PaymentVoucherChart(PaymentVoucherCompleteData);
            } else {
                PaymentVoucherChart(PaymentVoucherData);
            }
        }
    </script>
@endsection
@section('scripts')
    <script type="text/javascript">
        function formatAmountInRs(amount) {

            const amountStr = parseFloat(amount).toFixed(2).toString();

            const parts = amountStr.split('.');

            const integerPart = parts[0].replace(/(\d+)(\d{3})(\d{2})?(\d{2})?/g, (match, p1, p2, p3, p4) => {
                return p1.replace(/\B(?=(\d{2})+(?!\d))/g, ',') + ',' + p2 + (p3 ? ',' + p3 : '') + (p4 ? ',' + p4 :
                    '')
            });
            if (parts.length > 1) {
                return "₹ " + integerPart + "." + parts[1];
            } else {
                return "₹ " + integerPart;
            }


        }



        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 5,

            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 3
                }
            }
        })

        function changesite() {
            var id = $('#display_site').val();
            var url = "{{ url('/dashboard/') }}" + btoa(id);
            window.location.href = url;
        }
    </script>
@endsection
