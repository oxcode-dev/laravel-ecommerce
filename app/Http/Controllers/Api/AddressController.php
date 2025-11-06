<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;

class AddressController extends BaseController
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        $cacheKey = 'user_addresses_' . $request->get('sortField', 'created_at') . '_sort_by_' .  $request->get('sortAsc') === 'true' ? 'asc' : 'desc'

        $addresses = Address::search($request->get('search', ''))
            ->where('user_id', $user->id)
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )->get();
            // ->paginate($request->get('perPage', 20));

        return $this->sendResponse(
            $addresses,
            'Addresses fetched successfully!!!.',
        );
    }

    public function show(Request $request, Address $address)
    {
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        $address = Address::search($request->get('search', ''))
            ->where('user_id', $user->id)
            ->whereId($address->id)
            ->first();

        return $this->sendResponse(
            $address,
            'Address fetched successfully!!!.',
        );
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        $validator = Validator::make($request->all(), [
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => [ 'required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error Occurred.', $validator->errors());       
        }

        $address = new Address();

        $this->storeAddress($request, $address);

        return $this->sendResponse(
            ['response' => 'Address Saved successfully'],
            'Address Saved successfully!!!.',
        );

    }

    public function update(Request $request, Address $address)
    {
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        $validator = Validator::make($request->all(), [
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => [ 'required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error Occurred.', $validator->errors());       
        }

        $this->storeAddress($request, $address);

        return $this->sendResponse(
            ['response' => 'Address Updated successfully'],
            'Address Updated successfully!!!.',
        );
    }

    public function destroy(Request $request, Address $address)
    {
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        $address->delete();

        return $this->sendResponse(
            ['response' => 'Address deleted successfully'],
            'Address deleted successfully!!!.',
        );
    }

    private function storeAddress($request, $address)
    {
        $input = $request->all();

        $address->user_id = $request->user()['id'];
        $address->street = $input['street'];
        $address->city = $input['city'];
        $address->state = $input['state'];
        $address->postal_code = $input['postal_code'];

        $address->save();
    }
}
