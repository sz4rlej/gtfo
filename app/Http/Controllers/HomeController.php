<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Hashids\Hashids;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        // Find quote
        $quote = Quote::orderBy('id', 'desc')->firstOrFail();

        return view('app', [
            'line_1' => $quote->line_1,
            'line_2' => $quote->line_2,
            'author' => $quote->author,
            'hash'   => $quote->hash
        ]);
    }

    /**
     * @param $hash
     * @return \Illuminate\View\View
     */
    public function showEntry($hash)
    {
        // Find quote
        $quote = Quote::where(['hash' => $hash])->firstOrFail();

        return view('app', [
            'line_1' => $quote->line_1,
            'line_2' => $quote->line_2,
            'author' => $quote->author,
            'hash'   => $quote->hash
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Laravel\Lumen\Http\Redirector
     */
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

    /**
     * @param $hash
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getQuote($hash)
    {
        // Find quote
        $quote = Quote::where(['hash' => $hash])->orderBy('id', 'desc')->firstOrFail();

        // Return json
        return $this->jsonResponse($quote->line_1, $quote->line_2, $quote->author, $quote->hash);
    }

    /**
     * @param $hash
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNextQuote($hash)
    {
        // Find quote
        $quote = Quote::where(['hash' => $hash])->orderBy('id', 'asc')->firstOrFail();
        $nextQuote = Quote::orderBy('id', 'asc')->where('id', '>', $quote->id)->first();

        // Next Quote found ?
        if($nextQuote)
        {
            // Return json
            return $this->jsonResponse($nextQuote->line_1, $nextQuote->line_2, $nextQuote->author, $nextQuote->hash);
        }

        // Not found ? Than we go to the first one
        $quote = Quote::orderBy('id', 'asc')->firstOrFail();
        return $this->jsonResponse($quote->line_1, $quote->line_2, $quote->author, $quote->hash);
    }

    /**
     * @param $hash
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPreviousQuote($hash)
    {
        // Find quote
        $quote = Quote::where(['hash' => $hash])->orderBy('id', 'desc')->firstOrFail();
        $previousQuote = Quote::orderBy('id', 'desc')->where('id', '<', $quote->id)->first();

        if($previousQuote)
        {
            // Return json
            return $this->jsonResponse($previousQuote->line_1, $previousQuote->line_2, $previousQuote->author, $previousQuote->hash);
        }

        // Not found ? Than we go to the last one
        $quote = Quote::orderBy('id', 'desc')->firstOrFail();
        return $this->jsonResponse($quote->line_1, $quote->line_2, $quote->author, $quote->hash);

    }

    /**
     * @param $line_1
     * @param $line_2
     * @param $author
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $nextQuote
     */
    public function jsonResponse($line_1, $line_2, $author, $hash)
    {
        return response()->json([
            'status' => 'ok',
            'data' => [
                'line_1' => $line_1,
                'line_2' => $line_2,
                'author' => $author,
                'hash'   => $hash
            ]
        ]);
    }
}
