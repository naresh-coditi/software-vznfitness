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
            <span>{{ dateFormat($personalTrainer->start_date) }}</span>
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
                    <th class="cellSpacing">GST Number</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="cellSpacing">{{ $branch->name }}</td>
                    <td class="cellSpacing">{{ $branch->location }}</td>
                    <td class="cellSpacing">{{ $branch->address }}</td>
                    <td class="cellSpacing">{{ $branch->phone }}</td>
                    <td class="cellSpacing">{{ $branch->gst_no }}</td>
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
                    <p class="bigValue">{{ dateFormat($personalTrainer->start_date) }}</p>
                </td>
                <td class="cell" style="background-color: rgb(255,194,82);">
                    <p>Due Date</p>
                    <p class="bigValue">{{ dateformat($personalTrainer->end_date) }}</p>
                </td>
                <td class="cell" style="background-color: rgb(58, 58, 58);">
                    <p>Total Amount</p>
                    <p class="bigValue">{{ $personalTrainer->amount + $personalTrainer->remaining_balance }}</p>
                </td>
            </tr>
        </table>
    </div>
    <div style="margin-top: 50px">
        <p style="font-weight: 600; font-size: 1.5rem; margin-bottom:2px; ">Personal Trainer Info</p>
        <table
            style="width: 100%; border-top: 1.5px solid black; border-bottom: 1.5px solid black; text-align: center;">
            <thead>
                <tr>
                    <th class="cellSpacing">Floor Manager</th>
                    <th class="cellSpacing">Total Amount</th>
                    <th class="cellSpacing">Paid Amount</th>
                    <th class="cellSpacing" style="color:red">Remaining Amount</th>
                    <th class="cellSpacing">Start Date</th>
                    <th class="cellSpacing">End Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="cellSpacing">{{ $personalTrainer->trainer }}</td>
                    <td class="cellSpacing">{{ $personalTrainer->amount + $personalTrainer->remaining_balance}}</td>
                    <td class="cellSpacing">{{ 'Rs ' . $personalTrainer->amount }}</td>
                    <td class="cellSpacing" style="color:red">{{ 'Rs ' . $personalTrainer->remaining_balance }}</td>
                    <td class="cellSpacing">{{ dateFormat($personalTrainer->start_date) }}</td>
                    <td class="cellSpacing">{{ dateFormat($personalTrainer->end_date) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
  <h2 style="margin-top: 25px;">TERMS & CONDITIONS</h2>
  <ol style="padding: 15px; margin-left: 25px;">
    <li>Membership is non-transferable; in case of some special case, discretion lies with the management and a transfer fee is applicable.</li>
    <li>Elite Edge Gym and Spa management & staff are not responsible for any personal belongings.</li>
    <li>Membership fee for any Elite Edge Gym and Spa service is non-refundable.</li>
    <li>Guest charges are applicable, as per the Gym norms.</li>
    <li>Any non-member/non-paying guest accompanied by an Elite Edge Gym and Spa member is not permitted in the workout section & he/she may wait in the reception area.</li>
  </ol>
  <h3 style="margin-bottom: 10px;">Declaration:</h3>
  <p>I understand that strength, flexibility, and aerobic exercise, including the use of equipment, is a potentially hazardous activity. I also understand fitness activities involve risk of injury and that I am voluntarily participating in these activities and using equipment or machinery with knowledge of dangers involved. Hereby, I agree to expressly assume and accept any risk of injury. I do hereby declare that I am physically sound and not suffering from any condition, impairment, disease, injury, or other illness that may prevent my participation in any of the activities and programs of the gymnasium, use of equipment, or machinery except as herein after stated.<br> I hereby declare that I have read the Terms & Conditions and voluntarily agree to them.<br> The above-mentioned information is true.</p>
  <p style="margin-top: 15px;">On behalf of <strong><i>Elite Edge Gym and Spa</i></strong></p>
</div>
</body>

</html>
