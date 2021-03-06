@extends('frontend.layouts.app')

@section('content')
<div class="container">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>{{ $classWork->title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">
                                <a href="{{ route('classroom.detail', $classrooms->slug) }}">Kelas</a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ $classWork->title }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row ">
            @hasanyrole('student')
            <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12">
                @endhasanyrole
                @hasanyrole('teacher|owner')
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @endhasanyrole
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Deskripsi</h5>
                            <p class="card-text">{!! $classWork->description !!}</p>
                            @hasanyrole('student')
                            @if (is_object($complete))

                            <div class="alert alert-success alert-dismissible">
                                <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                                File sudah di kumpul
                            </div>
                            @endif
                            @endhasanyrole
                        </div>
                    </div>
                </div>
                @hasanyrole('student')

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                    <div class="card">
                        <div class="card-body" style="min-height: 115px; text-align: center">
                            @if (is_null($grade))
                            @if (is_object($complete))

                            Tugas Belum Diperiksa
                            @else
                            Tugas Belum Dikumpul
                            @endif
                            @else
                            <span style="font-size: 30px">Nilai</span><br>
                            <span style="font-size: 70px">
                                {{ $grade->grade}}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endhasanyrole
            </div>
    </section>
    <section class="content">
        <div class="card">
            @hasanyrole('student')
            @if (!is_object($complete))
            <div class="card-body">
                <h3 class="card-title">Unggah Tugas</h3>
                <p class="card-text">
                    <form action="/upload-assigment" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <!-- <label for="customFile">Custom File</label> -->

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="file">
                                <label class="custom-file-label" for="file">Choose file</label>
                            </div>
                        </div>
                        <input type="hidden" name="media_id" value="{{ $classWork->id }}">

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Unggah</button>
                        </div>
                    </form>
                </p>
            </div>
            @endif

            @endhasanyrole

            <!-- /.card-body -->
            <div class="card-footer card-comments">
                @foreach ($discussions as $key)
                <div class="card-comment">
                    <!-- User image -->
                    <img class="img-circle img-sm"
                        src="{{ asset('files') }}/{{ (App\Models\Media::where('media_type','user')->where('media_id',$key->user_id)->latest('created_at')->first())->file_name ?? 'avatar.png' }}"
                        alt="User Image">

                    <div class="comment-text">
                        <span class="username">
                            {{ DB::table('users')->where('id', $key->user_id)->first()->name }}
                            <span class="text-muted float-right">{{ $key->created_at }}</span>
                        </span><!-- /.username -->
                        {{ $key->message }}
                    </div>
                    <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
                @endforeach
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
                <form action="#" method="post">
                    @csrf
                    <img class="img-fluid img-circle img-sm"
                        src="{{ asset('files') }}/{{ (App\Models\Media::where('media_type','user')->where('media_id', Auth::user()->id)->latest('created_at')->first())->file_name ?? 'avatar.png' }}"
                        alt="Alt Text">
                    <!-- .img-push is used to add margin to elements next to floating images -->
                    <div class="img-push">
                        <textarea type="text" class="form-control form-control-sm" name="comment"
                            placeholder="Press enter to post comment"></textarea>
                        <input type="submit" class="btn btn-primary btn-sm float-right" value="kirim"
                            style="margin-top:5px">
                    </div>
                </form>
            </div>
            <!-- /.card-footer -->
        </div>
    </section>
</div>
@endsection