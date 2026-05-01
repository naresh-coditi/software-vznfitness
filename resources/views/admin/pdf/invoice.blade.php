<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Pdf</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            padding: 50px;
            position: relative;
            font-size: 0.8rem;
        }

        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        .cell {
            padding: 10px;
        }

        .bigValue {
            font-size: 1.2rem;
            font-weight: 600;
            padding: 4px;
        }

        .cellSpacing {
            padding: 4px;
        }

        .fullTable th+th,
        .fullTable td+td {
            border-left: 1px solid black;
        }

        .fullTable td {
            border-top: 1px solid black;
        }
    </style>
</head>

<body>
    <div style="float: left; width: 50%;">
        <img src="{{ asset('images/logo.jpeg') }}" alt="">
    </div>
    <div style="float: right; margin-top: 30px;">
        <p>Invoice Number: {{ $invoiceNumber }}</p>
    </div>
    <div style="clear: both"></div>
    <div style="float: left; width: 50%;">
        <p style="font-weight: bold">BILL TO</p>
        <p>{{ $userProfile->fullName }}</p>
        <p>{{ $user->phone }}</p>
        <p>{{ $userProfile->gender }}</p>
    </div>
    <div style="float: right; margin-top: 15px;">
        <p>
            <span>Issue Date :</span>
            <span>{{ dateFormat($latestPlan->start_date) }}</span>
        </p>
    </div>
    <div style="clear: both"></div>
    <div style="margin-top: 50px">
        <p style="font-weight: 600; font-size: 1.5rem; margin-bottom:2px; ">Branch Info</p>
        <table style="width: 100%; border: 1.5px solid black; text-align: left;" class="fullTable">
            <thead>
                <tr>
                    <th class="cellSpacing">Name</th>
                    <th class="cellSpacing">Location</th>
                    <th class="cellSpacing">Address</th>
                    <th class="cellSpacing">Contact No.</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="cellSpacing">{{ $branch->name }}</td>
                    <td class="cellSpacing">{{ $branch->location }}</td>
                    <td class="cellSpacing">{{ $branch->address }}</td>
                    <td class="cellSpacing">{{ $branch->phone }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="margin-top: 50px">
        <table style="width: 100%; color: white;">
            <tr>
                <td class="cell" style="background-color: rgb(255,194,82);">
                    <p>Invoice No.</p>
                    <p class="bigValue">{{ $invoiceNumber }}</p>
                </td>
                <td class="cell" style="background-color: rgb(255,194,82);">
                    <p>Issue Date</p>
                    <p class="bigValue">{{ dateFormat($latestPlan->start_date) }}</p>
                </td>
                <td class="cell" style="background-color: rgb(255,194,82);">
                    <p>Due Date</p>
                    <p class="bigValue">{{ dateformat($latestPlan->end_date) }}</p>
                </td>
                <td class="cell" style="background-color: rgb(58, 58, 58);">
                    <p>Total Amount</p>
                    <p class="bigValue">{{ $latestPlan->totalAmount }}</p>
                </td>
            </tr>
        </table>
    </div>
    <div style="margin-top: 50px">
        <p style="font-weight: 600; font-size: 1.5rem; margin-bottom:2px; ">Membership Info</p>
        <table
            style="width: 100%; border-top: 1.5px solid black; border-bottom: 1.5px solid black; text-align: center;">
            <thead>
                <tr>
                    <th class="cellSpacing">Membership</th>
                    <th class="cellSpacing">Total Amount</th>
                    <th class="cellSpacing">Paid Amount</th>
                    <th class="cellSpacing">Remaining Amount</th>
                    <th class="cellSpacing">Start Date</th>
                    <th class="cellSpacing">End Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="cellSpacing">{{ $latestPlan->name }}</td>
                    <td class="cellSpacing">{{ $latestPlan->totalAmount }}</td>
                    <td class="cellSpacing">{{ 'Rs ' . $latestPlan->amount }}</td>
                    <td class="cellSpacing">{{ 'Rs ' . $latestPlan->remaining_amount }}</td>
                    <td class="cellSpacing">{{ dateFormat($latestPlan->start_date) }}</td>
                    <td class="cellSpacing">{{ dateFormat($latestPlan->end_date) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
