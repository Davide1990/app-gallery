<?php

namespace App\Listeners;

use App\Events\NewAlbumCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Mail\NotifyAdminCreatedAlbum;

class NotifyAdminNewAlbum
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewAlbumCreated  $event
     * @return void
     */
    public function handle(NewAlbumCreated $event)
    {
        $admins = User::select('name','email')->where('role','admin')->get();
        foreach ($admins as $admin){
            \Mail::to($admin->email)->send(new NotifyAdminCreatedAlbum($event->album,$admin, $event->user));
        }
    }
}
