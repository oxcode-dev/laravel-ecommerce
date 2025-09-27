<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends BaseController
{
    public function index(Request $request)
    {
        $user = $request->user();

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

    public function store(Request $request)
    {
        
    }

    public function show(Request $request, Address $address)
    {
        $user = $request->user();

        if (! $user) {
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

    public function update(Request $request, Address $address)
    {
        
    }

    public function destroy(Request $request, Address $address)
    {
        $user = $request->user();

        if (! $user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        $address->delete();

        return $this->sendResponse(
            ['response' => 'Address deleted successfully'],
            'Address deleted successfully!!!.',
        );
    }
}
