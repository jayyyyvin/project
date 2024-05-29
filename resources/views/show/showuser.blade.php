@extends('home')

@section('content')

<div class="content">
            <h2>User Table</h2>
            <a href="/create-user"><button class="add-new-button">Add New</button></a>
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

@endsection

