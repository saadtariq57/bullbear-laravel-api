<!-- resources/views/components/profile.blade.php -->

<div class="d-flex gap-3">
    <!-- Followers -->
    <div class="btn-group" aria-label="Followers Dropdown">
        <button type="button" class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Followers">
            <i class="bi bi-person-fill-add fs-4" aria-hidden="true"></i>
            @if ($followers->count() > 0)
                <span class="notification-count">{{ $followers->count() }}</span>
            @endif
        </button>
        <ul class="dropdown-menu dropdown-menu-end m-0 p-0" aria-label="Followers Menu">
            @forelse ($followers as $follower)
                <li class="py-0">
                    <a href="{{ '/profile/' . $follower->user->name }}" class="dropdown-item d-flex gap-3 align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ '/uploads/' . $follower->user->avatar }}" alt="{{ $follower->user->name }} Avatar" class="rounded-circle" width="45" height="45" onerror="this.onerror=null;this.src='/uploads/photos/d-avatar.jpg';">
                            <div>
                                <p class="text-uppercase mb-0 fs-12 fw-5 w180 text-wrap">{{ $follower->user->name }} has started following you</p>
                            </div>
                        </div>
                    </a>
                </li>
            @empty
                <li class="py-2 px-3">
                    <span class="dropdown-item text-center text-muted">No followers yet.</span>
                </li>
            @endforelse
        </ul>
    </div>

    <!-- Messages -->
    <div class="btn-group" aria-label="Messages Dropdown">
        <button type="button" class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Messages">
            <i class="bi bi-chat-dots fs-4" aria-hidden="true"></i>
            @if ($messages->count() > 0)
                <span class="notification-count">{{ $messages->count() }}</span>
            @endif
        </button>
        <ul class="dropdown-menu dropdown-menu-end m-0 p-0 message_dropdown" aria-label="Messages Menu">
            @forelse ($messages as $message)
                <li class="py-0">
                    <a href="{{ $message->url }}" class="dropdown-item d-flex align-items-center gap-2 border-bottom px-3 py-2">
                        <img src="{{ '/uploads/' . $message->user->avatar }}" alt="{{ $message->user->name }} Avatar" width="50" height="50" class="rounded-circle" onerror="this.onerror=null;this.src='/uploads/photos/d-avatar.jpg';">
                        <div>
                            <h6 class="text-uppercase fs-6 fw-6 text-cta mb-0">{{ $message->user->name }}</h6>
                            <p class="mb-0 fs-12 fw-5 w180 text-wrap text-oneline">{{ $message->preview }}</p>
                            <div class="fs-6 fw-5 ms-auto">{{ \Carbon\Carbon::parse($message->last_message_time)->diffForHumans() }}</div>
                        </div>
                    </a>
                </li>
            @empty
                <li class="py-2 px-3">
                    <span class="dropdown-item text-center text-muted">No messages.</span>
                </li>
            @endforelse
            <li class="py-0">
                <a href="/messages" class="dropdown-item text-center py-2">See All</a>
            </li>
        </ul>
    </div>

    <!-- General Notifications -->
    <div class="btn-group" aria-label="Notifications Dropdown">
        <button type="button" class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Notifications">
            <i class="bi bi-bell-fill fs-4" aria-hidden="true"></i>
            @if ($notifications->count() > 0)
                <span class="notification-count">{{ $notifications->count() }}</span>
            @endif
        </button>
        <ul class="dropdown-menu dropdown-menu-end m-0 p-0 header_notification" aria-label="Notifications Menu">
            @forelse ($notifications as $notification)
                <li class="py-2 px-3 @unless($notification->read_at) unread-notification-wrapper @endunless">
                    <a href="{{ $notification->url }}" class="dropdown-item d-flex gap-3 align-items-center p-0">
                        <img src="{{ '/uploads/' . $notification->user->avatar }}" alt="{{ $notification->user->name }} Avatar" width="45" height="45" class="rounded-circle" onerror="this.onerror=null;this.src='/uploads/photos/d-avatar.jpg';">
                        <div>
                            <h6 class="text-uppercase fs-6 fw-6 text-cta mb-0">{{ $notification->title }}</h6>
                            <p class="mb-0 fs-12 fw-5 text-wrap">{{ $notification->description }}</p>
                            <div class="fs-6 fw-5">{{ \Carbon\Carbon::parse($notification->last_notification_time)->diffForHumans() }}</div>
                        </div>
                    </a>
                </li>
            @empty
                <li class="py-2 px-3">
                    <span class="dropdown-item text-center text-muted">No notifications.</span>
                </li>
            @endforelse
            <li class="py-0">
                <a href="/notifications" class="dropdown-item text-center py-2">See All</a>
            </li>
        </ul>
    </div>

    <!-- Profile Links -->
    <div class="dropdown-center" aria-label="Profile Dropdown">
        <button class="btn dropdown-toggle border-0 profile-dropdown-toggle p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Profile Menu">
            <div class="img">
                <img src="{{ $updatedProfileImagePath ? '/uploads/' . $updatedProfileImagePath : '/uploads/' . $user->avatar }}" class="rounded-circle" width="40" height="40" alt="{{ $user->name }} profile picture" onerror="this.onerror=null;this.src='/uploads/photos/d-avatar.jpg';">
            </div>
        </button>
        <ul class="dropdown-menu bg-light dropdown-menu-end m-0 p-0" aria-label="Profile Menu">
            <li class="px-4 py-4">
                <div class="bg-white rounded-3 px-3 py-3 w180">
                    <a href="/feed" class="d-flex align-items-center gap-2">
                        <img src="{{ $updatedProfileImagePath ? '/uploads/' . $updatedProfileImagePath : '/uploads/' . $user->avatar }}" class="rounded-circle" width="40" height="40" alt="{{ $user->name }} profile picture" onerror="this.onerror=null;this.src='/uploads/photos/d-avatar.jpg';">
                        <b class="text-uppercase text-black">{{ $user->name }}</b>
                    </a>
                </div>
            </li>
            <li class="px-4 pb-4">
                <div class="bg-white rounded-3 px-3 py-3 w180">
                    <a href="{{ '/profile/' . $user->name }}" class="dropdown-item text-black ps-0 fw-6" aria-label="My Profile">My Profile</a>
                    <a href="/pricing" class="dropdown-item text-black ps-0 fw-6" aria-label="Upgrade To Pro">Upgrade To Pro</a>
                    <a href="{{ '/profile/' . $user->name . '/setting' }}" class="dropdown-item text-black ps-0 fw-6" aria-label="Settings">Settings</a>
                </div>
            </li>
            <li class="px-4 pb-4">
                <div class="bg-white rounded-3 px-3 py-3 w180 header_login">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="d-flex gap-2 fs-16 fw-6 text-black cursor-pointer btn btn-link p-0" aria-label="Logout">
                            <i class="bi bi-box-arrow-in-right"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
