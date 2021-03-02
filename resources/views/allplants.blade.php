@extends('layouts.app')
{{--@include('header.styles_tecdoc')--}}
@section('content')
    <section class="section-1 container px-0 py-5 my-3">
            <!--INPUTS R HERE-->
            <table class="table table-responsive mx-auto " id="users-table">
                <thead>
                    <tr>
                        <th class="align-middle">Название</th>
                        <th class="align-middle">Цена</th>
                        <th class="align-middle">Номер детали</th>
                        <th class="align-middle">Остаток</th>
                        <th class="align-middle"></th>
                    </tr>
                </thead>
            </table>
    </section>
@endsection

@section('footer_scripts')
    @include('footer.script_tecdoc')
    <script>
        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
        });
        $(function () {
            $('#users-table').DataTable({
                language: {
                    "url": "/assets/datatables/rus.json"
                },
                processing: true,
                serverSide: true,
                ajax: '{!! route('nalichie.data') !!}',
                columns: [

                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    {data: 'number', name: 'number'},
                    {data: 'ostatok', name: 'ostatok'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

    {{--<!-- jQuery -->--}}
    {{--<script src="//code.jquery.com/jquery.js"></script>--}}
    {{--<!-- DataTables -->--}}
    {{--<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>--}}
    {{--<!-- Bootstrap JavaScript -->--}}
    {{--<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>--}}
    {{--<!-- App scripts -->--}}

@stop
