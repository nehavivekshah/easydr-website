<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription #{{ $prescription->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        @page { margin: 0; }
        body { font-family: 'Poppins', 'Helvetica', 'Arial', sans-serif; color: #333; margin: 0; padding: 0; line-height: 1.6; background: #fff; }
        
        /* Watermark */
        #watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 500px;
            height: 500px;
            margin-top: -250px; /* Half of height */
            margin-left: -250px; /* Half of width */
            z-index: -1000;
            opacity: 0.07; /* Light gray effect */
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #watermark img {
            width: 100%;
            height: auto;
            /* Grayscale filter if supported, otherwise opacity handles the 'light' feel */
            filter: grayscale(100%); 
        }

        .container { padding: 40px 40px 40px 60px; position: relative; }
        .accent-bar { position: absolute; left: 0; top: 0; bottom: 0; width: 15px; background: #1a4b8c; }
        
        .header { border-bottom: 2px solid #f1f4f8; padding-bottom: 20px; margin-bottom: 30px; display: table; width: 100%; }
        .logo-cell { display: table-cell; vertical-align: middle; width: 120px; }
        .title-cell { display: table-cell; text-align: right; vertical-align: middle; }
        .title-cell h1 { color: #1a4b8c; margin: 0; text-transform: uppercase; font-size: 28px; font-weight: bold; letter-spacing: 1px; }
        .meta-text { color: #7f8c8d; font-size: 13px; margin-top: 5px; }
        
        .info-grid { width: 100%; border-collapse: collapse; margin-bottom: 35px; }
        .info-box { width: 50%; padding: 25px; background: #fcfdfe; border: 1px solid #eef2f7; border-radius: 8px; vertical-align: top; }
        .info-box h3 { color: #1a4b8c; font-size: 13px; text-transform: uppercase; margin-top: 0; border-bottom: 2px solid #eef2f7; padding-bottom: 10px; margin-bottom: 15px; font-weight: bold; letter-spacing: 0.5px; }
        .info-box p { margin: 6px 0; font-size: 14px; color: #444; }
        .label { font-weight: bold; color: #5a6c7f; display: inline-block; width: 90px; }
        .value { color: #2c3e50; font-weight: 600; }

        .medicines-table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; border: 1px solid #eef2f7; border-radius: 8px; overflow: hidden; }
        .medicines-table th { background-color: #f8fbff; color: #1a4b8c; text-align: left; padding: 15px; font-size: 11px; text-transform: uppercase; font-weight: bold; border-bottom: 2px solid #1a4b8c; }
        .medicines-table td { padding: 15px; border-bottom: 1px solid #eef2f7; font-size: 14px; vertical-align: middle; background: #fff; }
        .medicines-table tr:last-child td { border-bottom: none; }
        
        .med-name { font-weight: bold; color: #1a4b8c; font-size: 15px; display: block; }
        .med-sub { font-size: 11px; color: #95a5a6; margin-top: 3px; font-weight: normal; }

        .notes-container { margin-top: 40px; padding: 25px; background: #fffdf5; border: 1px dashed #f1c40f; border-radius: 8px; }
        .notes-container h4 { color: #a18105; margin-top: 0; font-size: 14px; text-transform: uppercase; font-weight: bold; margin-bottom: 12px; }
        .notes-container p { font-size: 13.5px; color: #7d6608; margin: 6px 0; line-height: 1.5; }

        .footer { position: fixed; bottom: 30px; left: 60px; right: 40px; text-align: center; border-top: 1px solid #f1f4f8; padding-top: 20px; color: #b2bec3; }
        .footer-brand { color: #1a4b8c; font-weight: bold; font-size: 14px; margin-bottom: 5px; }
        .footer-tag { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; }
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
                <h1>Medical Prescription</h1>
                <div class="meta-text">
                    Reference ID: <strong>#{{ $prescription->id }}</strong> &nbsp; | &nbsp; Issued On: <strong>{{ date('d M, Y', strtotime($prescription->prescribed_date)) }}</strong>
                </div>
            </div>
        </div>

        <table class="info-grid">
            <tr>
                <td class="info-box" style="border-right: 15px solid white;">
                    <h3>Healthcare Provider</h3>
                    <p><span class="label">Practitioner:</span> <span class="value">Dr. {{ $doctor->user->first_name ?? '' }} {{ $doctor->user->last_name ?? '' }}</span></p>
                    <p><span class="label">License No:</span> <span class="value">{{ $doctor->registration_no ?? 'REG-'.strtoupper(substr($doctor->uid, 0, 8)) }}</span></p>
                    @if($doctor->specialization)
                        <p><span class="label">Department:</span> <span class="value">{{ $doctor->specialization }}</span></p>
                    @endif
                </td>
                <td class="info-box">
                    <h3>Patient Profile</h3>
                    <p><span class="label">Full Name:</span> <span class="value">{{ $patient->user->first_name ?? '' }} {{ $patient->user->last_name ?? '' }}</span></p>
                    <p><span class="label">Identity ID:</span> <span class="value">#{{ $patient->id }}</span></p>
                    <p><span class="label">Gender:</span> <span class="value">{{ $patient->gender ?? 'N/A' }}</span></p>
                </td>
            </tr>
        </table>

        <table class="medicines-table">
            <thead>
                <tr>
                    <th width="40%">Prescribed Medication</th>
                    <th width="15%">Dosage</th>
                    <th width="15%">Frequency</th>
                    <th width="15%">Duration</th>
                    <th width="15%">Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicines as $med)
                <tr>
                    <td>
                        <span class="med-name">{{ $med->medicine_name }}</span>
                        <span class="med-sub">{{ $med->route ?? 'Oral' }} &bull; {{ $med->medicine_type ?? 'Medicine' }}</span>
                    </td>
                    <td>{{ $med->dosage }}</td>
                    <td>{{ $med->frequency }}</td>
                    <td>{{ $med->duration }}</td>
                    <td>{{ $med->meal }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @php 
            $allNotes = $medicines->pluck('notes')->filter()->unique();
        @endphp

        @if($allNotes->count() > 0)
        <div class="notes-container">
            <h4>Clinical Instructions & Guidance</h4>
            @foreach($allNotes as $note)
                <p>&bull; {{ $note }}</p>
            @endforeach
        </div>
        @endif

        <div class="footer">
            <div class="footer-brand">EasyDoctor Digital Health</div>
            <div class="footer-tag">Official Health Record &nbsp;&bull;&nbsp; {{ date('d-m-Y H:i') }} &nbsp;&bull;&nbsp; Verification Required</div>
        </div>
    </div>
</body>
</html>
