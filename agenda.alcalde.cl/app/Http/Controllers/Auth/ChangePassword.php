<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\DB;


class ChangePassword extends Controller
{
    use ResetsPasswords;   

    public function __construct()
    {
        // $this->middleware('auth');
    }   

    // Método para cambiar la contraseña
        public function changePassword(Request $request)
    {
        date_default_timezone_set('America/Santiago');
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'Las contraseñas ingresadas no coinciden..!',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        // Verificar si el correo existe en la base de datos
        $email = $request->post('email');
        $password = $request->post('password');

        $user = DB::table('users')->where('email', $email)->first();

        if ($user) {
            // Almacenar la nueva contraseña con hash y actualizar la columna updated_at
            DB::table('users')
                ->where('email', $email)
                ->update([
                    'password' => bcrypt($password),
                    'updated_at' => now(), // Actualizar con la fecha y hora actuales
                ]);

            return redirect()->route('login')->with('success', 'Contraseña cambiada exitosamente');
        } else {
            return redirect()->back()->with('message', 'Correo no encontrado');
        }
    }


    public function verificarEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $email = $request->post('email');

        $sql = 'SELECT * FROM users WHERE email = ? LIMIT 1';
        $user = DB::select($sql, [$email]);

        return response()->json(['exists' => !empty($user)]);
    }


}
