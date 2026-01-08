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
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">{{ auth()->user()->name }}</a>
            <div class="dropdown-menu dropdown-menu-end">
              <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
            </div>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
