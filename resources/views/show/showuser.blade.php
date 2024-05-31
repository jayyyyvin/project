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
        <tbody id="tableBody">
            <!-- User rows will be appended here -->
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetch('/api/users', {
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer ' + localStorage.getItem('token')
            }
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(data => {
            const tableBody = document.getElementById('tableBody'); 
            tableBody.innerHTML = '';

            data.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id}</td>        
                    <td>${user.name}</td>        
                    <td>${user.email}</td> 
                    <td>
                     <a href="/edituser/${user.id}"><button class="edit-button">
                            <i class="fas fa-edit"></i>
                        </button></a>
                        <button class="delete-button" onclick="deleteUser(${user.id})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error("There was a problem with your fetch operation:", error);
            // Handle errors, for example, redirect to login page
            // window.location.href = '/'; // Redirect to login page
        });
    });

    function deleteUser(userId) {
        swal({
            title: "Delete Confirmation",
            text: "Are you sure you want to delete this user?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then(willDelete => {
            if (willDelete) {
                const token = localStorage.getItem('token');
                fetch(`/api/delete/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token
                    }
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.status) {
                        swal({
                            title: "Good job!",
                            text: data.message,
                            icon: "success",
                            button: "Proceed",
                        }).then(() => {
                            window.location.href = '/showuser';
                        });
                    } else {
                        alert('Failed to delete user.');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }
</script>

@endsection
