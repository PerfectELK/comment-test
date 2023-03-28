<?php

namespace App\Services;

use App\Models\Comment;

class CommentService {

    public function getComments(): array
    {
        $comment = new Comment();
        return $comment->query()->select([
            'id',
            'user_name',
            'user_email',
            'header',
            'content'
        ])->get();
    }

    public function storeComment(array $data): bool
    {
        $comment = new Comment();
        return $comment->insert([
            'user_name' => $data['user_name'],
            'user_email' => $data['user_email'],
            'header' => $data['header'],
            'content' => $data['content']
        ]);
    }

}