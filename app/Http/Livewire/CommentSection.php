<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CommentSection extends Component
{
    use AuthorizesRequests;

    public Model $commentable;
    public string $content = '';
    public string $plainText = '';
    public array|null $metadata = null;

    public function mount(Model $commentable)
    {
        $this->commentable = $commentable;
    }

    public function render()
    {
        return view('livewire.comment-section');
    }

    public function saveComment()
    {
        $this->validate();
        $this->authorize('comment', $this->commentable);

        $this->commentable->comments()->create([
            'author_id' => Auth::user()->id,
            'content' => $this->content,
            'plain_text' => $this->plainText,
            'metadata' => $this->metadata,
        ]);

        $this->plainText = '';
        $this->content = '';
        $this->metadata = null;

        $this->commentable->refresh();
        $this->emit('comment-saved');
    }

    public function updatingPlainText(string $plainText)
    {
        if (empty(trim($plainText))) {
            $this->metadata = null;
        }
    }

    public function resolveComment(Comment $comment)
    {
        $this->authorize('resolveComment', $this->commentable);

        $comment->markAsResolved();

        $this->commentable->refresh();
    }

    protected function rules()
    {
        return [
            'content' => ['required', 'string'],
            'plainText' => ['required', 'string'],
        ];
    }
}
