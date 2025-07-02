<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    const MAX_ATTEMPTS = 3; // Nombre de tentatives de connexion autorisées
    const LOCKOUT_TIME = 300; // Temps de verrouillage après trop de tentatives en secondes (5 minutes)

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
     * Validation de l'email et du mot de passe
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);
    }

    /**
     * Vérifie si l'utilisateur a atteint la limite de tentatives
     */
    protected function isLockedOut(Request $request)
    {
        return RateLimiter::tooManyAttempts($this->getRateLimiterKey($request), self::MAX_ATTEMPTS);
    }

    /**
     * Envoie une réponse lorsque l'utilisateur est verrouillé
     */
    protected function lockoutResponse()
    {
        return response()->json([
            'message' => 'Trop de tentatives de connexion. Veuillez réessayer plus tard.',
            'status' => 'error'
        ], 429);
    }

    /**
     * Tente de connecter l'utilisateur avec les identifiants fournis
     */
    protected function attemptLogin(Request $request)
    {
        return Auth::attempt($request->only('email', 'password'));
    }

    /**
     * Envoie l'OTP à l'utilisateur par email et stocke l'OTP dans la table
     */
    protected function sendOtp(Request $request)
    {
        $otp = $this->generateOtp();

        // Insérer ou mettre à jour l'OTP dans la table otp_verifications
        DB::table('otp_verifications')->updateOrInsert(
            ['email' => $request->input('email')], // Condition (email unique)
            [
                'otp' => $otp,
                'created_at' => now(), // Mettre à jour l'heure de création
            ]
        );

        // Envoi de l'OTP par email
        Mail::to($request->input('email'))->send(new OtpMail($otp));

        return response()->json([
            'message' => 'Connexion initiale réussie. Un OTP a été envoyé à votre email.',
            'status' => 'otp_sent'
        ], 200);
    }

    /**
     * Vérifie l'OTP pour l'utilisateur
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:otp_verifications,email',
            'otp' => 'required|integer',
        ]);

        $record = DB::table('otp_verifications')->where('email', $request->input('email'))->first();

        // Vérifie si l'OTP correspond et est encore valide (5 minutes)
        if ($record && $record->otp == $request->input('otp') && now()->diffInSeconds($record->created_at) <= 300) {
            // Supprime l'OTP après une vérification réussie
            DB::table('otp_verifications')->where('email', $request->input('email'))->delete();

            return response()->json([
                'message' => 'Connexion réussie.',
                'status' => 'success',
            ], 200);
        }

        return response()->json([
            'message' => 'OTP invalide ou expiré.',
            'status' => 'error',
        ], 400);
    }

    /**
     * Génère un OTP aléatoire
     */
    protected function generateOtp()
    {
        return rand(100000, 999999);
    }

    /**
     * Incrémente les tentatives de connexion échouées
     */
    protected function incrementLoginAttempts(Request $request)
    {
        RateLimiter::hit($this->getRateLimiterKey($request));
    }

    /**
     * Récupère la clé unique de RateLimiter
     */
    protected function getRateLimiterKey(Request $request)
    {
        return 'login_' . $request->ip();
    }

    /**
     * Réponse lorsque les identifiants sont invalides
     */
    protected function invalidCredentialsResponse()
    {
        return response()->json([
            'message' => 'Identifiants invalides.',
            'status' => 'error'
        ], 401);
    }
}
