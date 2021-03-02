@extends('layouts/app')

{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop

@include('header.styles_tecdoc')

@section('breadcrummbs')
    <div class="breadcum">
        {!! Breadcrumbs::render() !!}
    </div>
@stop

{{-- Page content --}}
@section('content')
            <div class="content">
                <div class="panel panel-primary filterable">
                    <div class="panel-heading clearfix  ">
                        <div class="panel-title pull-left">
                            <div class="caption">
                                <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                Модельный ряд
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="model" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Название модели</th>
                                <th>Начало Выпуска</th>
                                <th>Конец выпуска</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

@stop
@section('footer_scripts')
    @include('footer.script_tecdoc')
    <?php $url = '/podbortecdoc/' . $marks . '/data'  ?>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
        });
        $(function () {
            $('#model').DataTable({
                language: {
                    "url": "/assets/datatables/rus.json"
                },
                processing: true,
                serverSide: true,
                ajax: '{!! $url !!}',
                columns: [
                    {
                        "name": "MOD_ID",
                        "data": "MOD_ID",
                        "render": function (data, type, full, meta) {
                            return "<img src=\"/images/nissan/" + data + ".png\" height=\"50\"/>";
                        },
                        "title": "Image",
                        "orderable": true,
                        "searchable": true
                    },
                    {data: 'MOD_CDS_TEXT', name: 'MOD_CDS_TEXT'},
                    {data: 'MOD_PCON_START', name: 'MOD_PCON_START'},
                    {data: 'MOD_PCON_END', name: 'MOD_PCON_END'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        
        });

    </script>
@stop


