<?php

namespace App\Mail;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBlogPost extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * The blog post instance.
     *
     * @var
     */
    public $blogPost;

    /**
     * The user instance.
     *
     * @var
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param BlogPost $blogPost
     * @param User     $user
     */
    public function __construct(BlogPost $blogPost, User $user)
    {
        $this->blogPost = $blogPost;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->blogPost->title)
                ->view('emails.blog-posts.created')
                ->text('emails.blog-posts.created_plain');
    }
}
