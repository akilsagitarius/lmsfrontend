@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Flashcard Questions</h1>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-primary float-right" href="{{ route('flashcardQuestions.create') }}">
                    Add New
                </a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="card card-primary card-outline">
        <div class="card-body">
            @include('flashcard_questions.table')

        </div>

    </div>

</div>

@endsection