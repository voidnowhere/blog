<?php

namespace App\Http\Controllers;

use App\Services\NewsletterInterface;
use Exception;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function __invoke(NewsletterInterface $newsletter)
    {
        request()->validate([
            'email' => 'required|email',
        ]);

        try {
            $newsletter->subscribe(request('email'));
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'email' => 'This email could not be added to our newsletters list.',
            ]);
        }

        return redirect('/')->with('success', 'You are now signed up for our newsletter!');
    }
}
