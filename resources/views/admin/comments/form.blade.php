<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    <label for="content" class="control-label">{{ 'Content' }}</label>
    <textarea class="form-control" rows="5" name="content" type="textarea" id="content" required>{{ isset($comment->content) ? $comment->content : ''}}</textarea>
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('post_id') ? 'has-error' : ''}}">
    <label for="post_id" class="control-label">{{ 'Post Id' }}</label>
    <input class="form-control" name="post_id" type="number" id="post_id" value="{{ isset($comment->post_id) ? $comment->post_id : ''}}" >
    {!! $errors->first('post_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : ''}}">
    <label for="parent_id" class="control-label">{{ 'Parent Id' }}</label>
    <input class="form-control" name="parent_id" type="number" id="parent_id" value="{{ isset($comment->parent_id) ? $comment->parent_id : ''}}" >
    {!! $errors->first('parent_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>
    <input class="form-control" name="user_id" type="number" id="user_id" value="{{ isset($comment->user_id) ? $comment->user_id : ''}}" >
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('user_email') ? 'has-error' : ''}}">
    <label for="user_email" class="control-label">{{ 'User Email' }}</label>
    <input class="form-control" name="user_email" type="text" id="user_email" value="{{ isset($comment->user_email) ? $comment->user_email : ''}}" >
    {!! $errors->first('user_email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('is_approved') ? 'has-error' : ''}}">
    <label for="is_approved" class="control-label">{{ 'Is Approved' }}</label>
    <input class="form-control" name="is_approved" type="number" id="is_approved" value="{{ isset($comment->is_approved) ? $comment->is_approved : ''}}" >
    {!! $errors->first('is_approved', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('agent') ? 'has-error' : ''}}">
    <label for="agent" class="control-label">{{ 'Agent' }}</label>
    <input class="form-control" name="agent" type="text" id="agent" value="{{ isset($comment->agent) ? $comment->agent : ''}}" >
    {!! $errors->first('agent', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
