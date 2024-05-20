<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Hihi</title>
    <link rel="stylesheet" href="login/login.css">

    <style>
        .hide {
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <img src="login/images/user2.png" alt="Logo" class="logo">
        <h2>Login</h2>
        <form id="loginFormElement" method="POST" class="active-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        
        <form id="otpFormElement" method="POST" class="hide">
            <h2>Enter OTP</h2>
            <div class="form-group">
                <label for="otpEmail">Email</label>
                <input type="email" id="otpEmail" name="email" required readonly>
            </div>
            <div class="form-group">
                <label for="otp">OTP</label>
                <input type="text" id="otp" name="otp_code" required>
            </div>
            <button type="submit">Verify OTP</button>
        </form>
    </div>
    <p id="message"></p>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('loginFormElement').addEventListener('submit', function(event) {
                event.preventDefault();

                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;

                var data = {
                    email: email,
                    password: password,
                }

                fetch("http://127.0.0.1:8000/api/login", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    body: JSON.stringify(data),
                })
                .then((res) => {
                    return res.json();
                })
                .then(res => {
                    console.log(res);
                    if(res.message === 'OTP sent successfully') {
                        document.getElementById('otpEmail').value = email;
                        document.getElementById('loginFormElement').classList.add('hide');
                        document.getElementById('otpFormElement').classList.remove('hide');
                    } else {
                        document.getElementById('message').textContent = res.message;
                    }
                })
                .catch(error => {
                    console.error("Something went wrong with your fetch!", error);
                });
            });

            
            // Handle OTP form submission
            document.getElementById('otpFormElement').addEventListener('submit', function(event) {
                event.preventDefault();

                var email = document.getElementById('otpEmail').value;
                var otp = document.getElementById('otp').value;

                var data = {
                    email: email,
                    otp_code: otp,
                }

                fetch("http://127.0.0.1:8000/api/verify", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer' + localStorage.getItem('token')
                    },
                    body: JSON.stringify(data),
                })
                .then((res) => {
                    return res.json();
                })
                .then(res => {
                    if(res.status) {
                        console.log(res.message);
                        localStorage.setItem('token', res.token);
                        window.location.href = '/home';
                    } else {
                        document.getElementById('message').textContent = res.message;
                    }
                })
                .catch(error => {
                    console.error("Something went wrong with your fetch!", error);
                });
            });
        });
    </script>
</body>
</html>
