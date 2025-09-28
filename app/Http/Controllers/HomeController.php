<?php

namespace App\Http\Controllers;

use App\Http\Resources\HomeResource;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{

    use APIResponse;
    /**
     * Home Information API
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request){
        try {
            $user= Auth::user();
            $data = new HomeResource($user);
            return $this->sendResponse($data, "Data retrieved successfully.");
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }
}
