<x-layouts.app title="Login">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card shadow-lg border-0 p-4">
                    <div class="card-body">
                        <h2 class="mb-4 fw-bold text-primary text-center">Sign in to CyberBlog</h2>
                        <form action="{{route('login')}}" method="POST" id="loginForm">
                            @csrf
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control rounded-pill" id="loginEmail" placeholder="Enter your email" name="email" required autofocus>
                            </div>
                            <div class="mb-4">
                                <label for="loginPassword" class="form-label fw-semibold">Password</label>
                                <input type="password" class="form-control rounded-pill" id="loginPassword" placeholder="Enter your password" name="password" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold">Login</button>
                                <a href="{{route('register')}}" class="text-primary fw-semibold">Register</a>
                            </div>
                        </form>
                        @if(app()->environment('local'))
                        <div class="mt-5">
                            <h4 class="fw-bold">Test Users</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="testUsersTable">
                                    <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-email="admin@example.com" data-password="password" style="cursor:pointer;">
                                            <td><span class="badge bg-primary">Admin</span></td>
                                            <td>admin@example.com</td>
                                            <td>password</td>
                                        </tr>
                                        <tr data-email="user@example.com" data-password="password" style="cursor:pointer;">
                                            <td><span class="badge bg-info">User</span></td>
                                            <td>user@example.com</td>
                                            <td>password</td>
                                        </tr>
                                        <tr data-email="hacker@example.com" data-password="password" style="cursor:pointer;">
                                            <td><span class="badge bg-danger">Hacker</span></td>
                                            <td>hacker@example.com</td>
                                            <td>password</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const table = document.getElementById('testUsersTable');
                                if(table) {
                                    table.querySelectorAll('tbody tr').forEach(function(row) {
                                        row.addEventListener('click', function() {
                                            document.getElementById('loginEmail').value = this.getAttribute('data-email');
                                            document.getElementById('loginPassword').value = this.getAttribute('data-password');
                                        });
                                        row.addEventListener('mouseenter', function() {
                                            this.style.backgroundColor = '#e3f2fd';
                                        });
                                        row.addEventListener('mouseleave', function() {
                                            this.style.backgroundColor = '';
                                        });
                                    });
                                }
                            });
                        </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>