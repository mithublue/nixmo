<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'terms';

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
    protected $fillable = ['name', 'slug', 'taxonomy', 'post_type'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_term', 'term_id', 'post_id', 'id', 'id' );
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
