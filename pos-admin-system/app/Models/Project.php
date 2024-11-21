<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    /** Auditable */
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'status', 'created_by', 'updated_by'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
