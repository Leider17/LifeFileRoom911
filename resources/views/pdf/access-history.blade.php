<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Access History - {{ $employee->first_name }} {{ $employee->last_name }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1, h2 {
            text-align: center;
        }

        .info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f3f3f3;
        }
    </style>
</head>
<body>

    <h1>Access History</h1>
    <h2>{{ $employee->first_name }} {{ $employee->last_name }} (ID: {{ $employee->internal_id }})</h2>

    <div class="info">
        <p><strong>Department:</strong> {{ $employee->department->name ?? 'N/A' }}</p>
        <p><strong>Access attempts:</strong> {{ $history->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Attempt status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($history as $index =>  $attempt)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $attempt->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $attempt->sucess ?? 'N/A' }}</td>
                    <td>{{ $attempt->ip_address ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
