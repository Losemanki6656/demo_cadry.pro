@extends('layouts.master')

@section('content')
<style>
    .full-height {
        height: 80vh;
    }
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }
</style>

<div class="flex-center full-height">
    <blockquote>
        <h3 class="fw-bold">
           
        </h3>     
        <div class="text-primary fw-bold">
            <cite>  </cite>
        </div>      
    </blockquote> 
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 1)
                    alertify.success("Profil ma'lumotlari muvaffaqqiyatli o'zgartirildi!");
                @endif
            @endif
        });
</script>
@endsection