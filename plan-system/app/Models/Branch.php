<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Branch extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'active_flg' => 'boolean',
        ];
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function setting() {
        return $this->hasOne(BranchSetting::class);
    }

    public static function getByCode(string $code, $projectId)
    {
        return Branch::where('project_id', $projectId)
            ->where('code', $code)
            ->first();
    }
}
