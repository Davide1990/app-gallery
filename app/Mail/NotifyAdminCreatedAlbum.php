<?php


// per creare una classe mailable usi php artisan make:mail "NOme classe"
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Album;
use App\User;

class NotifyAdminCreatedAlbum extends Mailable
{
    use Queueable, SerializesModels;
    public $album;
    public $admin;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Album $album, User $admin, User $user )
    {
        $this->album = $album;
        $this->admin = $admin;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from($this->user->email)
                    ->view('mail/AlbumCreatedAdmin');
    }
}
