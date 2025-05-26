<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f8f8f8;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>New Testimonial Received</h2>
    <table>
        <tr>
            <th>Name</th>
            <td>{{ $data->name }}</td>
        </tr>
        <tr>
            <th>School Name</th>
            <td>{{ $data->school_name }}</td>
        </tr>
        <tr>
            <th>Mobile Number</th>
            <td>+{{ $data->country_code.' '.$data->mobile_number }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $data->email }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $data->category }}</td>
        </tr>
        <tr>
            <th>Message</th>
            <td>{{ $data->message }}</td>
        </tr>
        
    </table>
</body>
</html>