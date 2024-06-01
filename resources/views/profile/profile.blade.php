<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 30px;
            color: #00796b;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #00796b;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #b2dfdb;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            color: #00796b;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #004d40;
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #004d40;
        }

        #result {
            margin-top: 20px;
            color: #004d40;
        }

        #avatar {
            display: block;
            margin: 0 auto 30px auto;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #00796b;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Profile Form</h2>
        <img id="avatar" src="" alt="Avatar" hidden>
        <form id="profile-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" disabled>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" disabled>
        </form>
        <div id="result"></div>
    </div>
    <script>
        fetch('/api/myUser', {
            method: 'GET',
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token'),
                Accept: 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('name').value = data.name;
            document.getElementById('email').value = data.email;
            const avatar = document.getElementById('avatar');
            avatar.src = "{{ asset('storage/') }}" + "/" + data.avatar;
            avatar.hidden = false;
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
        });
    </script>
</body>
</html>
