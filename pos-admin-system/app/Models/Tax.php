<?php

namespace App\Models;

use App\StatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model  implements Auditable
{
    /** Auditable */
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;

    protected $fillable = ['title', 'percentage', 'priority', 'status', 'description'];

    protected function casts(): array
    {
        return [
            'priority' => 'integer',
            'percentage' => 'double',
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
