<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Location;

class ContactsController extends Controller
{
    public function index()
    {

        $contacts = Contact::getCached();
        $local = Location::getCached();

        $meta = [
            'title' => __('pages.contacts.title') . " " . __('pages.meta.title'),
            'description' => __('pages.contacts.meta.desc'),
            'keywords' => __('pages.contacts.meta.keywords')
        ];

        $params = array(
            'asset' => 'contacts',
            'meta' => $meta,
            'ContData' => $contacts,
            'local' => $local
        );

        return view('contacts-view', $params);
    }
}
