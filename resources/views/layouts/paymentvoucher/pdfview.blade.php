<html>

<head>
    <style>
        .sub {
            display: flex;
            align-items: center;
        }

        .sub1 {
            margin-left: 70%;
            color: white;
            margin-top: -2%;
        }

        h4 {
            margin: 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ccc;
            padding: 8px 0;
        }

        .header {
            font-weight: bold;
        }




        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            padding-bottom: 30px;

        }

        #customers td,
        #customers th {
            border: 1.5px solid black;
            font-size: 6px;
            padding: 8px;
        }


        #customers th {

            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: white;
            color: orange;
        }

        .tmain {
            background-color: white;
            margin: 10px;
            margin-top: -20px;
            padding: 2px;
            border-radius: 25px;
        }

        .hmain {
            color: white;
            font-size: 25px;
            margin-top: -20px;
        }

        h3 {
            text-align: center;
        }

        p {
            text-align: center;
        }

        hr {
            height: 1.5px;
            width: 90%;
            background-color: black;
            margin-bottom: 30px;

        }
    </style>
</head>

<body style="background-color:#faa25a;">


    <div class="sub">
        <img src="assets/img/harsh.jpg" alt="" style="width:40px; height: 30px;">
        <div class="sub1">
            <h4> Report Generated On:20.12.23</h4><br>
        </div>
    </div>
    <div class="hmain">
        <h3 style="font-size:40px;">Payment Voucher Report</h3>
        <p style="margin-top:-30px;">Report Period : 01 Oct 23 - 30 Nov 2023</p>
    </div>
    </div>
    <div class="tmain">
        <h3 style="font-size:30px;">R.S.Geo Tech India Pvt. Ltd.</h3>
        <h3 style="font-size:15px;margin-top:-25px;">Address:C-20,Sector 23,Sanjay Nagar,Ghaziabad</h3>
        <p style="font-size:15px;">Mobile:+91 xxxxxxxxxx &#160;&#160; Email:contact@rsgeotech.com</p>
        <hr>
        <table id="customers">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Company Name</th>
                    <th>Site Name</th>
                    <th>Party Type</th>
                    <th>Party Name</th>
                    <th>Voucher No.</th>
                    {{-- <th>Payment Details</th> --}}
                    <th>Payment Date</th>
                    <th>Created By</th>
                    <th>Approved By</th>
                    <th>Amount</th>
                    <th>Paid By</th>
                    <th>Status</th>
                    <th>Remark</th></b>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                @if (count($expenses) > 0)

                    @foreach ($expenses as $expense)
                        <tr>
                            <td>{{ $expense->id }}</td>
                            <td>{{ $expense->date }}</td>
                            <td>{{ $expense->company_id }}</td>
                            <td>{{ $expense->site_id }}</td>
                            <td>{{ $expense->party_type }}</td>
                            <td>{{ $expense->party_id }}</td>
                            <td>{{ $expense->voucher_no }}</td>
                            {{-- <td>{{ $expense->payment_details }}</td> --}}
                            <td>{{ $expense->payment_date }}</td>
                            <td>{{ $expense->created_by }}</td>
                            <td>{{ $expense->approved_by }}</td>
                            <td>{{ $expense->amount }}</td>
                            <td>{{ $expense->paid_by }}</td>
                            <td>{{ $expense->status }}</td>
                            <td>{{ $expense->remark }}</td>
                            <td>
                                <img src="{{ public_path($expense->image) }}" alt="Expense Image"
                                    style="max-width: 20px; max-height: 20px;">

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">No expenses found</td>

                    </tr>
                @endif
            </tbody>

        </table>
    </div>

    </div>
</body>

</html>
