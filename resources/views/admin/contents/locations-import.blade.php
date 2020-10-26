@extends('admin.layouts.main')

@section('content')
<form action="{{route('locations.import')}}">
    @csrf 
    <input type="file" name="file">
    <button type="submit">Submit</button>
</form>
@endsection

@section('scripts')
    <script>
        $('form').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(resp){
                    
                }
            });
        })
    </script>
@endsection
