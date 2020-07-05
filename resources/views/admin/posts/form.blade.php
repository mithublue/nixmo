<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($post->title) ? $post->title : ''}}" required>
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    <label for="content" class="control-label">{{ 'Content' }}</label>
    <textarea class="form-control" rows="5" name="content" type="textarea" id="content" >{{ isset($post->content) ? $post->content : ''}}</textarea>
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('post_type') ? 'has-error' : ''}}">
    <label for="post_type" class="control-label">{{ 'Post Type' }}</label>
    <input class="form-control" name="post_type" type="text" id="post_type" value="{{ isset($post->post_type) ? $post->post_type : ''}}" >
    {!! $errors->first('post_type', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>
    <input class="form-control" name="user_id" type="number" id="user_id" value="{{ isset($post->user_id) ? $post->user_id : ''}}" >
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('excerpt') ? 'has-error' : ''}}">
    <label for="excerpt" class="control-label">{{ 'Excerpt' }}</label>
    <textarea class="form-control" rows="5" name="excerpt" type="textarea" id="excerpt" >{{ isset($post->excerpt) ? $post->excerpt : ''}}</textarea>
    {!! $errors->first('excerpt', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('comment_status') ? 'has-error' : ''}}">
    <label for="comment_status" class="control-label">{{ 'Comment Status' }}</label>
    <input class="form-control" name="comment_status" type="text" id="comment_status" value="{{ isset($post->comment_status) ? $post->comment_status : ''}}" >
    {!! $errors->first('comment_status', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    <label for="password" class="control-label">{{ 'Password' }}</label>
    <input class="form-control" name="password" type="text" id="password" value="{{ isset($post->password) ? $post->password : ''}}" >
    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
    <label for="slug" class="control-label">{{ 'Slug' }}</label>
    <input class="form-control" name="slug" type="text" id="slug" value="{{ isset($post->slug) ? $post->slug : ''}}" >
    {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : ''}}">
    <label for="parent_id" class="control-label">{{ 'Parent Id' }}</label>
    <input class="form-control" name="parent_id" type="number" id="parent_id" value="{{ isset($post->parent_id) ? $post->parent_id : ''}}" >
    {!! $errors->first('parent_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
