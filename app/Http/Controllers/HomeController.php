<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MongoDB\Driver\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request['logout']) {
            Auth::logout();
            return redirect()->route('admin');
        }
        return view('home');
    }

    public function Users(Request $request)
    {
        $meta['h1']='Управление пользователями';
        $message = 0;
        //Активация пользователя
        if (isset($request->submit_activation)) {
            $user = User::find($request->submit_activation);
            $user->active = 1;
            $user->save();
        }
        //Деактивация пользователя
        if (isset($request->submit_deactivation)) {
            $user = User::find($request->submit_deactivation);
            $user->active = 0;
            $user->save();
        }
        //Удаление пользователя
        if (isset($request->submit_delete)) {
            $user = User::find($request->submit_delete);
            $user->delete();
        }
        //Если нажали кнопку "Редактировать"
        if (isset($request->submit_edit)) {
            $edit_user = User::find($request->submit_edit);
        } else {
            $edit_user = false;
        }
        //Редактирование пользователя
        if (isset($request->submit_edit_end)) {
            $user = User::find($request->submit_edit_end);
            $user->name = $request->edit['name'];
            if (count(User::withTrashed()->where('email', '=', $request->edit['email'])->where('email', '!=', $user->email)->get()) > 0) {
                $message = 'Введённый Email уже существует. У пользователя сохранился старый: ' . $user->email;
            } else {
                $user->email = $request->edit['email'];
            }

            $user->active = $request->edit['active'];
            if (!empty($request->edit['phone'])) {
                $user->phone = $request->edit['phone'];
            }
            $user->save();
        }
        //Добавление пользователя
        if (isset($request->submit_add_user)) {
            dump($request->request);
            $user = new User;
            $user->name = $request->add['name'];
            if (count(User::where('email', '=', $request->add['email'])->get())) {
                $message = 'Пользователь с таким Email существует';
            } else {
                $user->email = $request->add['email'];
                $user->password = Hash::make($request->add['password']);
                $user->active = 1;
                $user->save();
            }


        }

        if ($request['logout']) {
            Auth::logout();
            return redirect()->route('admin');
        }
        return view('admin.users', [
            'meta' => $meta,
            'users' => User::all(),
            'edit_user' => $edit_user,
            'message' => $message,
            'add_user' => $request->add_user
        ]);
    }
}

