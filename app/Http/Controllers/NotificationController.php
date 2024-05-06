<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notification($id)
    {
        try{
            $user = auth()->user();

            if (!$user) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            if($user->id !== (int) $id){
                return response()->json(['status' => 401, 'error' => 'Unauthorized'], 401);
            }

            $filteredNotifications = $user->notifications->where('data.user_id', $id);

            return response()->json($filteredNotifications);
        } 
        catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => 'Something wrong!.'], 500);
        }
    }
}
