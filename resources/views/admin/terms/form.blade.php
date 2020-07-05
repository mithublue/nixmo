<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($term->name) ? $term->name : ''}}" required>
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
    <label for="slug" class="control-label">{{ 'Slug' }}</label>
    <input class="form-control" name="slug" type="text" id="slug" value="{{ isset($term->slug) ? $term->slug : ''}}" required>
    {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('taxonomy') ? 'has-error' : ''}}">
    <label for="taxonomy" class="control-label">{{ 'Taxonomy' }}</label>
    <input class="form-control" name="taxonomy" type="text" id="taxonomy" value="{{ isset($term->taxonomy) ? $term->taxonomy : ''}}" >
    {!! $errors->first('taxonomy', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('post_type') ? 'has-error' : ''}}">
    <label for="post_type" class="control-label">{{ 'Post Type' }}</label>
    <input class="form-control" name="post_type" type="text" id="post_type" value="{{ isset($term->post_type) ? $term->post_type : ''}}" >
    {!! $errors->first('post_type', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
