<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Metodo per la registrazione di un nuovo utente
    public function register(Request $request)
    {
        // Valida i dati della richiesta
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        
        // Crea un nuovo utente
        $user = \App\Models\User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
        
        // Genera un token Sanctum per l'utente
        $token = $user->createToken('API Token')->plainTextToken;
        
        // Restituisci una risposta JSON con il token
        return response()->json(['message' => 'Registrazione avvenuta con successo', 'token' => $token]);
    }
    
    
    // Metodo per l'autenticazione dell'utente
    public function login(Request $request)
    {
        // Valida i dati della richiesta
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        
        // Esegui il tentativo di accesso
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;
            
            return response()->json(['message' => 'Accesso avvenuto con successo', 'token' => $token]);
        }
        
        // Accesso fallito
        return response()->json(['message' => 'Credenziali non valide'], 401);
    }
    
}
