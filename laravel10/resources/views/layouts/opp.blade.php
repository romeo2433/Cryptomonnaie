<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>

  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <style>
    .dashboard-container {
    display: flex;
    min-height: 100vh;
}

    .sidebar {
    position: relative !important; /* <-- très important */
    width: 260px;
    height: auto;
    background-color: #2c3e50;
    padding: 20px;
}

.main-content {
    flex: 1;
    padding: 20px;
    background-color: #f9f9f9;
}
  </style>
</head>
<body>

  @include('layouts.header2')

  <div class="dashboard-container">
    @include('layouts.sidebar2') <!-- ici ton <aside class="sidebar"> -->

    <main class="main-content">
      @yield('content')
    </main>
  </div>

  @include('layouts.footer2')

</body>
</html>
