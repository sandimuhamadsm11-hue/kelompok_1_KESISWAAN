<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Siswa - Kesiswaan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: #07111f;
            color: white;
        }

        #loginPage {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(10px);
        }

        .circle1 {
            width: 350px;
            height: 350px;
            background: #146ef5;
            top: -120px;
            left: -100px;
            opacity: .35;
        }

        .circle2 {
            width: 300px;
            height: 300px;
            background: #7b4dff;
            right: -100px;
            bottom: -100px;
            opacity: .3;
        }

        .login-box {
            width: 420px;
            max-width: 90%;
            padding: 40px;
            border-radius: 25px;

            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.15);

            backdrop-filter: blur(20px);

            box-shadow: 0 25px 70px rgba(0,0,0,.45);

            z-index: 2;
        }

        .logo {
            width: 75px;
            height: 75px;
            margin: auto;

            display: flex;
            justify-content: center;
            align-items: center;

            border-radius: 22px;

            background: linear-gradient(
                135deg,
                #287cff,
                #684cff
            );

            box-shadow: 0 10px 30px rgba(40,124,255,.4);
        }

        .logo i {
            font-size: 32px;
        }

        .login-box h1 {
            text-align: center;
            margin-top: 18px;
            font-size: 27px;
            letter-spacing: 3px;
        }

        .subtitle {
            text-align: center;
            color: #9daec5;
            font-size: 13px;
            margin-top: 5px;
            margin-bottom: 30px;
        }

        .input-box {
            position: relative;
            margin-bottom: 17px;
        }

        .input-box > i:first-child {
            position: absolute;
            left: 17px;
            top: 50%;
            transform: translateY(-50%);
            color: #8ca0ba;
        }

        .input-box input {
            width: 100%;
            height: 55px;

            padding: 0 48px;

            border-radius: 14px;
            border: 1px solid rgba(255,255,255,.12);

            outline: none;

            background: rgba(255,255,255,.06);

            color: white;
            font-size: 14px;
        }

        .input-box input::placeholder {
            color: #8093ad;
        }

        .input-box input:focus {
            border-color: #3c87ff;
            box-shadow: 0 0 0 3px rgba(60,135,255,.12);
        }

        .eye {
            position: absolute;
            right: 17px;
            top: 50%;
            transform: translateY(-50%);
            color: #8ca0ba;
            cursor: pointer;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;

            font-size: 12px;
            color: #9daec5;

            margin: 5px 0 25px;
        }

        .options input {
            accent-color: #3c87ff;
        }

        .options a {
            color: #5c9cff;
            text-decoration: none;
        }

        .login-btn {
            width: 100%;
            height: 55px;

            border: none;
            border-radius: 14px;

            background: linear-gradient(
                135deg,
                #287cff,
                #684cff
            );

            color: white;

            font-weight: 600;
            letter-spacing: 1px;

            cursor: pointer;

            transition: .3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(40,124,255,.4);
        }

        .login-footer {
            text-align: center;
            color: #7186a1;
            font-size: 11px;
            margin-top: 25px;
        }

        .admin-login {
    width: 100%;
    height: 50px;

    margin-top: 15px;

    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;

    border: 1px solid rgba(255,255,255,.15);
    border-radius: 14px;

    background: rgba(255,255,255,.05);

    color: #9db0c8;
    text-decoration: none;

    font-size: 13px;
    font-weight: 500;

    transition: .3s;
}

.admin-login:hover {
    background: rgba(255,255,255,.1);
    color: white;
    border-color: #3c87fffa;
}





    </style>
</head>

<body>

<section id="loginPage">

    <div class="circle circle1"></div>
    <div class="circle circle2"></div>

    <div class="login-box">

        <div class="logo">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>

        <h1>SISWA</h1>

        <p class="subtitle">
            Sistem Informasi Kesiswaan
        </p>

        <form id="loginForm">

            <div class="input-box">

                <i class="fa-solid fa-user"></i>

                <input
                    type="text"
                    id="id_siswa"
                    placeholder="MASUKAN ID_SISWA"
                    required
                >

            </div>

            <div class="input-box">

                <i class="fa-solid fa-lock"></i>

                <input
                    type="password"
                    id="password"
                    placeholder="Password"
                    required
                >

                <i
                    class="fa-solid fa-eye eye"
                    id="togglePassword">
                </i>

            </div>

            <div class="options">

                <label>
                    <input type="checkbox">
                    Ingat saya
                </label>

            </div>


            <button class="login-btn" type="submit">
    LOGIN
    <i class="fa-solid fa-arrow-right"></i>
</button>


<a href="login.php" class="admin-login">
    <i class="fa-solid fa-user-shield"></i>
    Login sebagai Admin
</a>






        </form>

        <p class="login-footer">
            © 2026 Sistem Kesiswaan SMKN 1 MAJA
        </p>

    </div>

</section>


<script>

    const loginForm =
        document.getElementById("loginForm");

    const idSiswa =
        document.getElementById("id_Siswa");

    const password =
        document.getElementById("password");


    loginForm.addEventListener("submit", function(event) {

        event.preventDefault();

        
       // AKUN SISWA SEMENTARA
       
        if (
           
            password.value === "12345"
        ) {

            // Masuk ke DASHBOARD yang sama
            window.location.href = "halaman_siswa.php";

        } else {

            alert("Id siswa atau password salah!");

        }

    });


   
    //SHOW / HIDE PASSWORD
    

    const togglePassword =
        document.getElementById("togglePassword");

    togglePassword.addEventListener("click", function() {

        if (password.type === "password") {

            password.type = "text";

            togglePassword.classList.remove("fa-eye");

            togglePassword.classList.add("fa-eye-slash");

        } else {

            password.type = "password";

            togglePassword.classList.remove("fa-eye-slash");

            togglePassword.classList.add("fa-eye");

        }

    });

</script>

</body>
</html>