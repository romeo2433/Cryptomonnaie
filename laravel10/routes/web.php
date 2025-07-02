<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserVueController;
use App\Http\Controllers\AuthVueController;
use App\Http\Controllers\PortefeuilleController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EvenementPortefeuilleController;
use App\Http\Controllers\AchatCryptomonnaieController;
use App\Http\Controllers\VenteCryptomonnaieController;
use App\Http\Controllers\AnalyseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HistoriqueController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//inscription
Route::get('inscription', [UserVueController::class, 'index'])->name('inscription');
Route::post('inscription', [UserVueController::class, 'store']);

//login
Route::view('/login', 'connection.login')->name('login');
Route::post('/login', [AuthVueController::class, 'login'])->name('login.post');

// Route pour afficher le formulaire de vérification de l'OTP
Route::get('/otp/verify', [AuthVueController::class, 'showOtpForm'])->name('otp.verify');
Route::post('otp/verify', [AuthVueController::class, 'verifyOtp'])->name('otp.verify.submit');

// Route pour se déconnecter
Route::post('/logout', [AuthVueController::class, 'logout'])->name('logout');


Route::get('/portefeuille', [PortefeuilleController::class, 'showDashboard'])->name('portefeuille.dashboard');
Route::middleware('auth')->get('/portefeuille', [PortefeuilleController::class, 'showDashboard'])->name('portefeuille.dashboard');

// Route pour afficher le formulaire de transaction
//Route::get('/evenement/create', [EvenementPortefeuilleController::class, 'showForm'])->name('evenement.create');
//Route::post('/evenement/store', [EvenementPortefeuilleController::class, 'store'])->name('evenement.store');
Route::get('/portefeuille/evenement', [EvenementPortefeuilleController::class, 'showEvenement'])->name('portefeuille.evenement');
Route::get('/evenement/create', [EvenementPortefeuilleController::class, 'showForm'])->name('evenement.create');
Route::post('/evenement/store', [EvenementPortefeuilleController::class, 'store'])->name('evenement.store');
//Route::get('/dashboard', [EvenementPortefeuilleController::class, 'showForm'])->name('portefeuille.dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/achat', [AchatCryptomonnaieController::class, 'index'])->name('achat.index');
    Route::post('/achat', [AchatCryptomonnaieController::class, 'acheter'])->name('achat.acheter');
});
Route::get('/transactions', [AchatCryptomonnaieController::class, 'listeTransactions'])->name('transactions.liste');

Route::middleware(['auth'])->group(function () {
    Route::get('/vente', [VenteCryptomonnaieController::class, 'index'])->name('vente.index');
    Route::post('/vente', [VenteCryptomonnaieController::class, 'vendre'])->name('cryptomonnaies.vendre');
});

//total achat 
Route::middleware(['auth'])->group(function () {
Route::get('/achats/totaux', [AchatCryptomonnaieController::class, 'totalAchatParCryptomonnaie'])->name('achats.totaux');
});


Route::get('/vente/effectuer', [TransactionController::class, 'create'])->name('vente.create');
Route::post('/vente/effectuer', [TransactionController::class, 'effectuerVente'])->name('vente.effectuer');


Route::get('analyse/form', [AnalyseController::class, 'analyseForm'])->name('analyse.form');
Route::post('analyse/calculate', [AnalyseController::class, 'calculate'])->name('analyse.calculate');


Route::get('/admin/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register.submit');


// Afficher le formulaire de connexion
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
// Traiter la soumission du formulaire de connexion
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
// Déconnexion
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return 'Bienvenue sur le tableau de bord admin !';
    })->name('admin.dashboard');
});


// Route pour afficher les transactions en attente
Route::get('/admin/transactions', [EvenementPortefeuilleController::class, 'showTransactionsEnAttente'])
    ->name('admin.transactions');

// Route pour valider ou rejeter une transaction
Route::post('/admin/transactions/{id}', [EvenementPortefeuilleController::class, 'validerTransaction'])
    ->name('admin.valider.transaction');


Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

//Route::get('/historique', [HistoriqueController::class, 'index'])->name('historique.index');

Route::get('/historique/admin', [TransactionController::class, 'index'])->name('transactions.index');

Route::prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{id}', [AdminController::class, 'show'])->name('admin.users.show');
});

Route::put('/admin/users/{user}/update-avatar', [AdminController::class, 'updateAvatar'])->name('admin.users.update_avatar');


Route::get('/admin/users/{id}/historique', [EvenementPortefeuilleController::class, 'historiqueParUtilisateur'])
     ->name('admin.users.historique');
