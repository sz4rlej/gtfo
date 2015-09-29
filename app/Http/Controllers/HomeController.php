<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Vote;
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
            'hash'   => $quote->hash,
            'votes' => $this->_getQuoteVotes($quote->hash)
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
            'hash'   => $quote->hash,
            'votes' => $this->_getQuoteVotes($quote->hash)
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
        return $this->_jsonResponse($quote->line_1, $quote->line_2, $quote->author, $quote->hash);
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
            return $this->_jsonResponse($nextQuote->line_1, $nextQuote->line_2, $nextQuote->author, $nextQuote->hash);
        }

        // Not found ? Than we go to the first one
        $quote = Quote::orderBy('id', 'asc')->firstOrFail();
        return $this->_jsonResponse($quote->line_1, $quote->line_2, $quote->author, $quote->hash);
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
            return $this->_jsonResponse($previousQuote->line_1, $previousQuote->line_2, $previousQuote->author, $previousQuote->hash);
        }

        // Not found ? Than we go to the last one
        $quote = Quote::orderBy('id', 'desc')->firstOrFail();
        return $this->_jsonResponse($quote->line_1, $quote->line_2, $quote->author, $quote->hash);

    }

    /**
     * @param $line_1
     * @param $line_2
     * @param $author
     * @param $hash
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $nextQuote
     */
    private function _jsonResponse($line_1, $line_2, $author, $hash)
    {
        // Get votes
        $votes = $this->_getQuoteVotes($hash);

        return response()->json([
            'status' => 'ok',
            'data' => [
                'line_1' => $line_1,
                'line_2' => $line_2,
                'author' => $author,
                'hash'   => $hash,
                'votes' => $votes
            ]
        ]);
    }

    /**
     * @param $quoteHash
     * @param $userVote
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $vote
     */
    public function saveVote($quoteHash, $userVote)
    {
        // Hash user details - week but exists
        //$hashids = new Hashids('q');
        //$hash = $hashids->encode(preg_replace('/[^0-9]+/', '', $_SERVER['HTTP_ACCEPT'] . $_SERVER['REMOTE_ADDR']));
        $hash = $_SERVER['HTTP_ACCEPT'] . $_SERVER['REMOTE_ADDR'];

        // Check for previous vote
        $today = new \DateTime();
        $vote = Vote::where('user_hash', $hash)->where('quote_hash', $quoteHash)->where('created_at', '>', $today->modify('-1 day'))->first();

        // found ? Than dont allow :/
        if($vote)
        {
            return response()->json(['status' => 'error']);
        }

        // ... else add vote
        $vote = new Vote();
        $vote->user_hash = $hash;
        $vote->quote_hash = $quoteHash;
        $vote->vote = $userVote;
        $vote->save();

        $quoteVotes = $this->_getQuoteVotes($quoteHash);

        return response()->json([
            'status' => 'ok',
            'data' => [
                'votes' => $quoteVotes
            ]
        ]);
    }

    /**
     * @param $quoteHash
     * @return array
     */
    private function _getQuoteVotes($quoteHash)
    {
        // Return final votes count
        $votesPlus = Vote::where('quote_hash', $quoteHash)->where('vote', 1)->count();
        $votesMinus = Vote::where('quote_hash', $quoteHash)->where('vote', 0)->count();
        return $votesPlus - $votesMinus;
    }
}
