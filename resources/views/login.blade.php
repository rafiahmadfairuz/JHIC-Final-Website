<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Akun</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #f8f9fd
        }

        .container {
            display: flex;
            align-items: stretch;
            justify-content: center;
            width: 900px;
            max-width: 95%;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden
        }

        .image-side {
            flex: 1.2;
            background: linear-gradient(135deg, #eef2f9, #f5f8ff);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px
        }

        .image-side img {
            width: 100%;
            max-width: 400px;
            border-radius: 12px;
            object-fit: contain;
            transition: .5s
        }

        .image-side:hover img {
            transform: scale(1.05)
        }

        .content {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #fff
        }

        .text {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 25px;
            color: #222
        }

        .field {
            position: relative;
            width: 100%;
            margin-bottom: 25px
        }

        .field input {
            width: 100%;
            height: 55px;
            padding: 0 15px 0 50px;
            font-size: 16px;
            border: none;
            outline: none;
            border-radius: 30px;
            background: linear-gradient(145deg, #f6f7fb, #e9ecf3)
        }

        .field span {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #888
        }

        .field label {
            position: absolute;
            top: 50%;
            left: 50px;
            transform: translateY(-50%);
            font-size: 15px;
            color: #999;
            pointer-events: none;
            transition: .3s
        }

        .field input:focus~label,
        .field input:valid~label {
            top: 0;
            left: 45px;
            font-size: 12px;
            color: #5683cf;
            background: #fff;
            padding: 0 6px;
            border-radius: 6px
        }

        button {
            margin-top: 5px;
            width: 100%;
            height: 50px;
            font-size: 17px;
            font-weight: 600;
            background: linear-gradient(135deg, #e7d5fa, #5683cf);
            border-radius: 25px;
            border: none;
            color: #fff;
            cursor: pointer;
            transition: .35s
        }

        button:hover {
            background: linear-gradient(135deg, #6a9aff, #8b6ef5);
            transform: scale(1.03)
        }

        .alert {
            margin-bottom: 20px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 15px
        }

        .alert-success {
            background: #dcfce7;
            color: #166534
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b
        }

        .demo-box {
            margin-top: 25px;
            background: #f3f4f6;
            border-radius: 12px;
            padding: 18px
        }

        .demo-box h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333
        }

        .demo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px
        }

        .demo-item:last-child {
            border: none
        }

        .demo-role {
            font-weight: 500;
            color: #444
        }

        .demo-cred {
            font-family: monospace;
            color: #555
        }

        .back-btn {
            display: inline-block;
            text-align: center;
            margin-top: 25px;
            width: 100%;
            padding: 13px 0;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            color: #5683cf;
            border: 2px solid #5683cf;
            background: #fff;
            text-decoration: none;
            transition: .3s
        }

        .back-btn:hover {
            background: #5683cf;
            color: #fff;
            transform: scale(1.02)
        }

        @media(max-width:900px) {
            .container {
                flex-direction: column;
                width: 90%
            }

            .image-side {
                display: none
            }

            .content {
                padding: 40px 30px
            }

            .text {
                font-size: 24px
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="image-side">
            <img src="{{ asset('assets/img/about 2.png') }}" alt="Login Illustration">
        </div>

        <div class="content">
            <div class="text">Masuk ke Akun</div>

            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <div class="field">
                    <input type="text" name="email" value="{{ old('email') }}" required />
                    <span class="fas fa-user"></span>
                    <label>Email</label>
                </div>

                <div class="field">
                    <input type="password" name="password" required />
                    <span class="fas fa-lock"></span>
                    <label>Kata Sandi</label>
                </div>

                <button type="submit">Masuk</button>
            </form>

            <div class="demo-box">
                <h4>🔐 Akun Demo (Email & Password)</h4>
                <div class="demo-item">
                    <span class="demo-role">Admin Utama</span>
                    <span class="demo-cred">admin@gmail.test | 1234</span>
                </div>
                <div class="demo-item">
                    <span class="demo-role">Admin Job Fair</span>
                    <span class="demo-cred">bkk@gmail.test | 1234</span>
                </div>
                <div class="demo-item">
                    <span class="demo-role">Guru</span>
                    <span class="demo-cred">rafirpl@gmail.com | 1234</span>
                </div>
                <div class="demo-item">
                    <span class="demo-role">Alumni</span>
                    <span class="demo-cred">demo.alumni@gmail.test | 1234</span>
                </div>
                <div class="demo-item">
                    <span class="demo-role">Siswa</span>
                    <span class="demo-cred">demo.siswa@gmail.test | 1234</span>
                </div>
            </div>

            <a href="{{ url('/') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</body>

</html>
