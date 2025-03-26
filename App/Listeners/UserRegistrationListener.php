<?php

namespace Lareon\CMS\App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Route;

class UserRegistrationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        $data = $event->data;
        $message = [
            'subject' => $data['subject'] ?? __("a new account at :title", ['title' => config('app.name')]),
            'introduction' => $data['introduction'] ?? [
                    __("dear :name", ['name' => $user->name]),
                    __('We’re thrilled to welcome you to :title! Your account has been successfully created, and you’re now part of our community.', ['title' => config('app.name')]),
                    __("click the button below to get started:"),

                ],
            'actionUrl' => $data['actionUrl'] ?? Route::has('login') ? route('login') : url('/'),
            'actionText' => $data['actionText'] ?? config('app.name'),
            'content' => $data['content'] ?? [
                    __('Thank you for joining us! We can’t wait to see what you’ll achieve with ')
                ],
        ];

        \Lareon\CMS\App\Jobs\SendEmailJob::dispatch($user, new \Lareon\CMS\App\Mail\EmailNotification(...$message));


    }
}
