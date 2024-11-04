<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'phone_number' => $this->phone_number,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'avatar' => asset('uploads/' . $this->avatar),
            'cover' => asset('uploads/' . $this->cover),
            'website' => $this->website,
            'social_links' => [
                'twitter' => $this->twitter,
                'linkedin' => $this->linkedin,
                'youtube' => $this->youtube,
            ],
            'privacy_settings' => [
                'follow_privacy' => $this->follow_privacy,
                'post_privacy' => $this->post_privacy,
                'status_privacy' => $this->status_privacy,
                'search_index_privacy' => $this->search_index_privacy,
                'groups_privacy' => $this->groups_privacy,
                'watchlists_privacy' => $this->watchlists_privacy,
                'photos_privacy' => $this->photos_privacy,
            ],
            'settings' => [
                'show_last_seen' => $this->showlastseen,
                'email_notifications' => $this->emailNotification,
            ],
            'about' => $this->about,
            'status' => $this->status,
            'type' => $this->type,
            /*'subscription_plan' => new \App\Http\Resources\SubscriptionPlanResource($this->subscriptionPlan),*/
            'billing' => [
                'stripe_id' => $this->stripe_id,
                'pm_type' => $this->pm_type,
                'pm_last_four' => $this->pm_last_four,
                'trial_ends_at' => $this->trial_ends_at,
            ],
            'counts' => [
                'watchlists_count' => $this->watchlists_count,
                'posts_count' => $this->posts_count,
                'followers_count' => $this->followers_count,
                'followings_count' => $this->followings_count,
            ],
            
        ];
    }
}
