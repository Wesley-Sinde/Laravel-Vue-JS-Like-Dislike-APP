@extends('layouts.app')
@push('fontawesome')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post Detail</div>
                <div class="card-body">
                    <ul>
                      
                         <li>{{ $post->title }}</li>
                         <like-component :post="{{ $post->id }}"></like-component>
                         <dis-like-component :post="{{ $post->id }}"></dis-like-component>
                         
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 