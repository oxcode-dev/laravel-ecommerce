<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\BaseController as BaseController;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\UserResource;

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
            'email' => [ 'required', 'string','lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:255'],
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();

        $request->user()->fill($input);
        $request->user()->save();

        return $this->sendResponse(new UserResource($user), 'User Profile Updated Successfully.');
    }
}
