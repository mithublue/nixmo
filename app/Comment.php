<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['content', 'post_id', 'parent_id', 'user_id', 'user_email', 'is_approved', 'agent'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * Reorganize the properties with filters
     *
     * Comment constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = apply_filters( 'model_form_fillable_fields', $this->fillable, __CLASS__ );
        $this->hidden = apply_filters( 'model_form_hidden_fields', $this->hidden, __CLASS__ );
        $this->casts = apply_filters( 'model_form_casts_fields', $this->casts, __CLASS__ );
    }
    
}
