<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
      @if(file_exists(public_path('')))
        <span class="text-primary fw-bold">The Order</span>
      @endif
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Catalog</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Orders</a></li>
      </ul>
      <ul class="navbar-nav ms-auto">
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="btn btn-primary" href="{{ route('register') }}">Sign Up</a></li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">Cart ({{ session('cart') ? count(session('cart')) : 0 }})</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" href="#" style="gap: 0.5rem;">
              <i class="bi bi-person-circle me-1" style="font-size: 1.25rem;"></i>
              <span>{{ auth()->user()->name }}</span>
              <i class="bi bi-chevron-down" style="font-size: 0.75rem;"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end" style="border-radius: 0.75rem; border: 1px solid rgba(0,0,0,0.1); box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
              <a class="dropdown-item" href="{{ route('profile.show') }}" style="padding: 0.75rem 1.25rem;">
                <i class="bi bi-person me-2 text-primary"></i>My Profile
              </a>
              <a class="dropdown-item" href="{{ route('profile.edit') }}" style="padding: 0.75rem 1.25rem;">
                <i class="bi bi-pencil-square me-2 text-info"></i>Edit Profile
              </a>
              <hr class="dropdown-divider my-2">
              @if(auth()->user()->role === 'seller')
                <a class="dropdown-item" href="{{ route('admin.dashboard') }}" style="padding: 0.75rem 1.25rem;">
                  <i class="bi bi-shop me-2 text-success"></i>Seller Dashboard
                </a>
              @else
                <a class="dropdown-item" href="{{ route('orders.index') }}" style="padding: 0.75rem 1.25rem;">
                  <i class="bi bi-box-seam me-2 text-warning"></i>My Orders
                </a>
              @endif
              <hr class="dropdown-divider my-2">
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="padding: 0.75rem 1.25rem;">
                <i class="bi bi-box-arrow-right me-2 text-danger"></i>Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
            </div>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
