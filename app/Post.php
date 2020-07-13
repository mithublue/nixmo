<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Plank\Metable\Metable;

class Post extends Model
{
    use Metable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

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
    protected $fillable = ['title', 'content', 'excerpt', 'comment_status', 'password', 'slug', 'parent_id'];

    /**
     * Attributes that should be filled up by system itself.
     *
     * @var array
     */
    protected $metaFillable = ['post_type', 'user_id'];

    public function getMetaFillable() {
        return $this->metaFillable;
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function terms()
    {
        return $this->belongsToMany(Term::class, 'post_term', 'post_id', 'term_id', 'id', 'id' );
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
        $this->fillable = apply_filters( 'model-fillable_fields', $this->fillable, __CLASS__ );
        $this->metaFillable = apply_filters( 'model-metaFillable_fields', $this->metaFillable, __CLASS__ );
        $this->hidden = apply_filters( 'model-hidden_fields', $this->hidden, __CLASS__ );
        $this->casts = apply_filters( 'model-casts_fields', $this->casts, __CLASS__ );
    }
    
}
