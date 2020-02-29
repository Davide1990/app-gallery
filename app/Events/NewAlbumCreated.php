<?php

// imposti gli eventi e i listener in EventServiceProvider, poi con php artisan event:generate li crei
// i listeners sono classi che ascolteranno questo evento, in questo caso NotifyAdminNewAlbum è un listener
// che gestirà questo evento 
// quando un utente crea un nuovo album il listener manderà una mail agli admin per notificarli che l'album è stato aggiunto
// attravero una classe mailable.


namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Album;
use App\User;

class NewAlbumCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $album;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Album $album, User $user)
    {
        $this->album = $album;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
