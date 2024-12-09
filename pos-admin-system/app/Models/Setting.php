<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model implements Auditable
{
    /** Auditable */
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['key', 'value', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function getValueByKey(string $key, int $projectId)
    {
        $setting = Setting::firstOrCreate([
            'key' => $key,
            'project_id' => $projectId,
        ], [
            'value' => null
        ]);

        return $setting->value;
    }

    public static function storeValue(string $key, $value = '', int $projectId)
    {
        $setting = Setting::updateOrCreate(
            ['key' => $key, 'project_id' => $projectId,],
            ['value' => $value]
        );

        return $setting;
    }
}
