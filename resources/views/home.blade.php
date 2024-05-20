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
    <div class="container">
        <div class="sidebar">
            <h1>My Dashboard</h1>
            <ul class="nav-links">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Users</a></li>
                <li><a href="#" onclick="logout()"><i data-feather="grid"></i><span>Logout</span></a></li>
            </ul>
        </div>
        <div class="content">
            <h2>User Table</h2>
            <button class="add-new-button">Add New</button>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id = 'tableBody'>
                    <tr>
                        
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
    <script>
        fetch('/api/users', {
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer ' + localStorage.getItem('token') // Added space after 'Bearer'
            }
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(data => {
            console.log(data);
            
            const tablebody = document.getElementById('tableBody'); 

tablebody.innerHTML = '';

for(let i = 0; i < data.length; i++)
{
    const body = `<td>${data[i].id}</td>        
                <td>${data[i].name}</td>        
                <td>${data[i].email}</td> 
                <td>
                    <button class="edit-button">
                        <i class="fas fa-edit"></i> <!-- Font Awesome edit icon -->
                    </button>

                    <button class="delete-button">
                        <i class="fas fa-trash-alt"></i> <!-- Font Awesome delete icon -->
                    </button>
                </td>       
            `;
        tablebody.innerHTML += body;
}
        })
        .catch(error => {
            console.error("There was a problem with your fetch operation:", error);
            // Handle errors, for example, redirect to login page
            // window.location.href = '/'; // Redirect to login page
        });
    </script>   
   
   
   
   
   <script>
    
    function logout()
    {
        swal({
  title: "Are you sure?",
  text: "You want to logout?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    localStorage.removeItem('token');
    window.location.href = '/';
  }
});
    }

    
</script>
<script src="assets/sweetalert/sweetalert.min.js"></script>
</body>
</html>
