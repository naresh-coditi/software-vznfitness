

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
            <span>{{ dateFormat(today()) }}</span>
        </p>
    </div>
    <div style="clear: both"></div>
    <div style="margin-top: 50px">
        <p style="font-weight: 600; font-size: 1.5rem; margin-bottom:2px; ">Branch Info</p>
        <table style="width: 100%; border: 1.5px solid black; text-align: left;" class="fullTable">
            <thead>
                <tr style="background-color: #f5f5f5;">
                    <th class="cellSpacing">Name</th>
                    <th class="cellSpacing">Location</th>
                    <th class="cellSpacing">Address</th>
                    <th class="cellSpacing">Contact No.</th>
                    <th class="cellSpacing">GST No.</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="cellSpacing">{{ $branch->name }}</td>
                    <td class="cellSpacing">{{ $branch->location }}</td>
                    <td class="cellSpacing">{{ $branch->address }}</td>
                    <td class="cellSpacing">{{ $branch->phone }}</td>
                    <td class="cellSpacing">{{ $branch->gst_no ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="margin-top: 50px">
        <table style="width: 100%; color: white;">
            <tr>
                <td class="cell" style="background-color: #FF681F; text-align: center;">
                    <p>Invoice No.</p>
                    <p class="bigValue">{{ $invoiceNumber }}</p>
                </td>
                <td class="cell" style="background-color: #FF681F; text-align: center;">
                    <p>Issue Date</p>
                    <p class="bigValue">{{ dateFormat(today()) }}</p>
                </td>
                <td class="cell" style="background-color: #f5f5f5; color:#000; text-align: center;">
                    <p>Total Amount Paid</p>
                    <p class="bigValue">{{$amountPaid}}</p>
                </td>
            </tr>
        </table>
    </div>
    <div style="margin-top: 50px">
    <div style="font-weight: 600; font-size: 1.8rem; margin-bottom: 10px; color: #333;">
    Transaction Info
</div>
<table style="width: 100%; border-collapse: collapse; text-align: center;">
    <thead>
        <tr style="border-top: 2px solid #000; border-bottom: 2px solid #000; background-color: #f5f5f5;">
            <th style="padding: 10px;">Transaction Date</th>
            <th style="padding: 10px;">Total Amount</th>
            <th style="padding: 10px;">Amount Paid</th>
            <th style="padding: 10px;">Remaining Amount</th>
            <th style="padding: 10px;">Payment Method</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $transaction)
        <tr style="border-bottom: 1px solid #ddd;">
            <td style="padding: 8px;">{{ $transaction->transaction_date }}</td>
            <td style="padding: 8px;">{{ $transaction->amount + $transaction->remaining_amount }}</td>
            <td style="padding: 8px;">{{ $transaction->amount }}</td>
            <td style="padding: 8px;">{{ $transaction->remaining_amount ?? '0' }}</td>
            <td style="padding: 8px;">{{ $transaction->method_type }}</td>
        </tr>
        @endforeach
    </tbody>
</table> 
  
<div class="summary" style="margin-top: 2rem; float: right; padding: 5px;">
    <!-- Grand Total -->
    <span style="display: block; text-align: right;">
        <p style="color: black; font-size:1rem; margin: 2px;">Grand Total: {{ $amountPaid + $remainingBalance }}</p>
    </span>

    <!-- Total Remaining Balance -->
    <span style=" text-align: right; margin-bottom: 3px;">
        <p style="color: red; font-size:1rem;margin: 2px;">Total Remaining Balance: {{ $remainingBalance ?? '0'}}</p>
    </span>

    <!-- Total Amount Paid -->
    <span class="grand-total" style="background-color: orangered; color: whitesmoke; padding: 2px 5px; display: flex; justify-content: center; align-items: center; text-align: center; margin-top: 2px;">
        <p class="bigValue" style="margin: 0;">Total Amount Paid: {{ $amountPaid }}</p>
    </span>
</div>

    </div>
    <div style="padding-right: 3.5rem; padding-top: 1.5rem; padding-bottom: 1.5rem; margin-top: 9rem;">
        <span style="font-weight: bold; color: orangered; margin-right: 7px;">PAYMENT MODE USED : </span>
        <span style="margin-top: 3px;">
            @foreach ($transactions->unique('method_type') as $transaction)
            <span>{{ $transaction->method_type }} <span style="margin: 0 2px;">|</span> </span>
            @endforeach
        </span>
    </div>

    <hr style="border: none; height: 0.5px; background-color: orangered; margin: 2px 0;">
    <footer style="text-align: center; margin-top: auto; padding: 1rem 0; position: relative; bottom: 0; width: 100%; font:italic; font: bold;">
        Elite Edge Gym & Spa
        <span style="color: #e2e8f0; padding-left: 0.5rem; padding-right: 0.5rem;">|</span>
        {{ $branch->phone }}
    </footer>
    <hr style="border: none; height: 0.5px; background-color: orangered; margin: 2px 0;">

</body>

</html>
