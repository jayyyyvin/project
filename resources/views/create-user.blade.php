@extends('home')

@section('content')

<div class="content">
    <div class="container create-user-container">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2 class="mb-0">Create New User</h2>
            </div>
            <div class="card-body">
                <form id="createUserForm">
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
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('createUserForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const createUserForm = document.getElementById('createUserForm');
        const formData = new FormData(createUserForm);
        fetch('/api/create', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            body: formData,
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            console.log(data);

            if(data.status) {
                alert('Success Create User');
                window.location.href = '/showuser';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
@endsection
