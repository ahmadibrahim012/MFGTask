<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\APIResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{

    use APIResponse;

    /**
     * Transfer Money API
     *
     * @return \Illuminate\Http\Response
     */
    public function transfer(Request $request)
    {
        try {
        $request->validate([
            'amount' => 'required',
            'receiver_id' => 'required',
        ]);
        $senderUser= Auth::user();
        $receiverUser = User::find($request->receiver_id);
        if(!$receiverUser){
            return $this->sendError("Received not found");
        }

        if($senderUser->balance < $request->amount){
            return $this->sendError("sender do not have enough balance");
        }

        DB::beginTransaction();
        $trx= new Transaction();
        $counter= DB::table('transactions')->max('counter') + 1;
        $trx->trx_number= "Transaction-" . $counter;
        $trx->amount= $request->amount;
        $today = Carbon::today()->format('Y-m-d');
        $trx->date= $today;
        $trx->sender_id = $senderUser->id;
        $trx->receiver_id= $receiverUser->id;
        $trx->counter= $counter;
        $trx->save();
        $senderUser->balance = $senderUser->balance  - $request->amount;
        $receiverUser->balance = $receiverUser->balance  + $request->amount;
        $senderUser->save();
        $receiverUser->save();
        DB::commit();
        return $this->sendResponse([],"Transfer was succefulyt done");

        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            DB::rollBack();
            return $this->generalError();
        }

    }

    /**
     * Transaction History API
     *
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request){
        try {
        $user= Auth::user();
        $data = Transaction::where('sender_id',$user->id)
            ->orWhere('receiver_id',$user->id)
            ->orderBy('date')
            ->get();
        $form = TransactionResource::collection($data);
        return $this->sendResponse($form, "data retreived succesff");
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }


    /**
     * User information API
     *
     * @return \Illuminate\Http\Response
     */
    public function userInfo($id){
        try {
            $user = User::find($id);
            if(!$user){
                return $this->sendError("User not found");
            }
            $form = new UserResource($user);
            return $this->sendResponse($form, "data retreived succesff");
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->generalError();
        }

    }



}
