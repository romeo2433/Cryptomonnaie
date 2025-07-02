<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use App\Mail\OtpMail;

class AuthVueController extends Controller
{
    const MAX_ATTEMPTS = 3;
    const LOCKOUT_TIME = 300; // Temps de verrouillage après trop de tentatives
    const LOCKOUT_MESSAGE = 'Trop de tentatives. Réessayez dans 5 minutes.';
    const INVALID_CREDENTIALS_MESSAGE = 'Identifiants incorrects.';
    const OTP_SENT_MESSAGE = 'OTP envoyé à votre adresse email.';

    /**
     * Méthode principale pour gérer la connexion
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->isLockedOut($request)) {
            return $this->lockoutResponse();
        }

        if ($this->attemptLogin($request)) {
            return $this->sendOtp($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->invalidCredentialsResponse();
    }

    /**
     * Valider les champs du formulaire
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);
    }

    /**
     * Vérifier si l'utilisateur est bloqué après trop de tentatives
     */
    protected function isLockedOut(Request $request)
    {
        return RateLimiter::tooManyAttempts($this->getRateLimiterKey($request), self::MAX_ATTEMPTS);
    }

    /**
     * Réponse de blocage en cas de trop de tentatives
     */
    protected function lockoutResponse()
    {
        return redirect()->back()->with('error', self::LOCKOUT_MESSAGE);
    }

    /**
     * Tenter de connecter l'utilisateur avec les identifiants
     */
    protected function attemptLogin(Request $request)
    {
        return Auth::attempt($request->only('email', 'password'));
    }

    /**
     * Envoie un OTP à l'utilisateur et l'enregistre en base de données
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
    
        // Enregistrer l'email dans la session
        session(['email' => $request->input('email')]);
    
        // Générer et enregistrer l'OTP dans la base de données
        $otp = rand(100000, 999999);
        DB::table('otp_verifications')->updateOrInsert(
            ['email' => $request->input('email')],
            [
                'otp' => $otp,
                'created_at' => now(),
            ]
        );
    
        // Envoyer l'OTP par email
        Mail::to($request->input('email'))->send(new OtpMail($otp));
    
        // Rediriger vers la page de vérification OTP
        return redirect()->route('otp.verify')
            ->with('success', 'OTP envoyé à votre adresse email.');
    }
    

    /**
     * Incrémente le compteur des tentatives échouées
     */
    protected function incrementLoginAttempts(Request $request)
    {
        RateLimiter::hit($this->getRateLimiterKey($request));
    }

    /**
     * Retourne la clé d'identifiant pour le verrouillage
     */
    protected function getRateLimiterKey(Request $request)
    {
        return 'login_' . $request->ip();
    }

    /**
     * Retourne une réponse en cas d'identifiants incorrects
     */
    protected function invalidCredentialsResponse()
    {
        return redirect()->back()->with('error', self::INVALID_CREDENTIALS_MESSAGE);
    }
    public function showOtpForm()
    {
        return view('otp.verify');  // La vue 'otp.verify' sera utilisée pour afficher le formulaire OTP
    }
    public function verifyOtp(Request $request)
{
    // Valider l'OTP
    $request->validate([
        'otp' => 'required|numeric',
    ]);

    // Récupérer l'email de la session
    $email = session('email');
    if (!$email) {
        return back()->with('error', 'Aucun email trouvé dans la session.');
    }

    $otp = $request->input('otp');

    // Vérifier l'OTP dans la base de données
    $otpRecord = DB::table('otp_verifications')
        ->where('email', $email)
        ->where('created_at', '>=', now()->subMinutes(5)) // Vérifier si l'OTP est valide (ici, 5 minutes)
        ->first();

    if (!$otpRecord) {
        DB::table('otp_verifications')->where('email', $email)->delete(); // Supprimer l'OTP expiré
        return back()->with('error', 'Aucun OTP trouvé pour cet email ou il a expiré.');
    }

    // Comparer les OTP
    if ((int)$otpRecord->otp === (int)$otp) {
        // OTP valide, continue le processus
        DB::table('otp_verifications')->where('email', $email)->delete(); // Supprimer l'OTP après vérification
        return redirect()->route('portefeuille.dashboard')->with('success', 'OTP vérifié avec succès.');
    } else {
        // OTP invalide
        return back()->with('error', 'Le code OTP est incorrect.');
    }
}

public function showDashboard()
{
    // Logique pour afficher le tableau de bord du portefeuille
    $user = Auth::user();
    return view('portefeuille.dashboard', compact('user'));
}



}
