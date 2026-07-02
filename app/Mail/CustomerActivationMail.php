<?php
namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $activationUrl;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        // Генерируем прямую ссылку для GoDaddy и локалки
        $this->activationUrl = url('/activate/' . $customer->activation_token);
    }

    public function build()
    {
        return $this->subject('Активация аккаунта')
            ->view('emails.activation');
    }
}
