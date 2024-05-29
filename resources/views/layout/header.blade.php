<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List User</title>
    <link rel="stylesheet" href="dashboard/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <script src="assets/sweetalert/sweetalert.min.js"></script>
    <script>
        const token = localStorage.getItem('token');

        if (!token) {
            window.location.href = '/';
        }
    </script>

</head>
<body>