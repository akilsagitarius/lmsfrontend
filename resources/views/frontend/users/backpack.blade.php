@extends('frontend.layouts.app') @section('content')
    @push('page_css')
        <style>
            .ion-medium {
                font-size: 16px;
            }

            #card {
                border-radius: 4px;
                background: #fff;
                box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
                transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
                /* cursor: pointer; */
            }

            #card:hover {
                background: #f4f7fc;
                box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
            }

            .bookmark-active{
                color:#1b5cb8;
                font-size:22px;
            }

            .bookmark-default{
                color:rgb(190, 190, 190);
                font-size:22px;
            }
            .bookmark-clik:hover{
                transform: scale(1.20);
                cursor: pointer;
                color:#3b72ca;
            }

        </style>
    @endpush
    <div class="container">
        <div class="jumbotron jumbotron-fluid text-white p-5" style="background: linear-gradient(#206dda, #1b5cb8);border-radius:10px">
            <div class="container ">
                <div class="row">
                    <a style="font-size: 2.5em">Backpack</a>
                </div>
                <div class="row">
                    <a style="font-size: 1.5em">Temukan materi yang ada telah markah</a>
                </div>
            </div>
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            @forelse ($teachables as $teachable)
                            <div class="card" id="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        {{-- <div class="col col-lg-1 col-md-1 col-sm-1">
                                            <img src="{{ asset('study.png') }}" style="max-width: 50px"
                                                class="img-fluid">
                                        </div> --}}
                                        <div class="col-10 col-lg-10 col-md-10 col-sm-10">
                                            <div class="row">
                                                @if ($teachable->teachable_type == 'quiz')
                                                    <a data-toggle="tooltip" data-placement="top" title="Lihat Kuis"
                                                        style="font-weight: bold;"
                                                        href="{{ route('class.work.detail', ['quizzes', $teachable->teachable_id]) }}">

                                                        @if (App\Models\Progress::where('progress_type', 'quizzes')->where('progress_id', $teachable->teachable_id)->where('class_id', $teachable->classroom_id)->where('user_id', Auth::user()->id)->count() > 0)
                                                        <i class="fas fa-check-circle text-success"></i>
                                                        @endif

                                                        {{  App\Models\Classroom::find($teachable->classroom_id)->title }} : {{ App\Models\Quizzes::where('id', $teachable->teachable_id)->where('deleted_at', null)->first()->title }}
                                                    </a>
                                                @elseif ($teachable->teachable_type == 'resource')
                                                    <a data-toggle="tooltip" data-placement="top" title="Lihat Materi"
                                                        style="font-weight: bold;"
                                                        href="{{ route('class.work.detail', ['resources', $teachable->teachable_id]) }}">

                                                        @if (App\Models\Progress::where('progress_type', 'resources')->where('progress_id', $teachable->teachable_id)->where('class_id', $teachable->classroom_id)->where('user_id', Auth::user()->id)->count() > 0)
                                                        <i class="fas fa-check-circle text-success"></i>
                                                        @endif

                                                        {{  App\Models\Classroom::find($teachable->classroom_id)->title }} : {{ App\Models\Resource::where('id', $teachable->teachable_id)->where('deleted_at', null)->first()->title }}
                                                    </a>
                                                @elseif ($teachable->teachable_type == 'assignments')
                                                    <a data-toggle="tooltip" data-placement="top" title="Lihat Tugas"
                                                        style="font-weight: bold;"
                                                        href="{{ route('class.work.detail', ['assignments', $teachable->teachable_id]) }}">

                                                        @if (App\Models\Progress::where('progress_type', 'assignments')->where('progress_id', $teachable->teachable_id)->where('class_id', $teachable->classroom_id)->where('user_id', Auth::user()->id)->count() > 0)
                                                        <i class="fas fa-check-circle text-success"></i>
                                                        @endif

                                                        {{  App\Models\Classroom::find($teachable->classroom_id)->title }} : {{ App\Models\Assignment::where('id', $teachable->teachable_id)->where('deleted_at', null)->first()->title }}
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <span style="color: grey;font-size:10px">
                                                    Diposting
                                                    {{App\Models\User::find($teachable->created_by)->name}}
                                                    -
                                                    {{ date('d-m-Y H:iA', strtotime($teachable->updated_at)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-2 col-lg-2 col-md-2 col-sm-2">
                                            @if(is_null(App\Models\Bookmark::where('teachable_id',$teachable->id)->first() ))
                                                <i
                                                    data-teachable_id="{{$teachable->id}}"
                                                    data-toggle="tooltip"
                                                    data-placement="left"
                                                    class="onClick fa fa-bookmark float-right bookmark-clik bookmark-default add"
                                                    aria-hidden="true">
                                                </i>
                                            @else
                                                <i
                                                    data-teachable_id="{{$teachable->id}}"
                                                    data-toggle="tooltip"
                                                    data-placement="left"
                                                    class="onClick fa fa-bookmark float-right bookmark-clik bookmark-active remove"
                                                    aria-hidden="true">
                                                </i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="card" id="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            Belum ada meteri yang di markah
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('page_scripts')
    <script>
        $(".add").click(function(e) {
            e.preventDefault();
            let slug = $(this).data('slug');
            let teachable_id = $(this).data('teachable_id');
            let url = '{{ route("add_boomark") }}';
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    teachable_id: teachable_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('add bookmark : ',response);
                    if(response.status == 200){
                        $('.onClick').click(removeToAdd);
                        window.location.href = '';

                    }
                }
            });
        });

        $(".remove").click(function(e) {
            e.preventDefault();
            let slug = $(this).data('slug');
            let teachable_id = $(this).data('teachable_id');
            let url = '{{ route("remove_boomark") }}';
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    teachable_id: teachable_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('remove bookmark : ',response);
                    if(response == 200){
                        $('.onClick').click(removeToAdd);
                        window.location.href = '';

                    }
                }
            });
        });

        function removeToAdd() {
            $('.onClick').attr('class', 'onClick fa fa-bookmark float-right bookmark-clik bookmark-default add');
        }

        function addToRemove() {
            $('.onClick').attr('class', 'onClick fa fa-bookmark float-right bookmark-clik bookmark-active remove');
        }

    </script>


    <script>

        $(".not_allowed").click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Tidak di Izinkan',
                text: "Anda tidak terdaftar atau  tidak diizankan membuka materi ini!",
                icon: 'warning',
                confirmButtonColor: '#1b5cb8',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Tutup'
            })
        });
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        $(document).ready(function() {
            $('[data-togglebtn="tooltip"]').tooltip();
        });

    </script>
@endpush
