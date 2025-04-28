<?php

namespace App\Services;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactService {

    public function findById($id)
    {
        return Contact::findOrFail($id);
    }

    public function updateContact(Contact $contact, $data) {
        DB::transaction(function () use ($contact,$data) {
            $contact->read = $data['status'];
            $contact->save();
        });
    }

  public function createContact($data) {
    return DB::transaction(function () use ($data) {
        $contact = new Contact();
        $contact->name = $data->name;
        $contact->email = $data->email;
        $contact->mobile = $data->introduction . $data->mobile;
        $contact->message = $data->message;
        $contact->read = 0;
        $contact->save();

        return $contact; 
    });
  }


}
