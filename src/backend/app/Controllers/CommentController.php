<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Comment;
use App\Services\CommentService;

class CommentController extends Controller {

    public function index(): Response
    {
        $commentService = new CommentService();
        return (new Response())->json($commentService->getComments());
    }

    public function store(): Response
    {
        $request = Request::getInstance();
        $data = $request->post();

        $validated = $this->validate($data, [
            'user_name' => 'string:3-255',
            'user_email' => 'email',
            'header' => 'string:0-255',
            'content' => 'string:10',
        ]);
        if ($validated !== null) {
            return $validated;
        }

        $commentService = new CommentService();
        $commentService->storeComment($data);

        return (new Response())->json([
            'error' => null,
        ]);
    }
}