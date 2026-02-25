@extends('layouts.petugas')

@section('content')

<h2>Detail Hasil Ujian UJSIMP</h2>

@include('components.ujsimp.document')

@if($test->workflow_status === 'draft')
    <div style="margin-top:20px;">
        <a href="{{ route('petugas.ujsimp.edit',$test->id) }}">
            Edit Nilai
        </a>

        <form method="POST"
              action="{{ route('petugas.ujsimp.submit',$test->id) }}"
              style="display:inline;">
            @csrf
            <button type="submit">
                Submit ke Admin
            </button>
        </form>
    </div>
@endif

@if($test->isDraft() || $test->isRejected())
    <form action="{{ route('petugas.ujsimp.submit',$test->id) }}" method="POST">
        @csrf
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Submit ke Admin
        </button>
    </form>
@endif

@endsection