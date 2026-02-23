<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $bill->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Poppins', 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background: #fff;
        }

        /* Watermark */
        #watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 500px;
            height: 500px;
            margin-top: -250px;
            margin-left: -250px;
            z-index: -1000;
            opacity: 0.05;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #watermark img {
            width: 100%;
            height: auto;
            filter: grayscale(100%);
        }

        .container {
            padding: 40px 40px 40px 60px;
            position: relative;
        }

        .accent-bar {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 15px;
            background: #28a745;
        }

        .header {
            border-bottom: 2px solid #f1f4f8;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: table;
            width: 100%;
        }

        .logo-cell {
            display: table-cell;
            vertical-align: middle;
            width: 120px;
        }

        .title-cell {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }

        .title-cell h1 {
            color: #28a745;
            margin: 0;
            text-transform: uppercase;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .meta-text {
            color: #7f8c8d;
            font-size: 13px;
            margin-top: 5px;
        }

        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }

        .info-box {
            width: 50%;
            padding: 25px;
            background: #fcfdfe;
            border: 1px solid #eef2f7;
            border-radius: 8px;
            vertical-align: top;
        }

        .info-box h3 {
            color: #28a745;
            font-size: 13px;
            text-transform: uppercase;
            margin-top: 0;
            border-bottom: 2px solid #eef2f7;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .info-box p {
            margin: 6px 0;
            font-size: 14px;
            color: #444;
        }

        .label {
            font-weight: bold;
            color: #5a6c7f;
            display: inline-block;
            width: 90px;
        }

        .value {
            color: #2c3e50;
            font-weight: 600;
        }

        .receipt-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 10px;
            border: 1px solid #eef2f7;
            border-radius: 8px;
            overflow: hidden;
        }

        .receipt-table th {
            background-color: #f8fbff;
            color: #5a6c7f;
            text-align: left;
            padding: 15px;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            border-bottom: 2px solid #eef2f7;
        }

        .receipt-table td {
            padding: 15px;
            border-bottom: 1px solid #eef2f7;
            font-size: 14px;
            vertical-align: middle;
            background: #fff;
        }

        .receipt-table .amount-col {
            text-align: right;
        }

        .item-name {
            font-weight: bold;
            color: #2c3e50;
            font-size: 15px;
            display: block;
        }

        .total-row td {
            background-color: #f8fbff;
            font-size: 16px;
            font-weight: bold;
            color: #28a745;
            border-bottom: none;
        }

        .status-container {
            margin-top: 40px;
            text-align: center;
        }

        .paid-stamp {
            color: #28a745;
            font-size: 24px;
            text-transform: uppercase;
            font-weight: bold;
            border: 3px solid #28a745;
            display: inline-block;
            padding: 10px 30px;
            border-radius: 8px;
            letter-spacing: 2px;
            transform: rotate(-5deg);
        }

        .footer {
            position: fixed;
            bottom: 30px;
            left: 60px;
            right: 40px;
            text-align: center;
            border-top: 1px solid #f1f4f8;
            padding-top: 20px;
            color: #b2bec3;
        }

        .footer-brand {
            color: #5a6c7f;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .footer-tag {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <div id="watermark">
        <img src="{{ public_path('assets/frontend/img/logo/logo.jpeg') }}">
    </div>

    <div class="accent-bar"></div>

    <div class="container">
        <div class="header">
            <div class="logo-cell">
                <img src="{{ public_path('assets/frontend/img/logo/logo.jpeg') }}" style="height: 55px;">
            </div>
            <div class="title-cell">
                <h1>Payment Receipt</h1>
                <div class="meta-text">
                    Receipt ID: <strong>#RC-{{ str_pad($bill->id, 5, '0', STR_PAD_LEFT) }}</strong> &nbsp; | &nbsp;
                    Date: <strong>{{ date('d M, Y', strtotime($bill->date)) }}</strong>
                </div>
            </div>
        </div>

        <table class="info-grid">
            <tr>
                <td class="info-box" style="border-right: 15px solid white;">
                    <h3>Billed To (Patient)</h3>
                    <p><span class="label">Full Name:</span> <span class="value">{{ $user->first_name ?? '' }}
                            {{ $user->last_name ?? '' }}</span></p>
                    <p><span class="label">Patient ID:</span> <span class="value">#{{ $patient->id ?? 'N/A' }}</span>
                    </p>
                    <p><span class="label">Email:</span> <span class="value">{{ $user->email ?? 'N/A' }}</span></p>
                </td>
                <td class="info-box">
                    <h3>Service Provider (Doctor)</h3>
                    <p><span class="label">Doctor Name:</span> <span class="value">Dr.
                            {{ $bill->doctor_first_name ?? '' }} {{ $bill->doctor_last_name ?? '' }}</span></p>
                    @if($bill->specialist)
                        <p><span class="label">Department:</span> <span class="value">{{ $bill->specialist }}</span></p>
                    @endif
                </td>
            </tr>
        </table>

        <table class="receipt-table">
            <thead>
                <tr>
                    <th width="70%">Description</th>
                    <th width="30%" class="amount-col">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span class="item-name">Medical Consultation Fee</span>
                        <span style="font-size: 12px; color: #7f8c8d;">Appointment Date:
                            {{ date('F j, Y, g:i a', strtotime($bill->date)) }}</span>
                    </td>
                    <td class="amount-col">${{ number_format($bill->fees, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td style="text-align: right;">Total Paid:</td>
                    <td class="amount-col">${{ number_format($bill->fees, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="status-container">
            <div class="paid-stamp">PAID IN FULL</div>
            <p style="color: #7f8c8d; font-size: 12px; margin-top: 15px;">Thank you for your payment!</p>
        </div>

        <div class="footer">
            <div class="footer-brand">EasyDoctor Digital Health</div>
            <div class="footer-tag">Official Payment Receipt &nbsp;&bull;&nbsp; Generated: {{ date('d-m-Y H:i') }}</div>
        </div>
    </div>
</body>

</html>