@extends('layouts.admin')

@section('content')

<form method="GET"
      action="{{ route('admin.simper.preview', $assessment->id) }}"
      style="margin-bottom:20px;">

    <label>
        <input type="checkbox" name="header"
            {{ request('header') ? 'checked' : '' }}>
        Header
    </label>

    <label style="margin-left:20px;">
        <input type="checkbox" name="footer"
            {{ request('footer') ? 'checked' : '' }}>
        Footer
    </label>

    <label style="margin-left:20px;">
        <input type="checkbox" name="watermark"
            {{ request('watermark') ? 'checked' : '' }}>
        Watermark
    </label>

    <button type="submit"
        style="margin-left:20px;padding:6px 14px;">
        Apply
    </button>
</form>

<div class="card-premium">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">

        <div>
            <h2 style="margin:0;font-size:20px;font-weight:700;">
                Preview Dokumen SIMPER
            </h2>
            <p style="margin:5px 0 0;color:#6b7280;font-size:14px;">
                Review sebelum mengunduh dokumen resmi
            </p>
        </div>

        <a href="{{ route('admin.simper.download', $assessment->id) }}"
           style="
            padding:10px 18px;
            background:var(--accent);
            color:white;
            border-radius:10px;
            text-decoration:none;
            font-weight:600;
            box-shadow:0 6px 16px rgba(244,180,0,0.4);
           ">
            ⬇ Download PDF
        </a>

    </div>

    <div style="
        border:1px solid #e5e7eb;
        border-radius:12px;
        overflow:hidden;
        height:900px;
        box-shadow:0 8px 30px rgba(0,0,0,0.08);
    ">

        <iframe
            src="{{ route('admin.simper.download', $assessment->id) }}"
            width="100%"
            height="100%"
            style="border:none;">
        </iframe>

    </div>

</div>

@endsection