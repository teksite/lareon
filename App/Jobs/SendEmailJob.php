<?php

namespace Lareon\CMS\App\Jobs;

use Illuminate\Bus\Queueable; // تغییر به ترِیت درست
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Lareon\CMS\App\Models\User;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    public $backoff = [30, 60, 120, 300, 600];
    public $timeout = 120;

    protected $recipient; // تغییر به protected برای سریالایز بهتر
    protected $mailable;

    public function __construct(User $recipient, Mailable $mailable)
    {
        $this->recipient = $recipient;
        $this->mailable = $mailable;
        $this->queue = 'emails';
    }

    public function handle()
    {
        try {
            Mail::to($this->recipient->email)->send($this->mailable);
            Log::info("ایمیل با موفقیت برای {$this->recipient->email} ارسال شد.", [
                'mailable' => get_class($this->mailable),
            ]);
        } catch (\Exception $e) {
            Log::error("خطا در ارسال ایمیل: " . $e->getMessage(), [
                'email' => $this->recipient->email,
                'attempt' => $this->attempts(),
            ]);

            if ($this->attempts() < $this->tries) {
                $delay = $this->backoff[$this->attempts() - 1] ?? end($this->backoff);
                $this->release($delay);
            } else {
                $this->fail($e);
            }
        }
    }

    public function failed(\Exception $exception)
    {
        Log::critical("ارسال ایمیل برای {$this->recipient->email} بعد از {$this->tries} تلاش شکست خورد.", [
            'error' => $exception->getMessage(),
        ]);
        // اینجا می‌تونی اعلان به ادمین بفرستی یا توی دیتابیس ثبت کنی
    }
}
