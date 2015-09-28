<?php namespace app\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Vote extends Eloquent {

    use SoftDeletes;

    protected $fillable = ['user_hash', 'quote_hash','vote'];

    protected $table = 'vote';

}