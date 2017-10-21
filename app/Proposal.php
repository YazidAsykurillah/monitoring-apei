<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = 'proposals';

    protected $fillable = ['code', 'user_id', 'type', 'surat_permohonan', 'ktp', 'foto_3x4', 'ijazah', 'fotokopi_sk_a_t', 'surat_pernyataan', 'cv', 'status', 'notes', 'uncomplete_reason', 'received_date'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function proposal_logs()
    {
    	return $this->hasMany('App\ProposalLog', 'proposal_id');
    }
}
