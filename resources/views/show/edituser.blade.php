@extends('home')

@section('content')

<div class="content">
    <div class="container edit-user-container">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2 class="mb-0">Edit User</h2>
            </div>
            <div class="card-body">
                <form id="editUserForm">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password if you want to change">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userId = window.location.pathname.split('/').pop();
        const token = localStorage.getItem('token');

        // Fetch user data and populate the form
        fetch(`/api/getUser/${userId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
            }
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Failed to fetch user information');
            }
            return res.json();
        })
        .then(data => {
            document.getElementById('name').value = data.name;
            document.getElementById('email').value = data.email;
            document.getElementById('password').value = data.password;
        })
        .catch(error => {
            console.error('Failed to fetch user information:', error.message);
        });

        // Handle form submission
        document.getElementById('editUserForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            // Send updated user data to the server
            fetch(`/api/update/${userId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(res => {
                return res.json();
            })
            .then(data => {
                console.log('User information updated successfully:', data);
                if(data.status) {
                    alert('User updated successfully');
                    window.location.href = '/showuser'; // Adjust this URL as needed
                }
            })
            .catch(error => {
                console.error('Failed to update user information:', error.message);
                alert('An error occurred while updating the user');
            });
        });
    });
</script>
@endsection
