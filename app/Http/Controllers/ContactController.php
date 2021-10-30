<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function submit(ContactRequest $red)
    {
        //$validation = $red->validate( [
        //     'name'=>'required',
        //    'email'=>'required|email',
        //     'subject'=>'required|min:5|max:50',
        //    'massage'=>'required|min:15|max:30',
        // ] );

        $contact = new Contact();
        $contact->name = $red->input('name');
        $contact->email = $red->input('email');
        $contact->subject = $red->input('subject');
        $contact->message = $red->input('message');

        $contact->save();

        return redirect()->route('home')->with('success', 'Сообщение было добавлено.');
    }

    public function allData()
    {
        $contact = new Contact();
        return view('messages', ['data' => $contact->orderBy('id', 'asc')->get()]);
    }

    //all - все записи, find - одна запись

    public function showOneMessage($id)
    {
        $contact = new Contact();
        return view('one-messages', ['data' => $contact->find($id)]);
    }

    public function updateMessage($id) {
        $contact = new Contact();
        return view('update-messages', ['data' => $contact->find($id)]);
    }

    public function updateMessageSubmit($id, ContactRequest $red)
    {
        //$validation = $red->validate( [
        //     'name'=>'required',
        //    'email'=>'required|email',
        //     'subject'=>'required|min:5|max:50',
        //    'massage'=>'required|min:15|max:30',
        // ] );

        $contact = Contact::find($id);
        $contact->name = $red->input('name');
        $contact->email = $red->input('email');
        $contact->subject = $red->input('subject');
        $contact->message = $red->input('message');

        $contact->save();

        return redirect()->route('contact-data-one', $id)->with('success', 'Сообщение было обнавлено.');
    }

    public function deleteMessage($id) {
        Contact::find($id)->delete();
        return redirect()->route('contact-data', $id)->with('success', 'Сообщение было удалено.');
    }
}


