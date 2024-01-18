<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-test-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Mail::raw('Hello World!', function($msg) {$msg->to('test@getpowerlift.com')->subject('Test Email'); });
    }
}
