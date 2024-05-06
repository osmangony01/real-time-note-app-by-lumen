<?php

namespace App\Services;

use App\Traits\RequestService;

use function config;

class NoteService
{
    use RequestService;

    protected $baseUri;
    protected $secret;

    public function __construct()
    {
        $this->baseUri = config('services.notes.base_uri');
        $this->secret = config('services.notes.secret');
    }

    public function fetchNotes()
    {
        return $this->request('GET', '/api/notes');
    }

    public function createNote($data)
    {
        return $this->request('POST', '/api/add-note', $data);
    }
    
    public function updateNode($id, $data)
    {
        return $this->request('POST', "/api/update-note/{$id}", $data);
    }

    public function deleteOrder($id)
    {
        return $this->request('POST', "/api/delete-note/{$id}");
    }

    public function getANote($id)
    {
        return $this->request('GET', "/api/notes/{$id}");
    }

    public function getUserNote($id)
    {
        return $this->request('GET', "/api/user-notes/{$id}");
    }
}