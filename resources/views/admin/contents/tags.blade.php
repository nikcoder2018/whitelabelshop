@extends('admin.layouts.main')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Create New Tag
            </div>
            <div class="card-body">
                <form action="{{route('tags.store')}}" id="form-add-tag" method="POST">
                    @csrf 
                    <div class="form-group">
                        <label for="input-name">Tag</label>
                        <input type="text" name="tag" class="form-control" id="input-tag" placeholder="e.g Tag" required>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Add</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Tags
            </div>
            <div class="card-body">
                <div class="tags-container">
                    @if(count($tags) > 0)
                        @foreach($tags as $tag)
                        <button type="button" data-id="{{$tag->id}}" class="btn btn-round btn-primary btn-tag">{{$tag->tag}}</button>
                        @endforeach
                    @else 
                    <p>No tags yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#form-add-tag').on('submit', function(e){
            let form = this;

            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(resp){
                    if(resp.success){
                        $('.tags-container').append(`<button type="button" data-id="${resp.details.id}" class="btn btn-round btn-primary btn-tag">${resp.details.tag}</button>`);
                        form.reset();
                    }
                }
            });
        })
    });
</script>
@endsection

