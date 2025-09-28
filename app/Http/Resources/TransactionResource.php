<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userId = $request->user()->id;

        $isSender = $this->sender_id === $userId;
        $description = $isSender
            ? "You sent {$this->amount}$ to {$this->getReceiver->name} on {$this->date}"
            : "You received {$this->amount}$ from {$this->getSender->name} on {$this->date}";

        $action= $isSender ? "Send" : "Receive";
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'date' => $this->date,
            'sender'=>$this->getSender->name ,
            'receiver'=>$this->getReceiver->name,
            'description' => $description,
            'action'=>$action
        ];
    }
}
