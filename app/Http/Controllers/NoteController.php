<?php

namespace App\Http\Controllers;

use App\Models\Note;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NoteNotification;

class NoteController extends Controller
{
    public function notes()
    {
        try{
            $notes = Note::all();

            if ($notes->count() > 0) {
                return response()->json(['status' => 200,'notes' => $notes], 200);
            }
            return response()->json(['status' => 404,'notes' => 'No Records Found!!'], 404);
        } 
        catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => 'Something wrong!.'], 500);
        }
    }

    public function getANote($id)
    {
        try {
            $note = Note::findOrFail($id);
            return response()->json($note, 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'Note not found!!',
            ], 404);
        }
    }

    public function addNote(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'ownar' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            

            $note = Note::create([
                "user_id" => $req->user_id,
                "title" => $req->title,
                "content" => $req->content,
                "ownar" => $req->ownar
            ]);

            //auth()->user()->notify(new NoteNotification($user, $note));

            return response()->json([
                'status' => 200,
                'message' => 'Note created successfully',
                'note' => $note
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500, 
                'error' => 'Failed to insert note, Please try again!!.'. $e->getMessage()
            ], 500);
        }
    }

    public function updateNote(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'ownar' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }
        try{
            // $user = auth()->user();

            // if($user->id !== (int)$req->user_id){
            //     return response()->json(['status' => 401, 'error' => 'Unauthorized'], 401);
            // }
            
            $note = Note::findOrFail($id);
            $note->title = $req->title;
            $note->content = $req->content;
            $note->ownar = $req->ownar;

            if ($note->save()) {
                return response()->json([
                    'status' => 202,
                    'message' => 'Note updated successfully'
                ], 200);      
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong, update failed!!'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 500,'error' => 'Update failed ' . $e->getMessage(),], 500);
        }
    }

    public function deleteNote($id)
    {
        try {
            $note = Note::findOrFail($id);
            // $user = auth()->user();

            // // Check if the user has permission to delete the note
            // if ($user->role === 1 || $user->id === (int) $req->user_id) {
            //     $note->delete();
            //     return response()->json([
            //         'status' => 200,
            //         'message' => 'Note deleted successfully',
            //     ], 200);
            // } else {
            //     return response()->json(['status' => 401, 'error' => 'Unauthorized'], 401);
            // }

            $note->delete();
            return response()->json([
                    'status' => 200,
                    'message' => 'Note deleted successfully',
            ], 200);

        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'Note not found!!',
            ], 404);
        }
    }

    public function userNote($id)
    {
        try {
            // $user = auth()->user();

            // if($user->id !== (int)$id){
            //     return response()->json(['status' => 401, 'error' => 'Unauthorized'], 401);
            // }

            $user_notes = Note::where('user_id', $id)->get();

            if ($user_notes->count() > 0) {
                return response()->json(['status' => 200,'notes' => $user_notes,], 200);
            }

            return response()->json(['status' => 404,'message' => 'user notes not found!',], 404);
           
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Wrong!',
            ], 500);
        }
    }

}
