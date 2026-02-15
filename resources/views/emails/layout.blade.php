<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Pengembangan Media Digital</title>
    <style>
        /* Import Font Montserrat */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #003d79 0%, #002855 100%);
            padding: 30px 20px;
            text-align: center;
        }
        .logo {
            max-height: 60px;
            background: rgba(255,255,255,0.1);
            padding: 10px;
            border-radius: 8px;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #8898aa;
            border-top: 1px solid #eeeeee;
        }
        /* Utilitas untuk Tabel Data */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }
        .data-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .data-table td:first-child {
            font-weight: 600;
            color: #555;
            width: 35%;
        }
        /* Tombol Aksi */
        .btn {
            display: inline-block;
            background-color: #003d79;
            color: #ffffff !important;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 20px;
            text-align: center;
        }
        .btn:hover {
            background-color: #002855;
        }
        .highlight {
            color: #003d79;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1 style="color: white; margin: 0; font-size: 24px; letter-spacing: 2px;">UNIT PENGEMBANGAN MEDIA DIGITAL</h1>
        </div>

        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Unit Pengembangan Media Digital (UPMD)<br>
            Fakultas Ilmu Komputer, Universitas Brawijaya</p>
            <p style="margin-top: 10px;">Email ini dikirim secara otomatis, mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>