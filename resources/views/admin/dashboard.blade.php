<x-layouts.app title="Dashboard">
  <div class="container py-5">
    <div class="row mb-5">
      <div class="col-12 text-center">
        <h1 class="display-4 fw-bold text-primary mb-3"><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</h1>
        <p class="lead text-muted">Manage your platform with style and efficiency</p>
      </div>
    </div>
    <div class="row justify-content-center g-4">
      <div class="col-12 col-md-6 col-lg-3">
        <a href="{{route('admin.users')}}" class="text-decoration-none">
          <div class="card shadow-lg border-0 dashboard-card h-100 text-center p-4 position-relative" style="background: linear-gradient(135deg, #00c6ff 0%, #1976d2 100%); color: #fff; transition: transform .2s, box-shadow .2s; cursor:pointer;">
            <div class="mb-3"><i class="bi bi-people display-3"></i></div>
            <h3 class="fw-bold mb-2">Users</h3>
            <p class="mb-0">Manage all users and roles</p>
          </div>
        </a>
      </div>
      <div class="col-12 col-md-6 col-lg-3">
        <a href="{{route('admin.articles')}}" class="text-decoration-none">
          <div class="card shadow-lg border-0 dashboard-card h-100 text-center p-4 position-relative" style="background: linear-gradient(135deg, #1976d2 0%, #00c6ff 100%); color: #fff; transition: transform .2s, box-shadow .2s; cursor:pointer;">
            <div class="mb-3"><i class="bi bi-journal-text display-3"></i></div>
            <h3 class="fw-bold mb-2">Articles</h3>
            <p class="mb-0">Review and publish articles</p>
          </div>
        </a>
      </div>
      <div class="col-12 col-md-6 col-lg-3">
        <a href="{{route('admin.users')}}" class="text-decoration-none">
          <div class="card shadow-lg border-0 dashboard-card h-100 text-center p-4 position-relative" style="background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%); color: #fff; transition: transform .2s, box-shadow .2s; cursor:pointer;">
            <div class="mb-3"><i class="bi bi-folder2-open display-3"></i></div>
            <h3 class="fw-bold mb-2">Documents</h3>
            <p class="mb-0">Access and manage documents</p>
          </div>
        </a>
      </div>
      <div class="col-12 col-md-6 col-lg-3">
        <a href="{{route('admin.articles')}}" class="text-decoration-none">
          <div class="card shadow-lg border-0 dashboard-card h-100 text-center p-4 position-relative" style="background: linear-gradient(135deg, #fc5c7d 0%, #6a82fb 100%); color: #fff; transition: transform .2s, box-shadow .2s; cursor:pointer;">
            <div class="mb-3"><i class="bi bi-gear display-3"></i></div>
            <h3 class="fw-bold mb-2">Settings</h3>
            <p class="mb-0">Platform configuration</p>
          </div>
        </a>
      </div>
    </div>
  </div>
  <style>
    .dashboard-card:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow: 0 8px 32px rgba(0,0,0,0.18);
      z-index: 2;
    }
  </style>
</x-layouts.app>