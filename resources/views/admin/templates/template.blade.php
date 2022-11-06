{{-- @auth --}}

@include('admin.templates.head')
<style>
    .badge {
        border-radius: 2px !important;
        font-size: 8pt;
    }

    .mb-0{
        margin-bottom: 0!important;
    }

</style>
@include('admin.templates.header')
@include('admin.templates.aside')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    {{-- <div class="callout callout-danger" style="border-radius: 0">
        <p> <strong>ERROR.</strong> Data gagal di simpan!</p>
    </div> --}}
    @if (session('status'))
    <div class="alert alert-{!! session('status') !!} alert-dismissible" style="border-radius: 0">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p> <strong>{!! session('type') !!}.</strong> {!! session('message') !!}</p>
    </div>
    @endif
    @yield('body')
</div>
<!-- /.content-wrapper -->
@include('admin.templates.footer')
@include('admin.templates.right-side')
@include('admin.templates.script')
{{-- @endauth --}}
