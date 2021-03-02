@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
      </h1>
      {{--<ol class="breadcrumb">--}}
        {{--<li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>--}}
        {{--<li class="active">{{ trans('backpack::base.dashboard') }}</li>--}}
      {{--</ol>--}}
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
    
               
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('backpack::base.login_status') }}</div>
                </div>

                <div class="box-body">{{ trans('backpack::base.logged_in') }}</div>
                <div class="container">
                    <a href="{{ URL::to('admin/downloadExcel/xls') }}"><button class="btn btn-success">Excel xls</button></a>
                    <a href="{{ URL::to('admin/downloadExcel/xlsx') }}"><button class="btn btn-success">Excel xlsx</button></a>
                    <a href="{{ URL::to('admin/downloadExcel/csv') }}"><button class="btn btn-success">CSV</button></a>
                <form action="{{ route('import') }}" method="post" class="form-inline" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="file" name="import_file" class="form-control">
                    <button class="btn btn-primary">Импорт</button>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
