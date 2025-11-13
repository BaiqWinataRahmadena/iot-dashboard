<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-g" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
      href="https://fonts.bunny.net/css?family=nunito:400,600,700"
      rel="stylesheet"
    />

    @vite(['resources/css/custom-layout.css'])

    @stack('styles')
  </head>
  <body>
    <div class="app-layout">
      <aside class="sidebar">
        <div class="sidebar-header">IoT Dashboard</div>
        <nav class="sidebar-nav">
          <a
            href="{{ route('dashboard') }}"
            class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >Dashboard</a
          >
          <a
            href="{{ route('pelanggan.index') }}"
            class="{{ request()->routeIs('pelanggan.index') ? 'active' : '' }}"
            >Pelanggan</a
          >
          <a
            href="{{ route('users.index') }}"
            class="{{ request()->routeIs('users.index') ? 'active' : '' }}"
            >Karyawan</a
          >
        </nav>
        <div class="sidebar-footer">
          <button id="theme-toggle" class="theme-toggle-btn">
            Mode Gelap
          </button>
        </div>
      </aside>

      <div class="main-content">
        <header class="main-header">
          <div class="profile-dropdown">
            <button id="profile-button" class="profile-button">
              {{ substr(Auth::user()->name, 0, 1) }}
            </button>

            <div id="dropdown-menu" class="dropdown-menu">
              <div class="dropdown-header">
                <p class="dropdown-header-name">{{ Auth::user()->name }}</p>
                <p class="dropdown-header-email">{{ Auth::user()->email }}</p>
              </div>
              <a href="{{ route('profile.edit') }}" class="dropdown-item"
                >Profile</a
              >
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type-="submit" class="dropdown-item">Logout</button>
              </form>
            </div>
          </div>
        </header>

        <main class="page-content">
          <div class="page-header">
            <h1>@yield('header')</h1>
            </div>

            @yield('content')
        </main>
      </div>
    </div>

    @vite(['resources/js/custom-layout.js'])

    @stack('scripts')
  </body>
</html>