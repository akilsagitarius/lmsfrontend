<div class="table-responsive">
    <table id="example2" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tipe Soal</th>
                <th>Pertanyaan</th>
                <th>Dibuat Oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach ($questions as $question)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $question->question_type }}</td>
                <td>{!! $question->content !!}</td>
                <td>{{ App\Models\User::find($question->created_by)->name }} </td>
                <td width="120">
                    {!! Form::open(['route' => ['questions.destroy', $question->id], 'method' => 'delete']) !!}

                    <a href="{{ route('questions.edit', [$question->id]) }}" class='btn btn-primary btn-sm'>
                        <i class="far fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-sm delete" id="delete" data-id="{{ $question->id }}"
                        data-url="{{ url('admin/questions/destroy') }}/{{ $question->id }}">
                        <i class="far fa-trash-alt"></i>
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
