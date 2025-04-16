<?php

namespace App\Mail;

use App\Models\Language;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BasicMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    public function __construct($args)
    {
        $default_lang = Language::where('default', 1)->first();
        app()->setLocale($default_lang->slug);
        if ($default_lang->direction == 'rtl') {
            $direction = 'rtl';
            $text_align = 'right';
            $not_text_align = 'left';
        } else {
            $direction = 'ltr';
            $text_align = 'left';
            $not_text_align = 'right';
        }
        $this->data = $args;
        $this->data['style'] = [
            'slug' => $default_lang->slug,
            'direction' => $direction,
            'text_align' => $text_align,
            'not_text_align' => $not_text_align
        ];
    }

    public function build()
    {
        return $this->from(get_setting('site_global_email'), env('APP_NAME', 'Laravel'))
            ->subject($this->data['subject'])
            ->markdown('emails.basic-mail');
    }
}
