<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Quizzes
 * @package App\Models
 * @version April 6, 2021, 1:22 am UTC
 *
 * @property string $title
 * @property string $description
 * @property string $grading_method
 * @property integer $created_by
 */
class Quizzes extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'quizzes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'description',
        'grading_method',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'grading_method' => 'string',
        'created_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string|max:191',
        'description' => 'required|string',
        // 'grading_method' => 'required|string|max:191',
        // 'created_by' => 'required|integer',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];


}
