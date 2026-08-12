<nav class="navbar navbar-expand-lg sticky-top custom-navbar">
  <div class="container py-1">
    <!-- Brand Logo -->
    <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
      <div class="brand-icon">
        <i class="bi bi-shop text-primary"></i>
      </div>
      <span>Aplikasi <span class="text-primary-gradient">POS</span></span>
    </a>

    <!-- Toggle Button Mobile -->
    <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-list fs-2 text-white"></i>
    </button>

    <!-- Nav Items -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-lg-1">
        <li class="nav-item">
          <a class="nav-link custom-nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-grid-1x2 me-1"></i> Beranda
          </a>
        </li>

        @if(auth()->check() && strtolower(optional(auth()->user()->role)->name) === 'admin')
        <li class="nav-item">
          <a class="nav-link custom-nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
            <i class="bi bi-people me-1"></i> Pengguna
          </a>
        </li>
        @endif

        <li class="nav-item">
          <a class="nav-link custom-nav-link {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}">
            <i class="bi bi-box-seam me-1"></i> Produk
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link custom-nav-link {{ Request::is('penjualan*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">
            <i class="bi bi-cart-check me-1"></i> Penjualan
          </a>
        </li>
      </ul>

      <!-- User Profile & Logout Section -->
      <div class="d-flex align-items-center gap-3 pt-3 pt-lg-0 border-top border-lg-0 border-secondary border-opacity-25">
        @if(auth()->check())
        <div class="d-none d-xl-flex align-items-center gap-2 me-1 text-end">
            <div>
                <div class="fw-semibold text-white small mb-0">{{ auth()->user()->name }}</div>
                <div class="text-xs text-muted" style="font-size: 0.75rem; color: #94a3b8;">
                    {{ ucfirst(optional(auth()->user()->role)->name ?? 'User') }}
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('logout') }}" method="POST" class="m-0">
          @csrf
          <button type="submit" class="btn btn-logout-neon btn-sm px-3 py-1.5 rounded-pill d-flex align-items-center gap-2">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
          </button>
        </form>
      </div>

    </div>
  </div>
</nav>

<style>
  /* Custom Styling Navbar Dark Glassmorphism */
  .custom-navbar {
    background: rgba(15, 23, 42, 0.75) !important;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    transition: all 0.3s ease;
  }

  .brand-icon {
    width: 32px;
    height: 32px;
    background: rgba(99, 102, 241, 0.15);
    border: 1px solid rgba(99, 102, 241, 0.3);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .text-primary-gradient {
    background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .custom-nav-link {
    color: #94a3b8 !important;
    font-weight: 500;
    padding: 0.5rem 0.85rem !important;
    border-radius: 10px;
    transition: all 0.2s ease;
  }

  .custom-nav-link:hover {
    color: #f8fafc !important;
    background: rgba(255, 255, 255, 0.05);
  }

  .custom-nav-link.active {
    color: #fff !important;
    background: rgba(99, 102, 241, 0.2) !important;
    border: 1px solid rgba(99, 102, 241, 0.3);
    font-weight: 600;
  }

  .btn-logout-neon {
    background: rgba(239, 68, 68, 0.15);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.3);
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .btn-logout-neon:hover {
    background: #ef4444;
    color: #ffffff;
    box-shadow: 0 0 12px rgba(239, 68, 68, 0.4);
  }
</style>