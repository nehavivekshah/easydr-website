<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription #{{ $prescription->id }}</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; margin: 0; padding: 40px; line-height: 1.6; }
        .header { border-bottom: 2px solid #1a4b8c; padding-bottom: 15px; margin-bottom: 30px; display: table; width: 100%; }
        .logo-cell { display: table-cell; vertical-align: middle; width: 150px; }
        .title-cell { display: table-cell; text-align: right; vertical-align: middle; }
        .title-cell h1 { color: #1a4b8c; margin: 0; text-transform: uppercase; font-size: 26px; font-weight: bold; }
        .meta-text { color: #7f8c8d; font-size: 13px; margin-top: 4px; }
        
        .info-table { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .info-cell { width: 50%; vertical-align: top; padding: 20px; background: #f8fbff; border: 1px solid #e1e8f0; }
        .info-cell h3 { color: #1a4b8c; font-size: 14px; text-transform: uppercase; margin-top: 0; border-bottom: 1px solid #d1d9e2; padding-bottom: 8px; margin-bottom: 12px; font-weight: bold; }
        .info-cell p { margin: 4px 0; font-size: 14px; color: #444; }
        .label { font-weight: bold; color: #1a4b8c; display: inline-block; width: 85px; }

        .medicines-table { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #e1e8f0; }
        .medicines-table th { background-color: #1a4b8c; color: white; text-align: left; padding: 12px; font-size: 12px; text-transform: uppercase; border: 1px solid #1a4b8c; }
        .medicines-table td { padding: 12px; border: 1px solid #e1e8f0; font-size: 14px; vertical-align: middle; }
        .medicines-table tr:nth-child(even) { background-color: #fcfdfe; }
        
        .med-name { font-weight: bold; color: #1a4b8c; font-size: 15px; }
        .med-sub { font-size: 12px; color: #7f8c8d; margin-top: 2px; }

        .notes-section { margin-top: 40px; padding: 20px; background: #fffcf5; border: 1px solid #f9e1b2; border-left: 5px solid #f1c40f; }
        .notes-section h4 { color: #856404; margin-top: 0; font-size: 15px; text-transform: uppercase; font-weight: bold; margin-bottom: 10px; }
        .notes-section p { font-size: 14px; color: #664d03; margin: 5px 0; font-style: italic; }

        .footer { position: fixed; bottom: 30px; left: 40px; right: 40px; text-align: center; border-top: 1px solid #eee; padding-top: 15px; font-size: 11px; color: #bdc3c7; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-cell">
            <img src="{{ public_path('assets/frontend/img/logo/logo.jpeg') }}" style="height: 65px;">
        </div>
        <div class="title-cell">
            <h1>Rx Prescription</h1>
            <div class="meta-text">
                No: <strong>#{{ $prescription->id }}</strong> &nbsp;|&nbsp; Date: <strong>{{ date('d M, Y', strtotime($prescription->prescribed_date)) }}</strong>
            </div>
        </div>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-cell" style="border-right: 0;">
                <h3>Doctor Details</h3>
                <p><span class="label">Name:</span> Dr. {{ $doctor->user->first_name ?? '' }} {{ $doctor->user->last_name ?? '' }}</p>
                <p><span class="label">Reg No:</span> {{ $doctor->registration_no ?? 'REG-'.strtoupper(substr($doctor->uid, 0, 8)) }}</p>
                @if($doctor->specialization)
                    <p><span class="label">Specialty:</span> {{ $doctor->specialization }}</p>
                @endif
            </td>
            <td class="info-cell">
                <h3>Patient Details</h3>
                <p><span class="label">Name:</span> {{ $patient->user->first_name ?? '' }} {{ $patient->user->last_name ?? '' }}</p>
                <p><span class="label">Patient ID:</span> #{{ $patient->id }}</p>
                <p><span class="label">Gender:</span> {{ $patient->gender ?? 'N/A' }}</p>
            </td>
        </tr>
    </table>

    <table class="medicines-table">
        <thead>
            <tr>
                <th width="35%">Medicine Name</th>
                <th width="15%">Dosage</th>
                <th width="20%">Frequency</th>
                <th width="15%">Duration</th>
                <th width="15%">Instructions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medicines as $med)
            <tr>
                <td>
                    <div class="med-name">{{ $med->medicine_name }}</div>
                    <div class="med-sub">{{ $med->route ?? 'Oral' }}</div>
                </td>
                <td>{{ $med->dosage }}</td>
                <td>{{ $med->frequency }}</td>
                <td>{{ $med->duration }}</td>
                <td>
                    {{ $med->meal }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @php 
        $allNotes = $medicines->pluck('notes')->filter()->unique();
    @endphp

    @if($allNotes->count() > 0)
    <div class="notes-section">
        <h4>General Instructions / Clinical Notes</h4>
        @foreach($allNotes as $note)
            <p>• {{ $note }}</p>
        @endforeach
    </div>
    @endif

    <div class="footer">
        <strong>EasyDoctor</strong> - Professional Clinic Management System &nbsp;|&nbsp; Generated on {{ date('d-m-Y H:i') }}<br>
        <small>This is a computer generated document. Signature is not required.</small>
    </div>
</body>
</html>
