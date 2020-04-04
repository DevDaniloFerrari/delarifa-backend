<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
use App\User;
use App\Rules\password; 

class UserController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       $users = User::all();
 
       return $users;
   }
 
   /**
    * Store a newly created resource in storage.
    *
    */
   public function store(Request $request)
   {
        $userData = $request->all();

        $validation = array(
            'email' => 'required|email|unique:users,email',
            'password' => ['required', new password, 'confirmed'],
            'name' => 'required'
        );

        $messages = array(
            'email.required' => 'Email obrigatório',
            'email.unique' => 'Este email já foi cadastrado, por favor insira outro',
            'password.required' => 'Senha é obrigatória',
            'password.confirmed' => 'As senhas não coincidem por favo tente novamente',
            'name.required' => 'O campo nome é obrigatório',
            'email.email' => 'Por favor insira um endereço de e-mail valido'
        );

        $validator = Validator::make($userData, $validation, $messages);

        if($validator->fails()){
            return $validator->errors();       
        }

        $user = User::create($userData);

       return $user ? response()->json(['message' => 'Usuário cadastrado com sucesso
       ', 'code' => 200]) : response()->json(['message' => 'Não foi possível completar o cadastro', 'code' => 400]);
   }
}