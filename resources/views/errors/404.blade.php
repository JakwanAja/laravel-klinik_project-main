<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>

    <!-- Tambahkan Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tambahkan Google Fonts untuk font menarik -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Mengganti font ke Poppins */
            background-color: #f8f9fa;
            color: #343a40;
            height: 100vh;
            margin: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            text-align: center;
        }
        p {
            font-size: 20px;
            margin-bottom: 20px;
        }
        h6 {
            margin-bottom: 20px;
            font-weight: 600;
        }
        a {
            text-decoration: none;
            color: #fff;
        }
        .btn-custom {
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Ganti 404 dengan gambar yang telah diatur ukurannya -->
                <img src="{{ asset('modern/src/assets/images/backgrounds/searching1.png') }}" alt="Page Not Found" class="img-fluid">
                <p>Waduh, tujuanmu nggak ada.</p>
                <h6>Mungkin kamu salah  Jurusan, Ayo balik sebelum nyesel!</h6>
                <!-- Button menggunakan Bootstrap -->
                <a href="{{ url('/home') }}" class="btn btn-primary">Balik ke Home</a>
            </div>
        </div>
    </div>

    <!-- Tambahkan Bootstrap JS dan dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
