<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('portefeuille.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard -->

        <li class="nav-heading">Gestion des Transactions</li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#transaction-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-arrow-left-right"></i><span>Transactions</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="transaction-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('evenement.create') }}">
                        <i class="bi bi-circle"></i><span>Faire une Transaction</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('portefeuille.evenement') }}">
                        <i class="bi bi-circle"></i><span>Historique Dépôts & Retraits</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Transactions -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#crypto-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-currency-bitcoin"></i><span>Cryptomonnaies</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="crypto-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('achat.index') }}">
                        <i class="bi bi-circle"></i><span>Achat Cryptomonnaies</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('vente.create') }}">
                        <i class="bi bi-circle"></i><span>Vendre des Cryptomonnaies</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('achats.totaux') }}">
                        <i class="bi bi-circle"></i><span>Voir mes cryptomonnaies</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Cryptomonnaies -->

        <!-- Ajouter l'option Analyse -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#analyse-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart"></i><span>Analyse</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="analyse-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('analyse.form') }}">
                        <i class="bi bi-circle"></i><span>Faire une Analyse</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Analyse -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#factures-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-receipt"></i><span>Factures</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="factures-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('transactions.liste') }}">
                        <i class="bi bi-circle"></i><span>Voir mes Factures</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Factures -->

        <li class="nav-heading">Administration</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>
        </li><!-- End Logout -->
    </ul>
</aside>


<style>
    .sidebar {
        width: 250px;
        min-height: 100vh;
        background: #f8f9fa;
        padding: 15px;
        position: fixed;
        top: 60px;
        left: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
        opacity: 0;
        transform: translateX(-100%);
    }

    .sidebar.loaded {
        opacity: 1;
        transform: translateX(0);
    }

    .nav-item .nav-link {
        display: flex;
        align-items: center;
        padding: 10px;
        font-size: 16px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
    }

    .nav-item .nav-link i {
        margin-right: 10px;
    }

    .nav-item .nav-link:hover {
        background: #007bff;
        color: white;
        border-radius: 5px;
    }

    .nav-content {
        padding-left: 20px;
    }

    .nav-content a {
        display: block;
        padding: 8px;
        font-size: 14px;
        color: #555;
    }

    .nav-content a:hover {
        color: #007bff;
    }
</style>

<script>
    // Animation d'apparition de la sidebar
    window.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.sidebar').classList.add('loaded');
    });
</script>
