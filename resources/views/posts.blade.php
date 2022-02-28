@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post Lists</div>
                <div class="card-body">
                    <ul>
                        @foreach ($posts as $item)
                         <a href="{{ route('post',$item->slug) }}"><li>{{ $item->title }}</li></a>
                        @endforeach
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection 