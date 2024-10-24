<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Follower;
use App\Models\Message;
use App\Models\Notification;

class Profile extends Component
{
    public $followers;
    public $messages;
    public $notifications;
    public $user;
    public $updatedProfileImagePath;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::user();
        if ($this->user) {
            $this->followers = Follower::where('followed_user_id', $this->user->id)->with('user')->get();
            $this->messages = Message::where('recipient_id', $this->user->id)->with('user')->get();
            $this->notifications = Notification::where('user_id', $this->user->id)->with('user')->get();
            $this->updatedProfileImagePath = $this->user->updated_profile_image_path;
        } else {
            $this->followers = collect();
            $this->messages = collect();
            $this->notifications = collect();
            $this->updatedProfileImagePath = null;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.profile');
    }
}
