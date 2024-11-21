<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<p>Hello Admin </p>
<p>The following policies will be expiring in the coming week</p>

<p></p>
<table>
    <thead>
    <tr>
        <th>Policy Number</th>
        <th>Customer Name</th>
        <th>Policy Type</th>
        <th>Status</th>
        <th>Premium Amount</th>
        <th>Start Date</th>
        <th>End Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $row['policy_number'] }}</td>
            <td>{{ $row['customer_name'] }}</td>
            <td>{{ $row['policy_type'] }}</td>
            <td>{{ $row['status'] }}</td>
            <td>{{ $row['premium_amount'] }}</td>
            <td>{{ $row['start_date'] }}</td>
            <td>{{ $row['end_date'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
