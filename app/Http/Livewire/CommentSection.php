<?php

namespace App\Http\Livewire;

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
        ]);

        $this->plainText = '';
        $this->content = '';

        $this->commentable->refresh();
        $this->emit('comment-saved');
    }

    protected function rules()
    {
        return [
            'content' => ['required', 'string'],
            'plainText' => ['required', 'string'],
        ];
    }
}
