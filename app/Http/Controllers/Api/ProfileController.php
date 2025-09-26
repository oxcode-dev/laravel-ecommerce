<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\BaseController as BaseController;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends BaseController
{
    public function update(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [ 'required', 'string','lowercase', 'email', 'max:255',
                // Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['required', 'string', 'max:255'],
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();

        $request->user()->fill($input);
        $request->user()->save();

        return [$request->user(), $user];
        // $user = $user->save($input);

        $success['name'] =  $user->name;
        $success['first_name'] =  $user->first_name;
        $success['last_name'] =  $user->last_name;
        $success['email'] =  $user->email;
        $success['phone'] =  $user->phone;
        $success['avatar'] =  $user->avatar;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User Profile Updated Successfully.');
    }
}
