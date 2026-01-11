<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $mailDriver = config('mail.default');
        
        $this->info('Testing email configuration...');
        $this->info('Mail Driver: ' . $mailDriver);
        
        if ($mailDriver === 'log') {
            $this->warn('WARNING: Mail driver is set to "log". Emails will be written to the log file instead of being sent.');
            $this->warn('To send actual emails, set MAIL_MAILER=smtp in your .env file.');
            $this->newLine();
        }
        
        $this->info('Mail Host: ' . config('mail.mailers.smtp.host'));
        $this->info('Mail Port: ' . config('mail.mailers.smtp.port'));
        $this->info('Mail Encryption: ' . (config('mail.mailers.smtp.encryption') ?: 'none'));
        $this->info('Mail Username: ' . (config('mail.mailers.smtp.username') ?: 'not set'));
        $this->info('Mail From: ' . config('mail.from.address'));
        $this->newLine();
        
        try {
            Mail::raw('This is a test email from your Laravel application. If you receive this, your email configuration is working correctly!', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email from Laravel');
            });
            
            if ($mailDriver === 'log') {
                $this->info("Email logged successfully! Check storage/logs/laravel.log to see the email content.");
                $this->info("To actually send emails, update your .env file with:");
                $this->line("  MAIL_MAILER=smtp");
                $this->line("  MAIL_HOST=your-hostgator-server");
                $this->line("  MAIL_PORT=587");
                $this->line("  MAIL_USERNAME=your-email@yourdomain.com");
                $this->line("  MAIL_PASSWORD=your-password");
                $this->line("  MAIL_ENCRYPTION=tls");
            } else {
                $this->info("Test email sent successfully to {$email}!");
                $this->info("If you don't receive it, check your spam folder or verify your SMTP settings.");
            }
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to send email: " . $e->getMessage());
            $this->newLine();
            $this->error("Full error details:");
            $this->line($e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}
