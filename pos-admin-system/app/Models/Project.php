<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    /** Auditable */
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $fillable = ['name', 'status', 'created_by', 'updated_by'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
