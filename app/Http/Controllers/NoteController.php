<?php

namespace App\Http\Controllers;

use App\Models\Note;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function notes()
    {
        $notes = Note::all();

        if ($notes->count() > 0) {
            return response()->json([
                'status' => 200,
                'notes' => $notes
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'notes' => 'No Records Found!!'
            ], 404);
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

            return response()->json([
                'status' => 200,
                'message' => 'Note created successfully',
                'note' => $note
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500, 
                'error' => 'Failed to insert note, Please try again!!.'
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
            return response()->json([
                'status' => 500,
                'error' => 'Update failed ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteNote($id)
    {
        try {
            $note = Note::findOrFail($id);
            $note->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Note deleted successful',
            ], 404);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'Note not found!!',
            ], 404);
        }
    }
}
