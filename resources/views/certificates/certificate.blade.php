<!DOCTYPE html>
<html>
<head>
    <title>Certificate of Completion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .certificate {
            border: 5px solid #2c3e50;
            padding: 50px;
            margin: 20px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            background-color: #f9f9f9;
        }
        h1 {
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin: 10px 0;
        }
        .signature {
            margin-top: 50px;
            font-size: 16px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>Certificate of Completion</h1>
        <p>This is to certify that</p>
        <h2>{{ $employee_name }}</h2>
        <p>has successfully completed the course</p>
        <h3>{{ $course_name }}</h3>
        <p>on {{ $completion_date }}</p>
        <div class="signature">
            <p>___________________________</p>
            <p>Authorized Signature</p>
        </div>
    </div>
</body>
</html>