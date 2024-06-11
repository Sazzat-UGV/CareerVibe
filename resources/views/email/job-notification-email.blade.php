<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Notification Email</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 20px 0;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .content {
            padding: 30px;
            color: #333333;
        }

        .content h2 {
            color: #007BFF;
            margin-top: 0;
            font-size: 24px;
        }

        .content p {
            margin: 15px 0;
            line-height: 1.7;
        }

        .details {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .details h3 {
            margin-top: 0;
            font-size: 20px;
        }

        .details p {
            margin: 10px 0;
        }

        .footer {
            text-align: center;
            padding: 15px 0;
            color: #888888;
            font-size: 14px;
            border-top: 1px solid #eeeeee;
            margin-top: 30px;
        }

        .button {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $mailData['employer']->name }},</h2>
            <p>We are excited to inform you that there is a new application for the job position at your company.</p>
            <h2>Job Title: {{ $mailData['job']->title }}</h2>
            <div class="details">
                <h3>Employee Details:</h3>
                <p><strong>Name:</strong> {{ $mailData['user']->name }}</p>
                <p><strong>Email:</strong> {{ $mailData['user']->email }}</p>
                <p><strong>Mobile:</strong> {{ $mailData['user']->mobile }}</p>
            </div>
            <a href="{{ route('job.detail', $mailData['job']->id) }}" class="button">View Application</a>
        </div>
        <div class="footer">
            <p>Thank you for using {{ config('app.name') }}.</p>
        </div>
    </div>
</body>

</html>
