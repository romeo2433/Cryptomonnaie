<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard -->

        <li class="nav-heading">Gestion des Transactions</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.transactions') }}">
                <i class="bi bi-arrow-left-right"></i>
                <span>Transactions en attente</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('transactions.index') }}">
                <i class="bi bi-clock-history"></i>
                <span>Historique des Transactions</span>
            </a>
        </li>

        <li class="nav-heading">Gestion des Utilisateurs</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people"></i>
                <span>Utilisateurs</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('notifications.index') }}">
                <i class="bi bi-bell"></i>
                <span>Notifications</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('stats.index') }}">
                <i class="bi bi-bar-chart"></i>
                <span>Statistiques</span>
            </a>
        </li>
        

       

        <li class="nav-heading">Administration</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.login') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>              
        </li>
    </ul>
</aside>
