<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription #{{ $prescription->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Prescription #{{ $prescription->id }}</h2>
    <p>Date: {{ $prescription->prescribed_date }}</p>
    <p>Doctor: Dr. {{ $doctor->user->first_name ?? 'Unknown' }} {{ $doctor->user->last_name ?? '' }}</p>
<p>Patient: {{ $patient->user->first_name ?? 'Unknown' }} {{ $patient->user->last_name ?? '' }}</p>


    <h3>Medicines</h3>
    <table>
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Dosage</th>
                <th>Frequency</th>
                <th>Duration</th>
                <th>Route</th>
                <th>Meal</th>
                <th>Instructions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medicines as $med)
            <tr>
                <td>{{ $med->medicine_name }}</td>
                <td>{{ $med->dosage }}</td>
                <td>{{ $med->frequency }}</td>
                <td>{{ $med->duration }}</td>
                <td>{{ $med->route }}</td>
                <td>{{ $med->meal }}</td>
                <td>{{ $med->instruction }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
