<?php namespace app\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Quote extends Eloquent {

    use SoftDeletes;

    protected $fillable = ['hash', 'line_1', 'line_2', 'author'];

    protected $table = 'quotes';

    public function getNext()
    {
        #$nextQuote = Quote::orderBy('id', 'asc')->where('id', '>', $this->id)->first();
        #return ($nextQuote) ? $nextQuote->hash : '';
    }

    public function getPrevius()
    {
        #$previusQuote = Quote::orderBy('id', 'desc')->where('id', '<', $this->id)->first();
        #return ($previusQuote) ? $previusQuote->hash : '';
    }
}