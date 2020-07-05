<div class="form-group {{ $errors->has('term_id') ? 'has-error' : ''}}">
    <label for="term_id" class="control-label">{{ 'Term Id' }}</label>
    <input class="form-control" name="term_id" type="number" id="term_id" value="{{ isset($post_term->term_id) ? $post_term->term_id : ''}}" >
    {!! $errors->first('term_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('post_id') ? 'has-error' : ''}}">
    <label for="post_id" class="control-label">{{ 'Post Id' }}</label>
    <input class="form-control" name="post_id" type="number" id="post_id" value="{{ isset($post_term->post_id) ? $post_term->post_id : ''}}" >
    {!! $errors->first('post_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
