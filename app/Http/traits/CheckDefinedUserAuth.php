<?php
namespace App\Http\traits;

use Exception;

trait CheckDefinedUserAuth {

    public function login()
    {   
        try {

            $input = request()->all();
            $this->validate(request(), [
                'email'     => 'required|email',
                'password'  => 'required',
            ]);

            $authCheck = auth()->attempt([
                'email'     => $input['email'], 
                'password'  => $input['password']
            ],request()->filled('remember'));

            if(!$authCheck)
                throw new Exception("Invalid Credentials!", 403);

            if(auth()->check() && auth()->user()->isGuest()){
                return redirect($this->redirectTo);
            }

            return redirect()->route('dashboard.index');    

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors($e->getMessage())->withInput();
        }
    }

}