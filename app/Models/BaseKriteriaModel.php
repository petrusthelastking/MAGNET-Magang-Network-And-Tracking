<?php

namespace App\Models;

use App\Events\UpdatedMahasiswaPreference;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseKriteriaModel extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::updated(function (BaseKriteriaModel $model)  {
            $mahasiswa = Mahasiswa::find($model->mahasiswa_id);
            event(new UpdatedMahasiswaPreference($mahasiswa));
        });
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
