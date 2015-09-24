<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Hashids\Hashids;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function home()
    {
        return view('home');
    }

    public function showEntry($hash)
    {
        // Find quote
        $quote = Quote::where(['hash' => $hash])->firstOrFail();

        return view('home', [
            'line_1' => $quote->line_1,
            'line_2' => $quote->line_2,
            'author' => $quote->author
        ]);
    }

    public function saveNewQuote(Request $request)
    {
        // Create entry
        $quote = Quote::create([
            'line_1' => $request->input('line_1'),
            'line_2' => $request->input('line_2'),
            'author' => $request->input('author')
        ]);

        // Get hash based on id inserted
        $hashids = new Hashids('q');
        $hash = $hashids->encode($quote->id);

        // Update entry
        $quote = Quote::findOrNew($quote->id);
        $quote->hash = $hash;
        $quote->save();

        return redirect('/');

    }
}
