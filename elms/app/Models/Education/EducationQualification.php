<?php

namespace App\Models\Education;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Qualification\Qualification;


class EducationQualification extends Model
{
    use HasFactory;
    protected $table = "educational_qualifications";
    protected $fillable=[
        'name','type'
    ];

    public function type()
    {
        return $this->belongsTo(Qualification::class, 'id', 'id');
    }
}
