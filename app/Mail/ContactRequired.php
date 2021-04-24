<?php

namespace App\Mail;

use App\Models\Libro;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactRequired extends Mailable
{
    use Queueable, SerializesModels;
    public $libros;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Libro $libros)
    {
        $this->libros=$libros;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       /*  return $this->view('view.name'); */
       return $this->from('apascual1998@gmail.com')->view('mailcontact');
    }

    public function reqContact(Libro $libros){

        $contact=Contact::create([
            'interested_id'=>Auth::user()->id,
            'publication_id'=>$libros->id,
        ]);
        Mail::to(Auth::user()->email)
            ->send(new ContactRequired($libros));

        return view('contactRequest',compact('libros'))->with('success','We have sent you a message!');
    }
}
