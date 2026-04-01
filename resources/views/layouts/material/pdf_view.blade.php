<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Materials Details </title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>


<style>
    * {
        margin: 0px;
        padding: 0px;
    }

    .content-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        min-width: 950px;
        border-radius: 5px 5px 0 0;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    .content-table thead tr {
        background-color: #009879;
        color: #ffffff;
        text-align: left;
        font-weight: bold;
    }

    .content-table th,
    .content-table td {
        padding: 12px 15px;
    }

    .content-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .content-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .content-table tbody tr:last-of-type {
        border-bottom: 2px solid #009879;
    }

    .content-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }

    td img {
        width: 50px;
        height: 50px;
    }

    table {
        padding: 10px;
        width: 100%;
    }

    h2 {
        text-align: center;
        margin-top: 20px
    }
</style>



<body>

    <h3 class="text-center bgs"> Materials Details </h3>

    <div class="table table-responsive">
        <table class="content-table">
            <thead>
                <tr class="rt">
                   
                    <th>Date</th>
                    <th>Material Name</th>
                    <th>Material Supplier</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                 
                    <th>Rate</th>
                    <th>Material Amount</th>
                    <th>Bill No</th>
                    <th>Vehicle</th>

                    <th>Remark</th>
                    <th>Location</th>
                    <th>Site Name</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $Print)
                    <tr class="rt">
                        <td> {{ $Print->date }} </td>
                        <td> {{ $Print->material_name }} </td>
                        <td> {{ $Print->supplier_name }} </td>
                        <td> {{ $Print->unit_name }} </td>
                        <td> {{ $Print->qty }} </td>
                        <td> {{ $Print->rate }} </td>
                        <td> {{ $Print->amount }} </td>
                        <td> {{ $Print->bill_no }} </td>
                        <td> {{ $Print->vehical }} </td>
                        <td> {{ $Print->remark }} </td>
                        <td> {{ $Print->location }} </td>
                        <td> {{ $Print->site_name }} </td>
                        <td> {{ $Print->user_name }} </td>
                        <td> {{ $Print->status }} </td>
                        <td> <a href="{{ $Print->image }}"> <img src="{{ $Print->image }}"
                                    style="width:30px; height:30px;" /></a> </td>

                    </tr>
                @endforeach
            </tbody>


        </table>
    </div>





</body>

</html>
