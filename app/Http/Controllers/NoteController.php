<?php

namespace App\Http\Controllers;

use App\Models\Note;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NoteNotification;
use App\Services\NoteService;
use App\Traits\ApiResponse; 

class NoteController extends Controller
{

    use ApiResponse;
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function notes()
    {
        //     $user = auth()->user();

        //     if($user->role !== 1){
        //         return response()->json(['status' => 401, 'error' => 'Unauthorized'], 401); 
        //     }

        
        return $this->successResponse($this->noteService->fetchNotes());
    }

   

    public function addNote(Request $req)
    {
        
        $user = auth()->user();

        if($user->id !== (int)$req->user_id){
            return response()->json(['status' => 401, 'error' => 'Unauthorized'], 401);
        }

        return $this->successResponse($this->noteService->createNote($req->all()));

    }

    public function updateNote(Request $req, $id)
    {
        
            $user = auth()->user();

            if($user->id !== (int)$req->user_id){
                return response()->json(['status' => 401, 'error' => 'Unauthorized'], 401);
            }
            
            return $this->noteService->updateNode($req->all(), $id);
    }

    public function deleteNote(Request $req, $id)
    {
        
    }

    public function userNote($id)
    {
       
    }

    public function getANote($id)
    {
        
    }

}
