<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post_Term extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_term';

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
    protected $fillable = ['term_id', 'post_id'];

    public function term()
    {
        return $this->belongsTo('App\Term');
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
