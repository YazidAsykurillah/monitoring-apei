<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalLog extends Model
{
    protected $table = 'proposal_logs';
    protected $fillable = ['proposal_id', 'user_id', 'mode', 'description'];

    public function proposal()
    {
    	return $this->belongsTo('App\Proposal');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
