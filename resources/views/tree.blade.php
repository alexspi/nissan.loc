@extends('layouts.app')
@section('header.header_styles')
    <link href="{{ asset('assets/css/jquery.nestable.css') }}" rel="stylesheet">
@endsection


@section('content')
        <div class="row">
            {{--<textarea id="nestable-output"></textarea>--}}
            <menu id="nestable-menu">
                <button type="button" data-action="expand-all">Expand All</button>
                <button type="button" data-action="collapse-all">Collapse All</button>

            </menu>
            <div class="dd" id="nestable3">
                <ol class='dd-list dd3-list'>
                    <div id="dd-empty-placeholder"></div>
                </ol>
            </div>
            <button id="toArray" class="btn btn-success ladda-button" data-style="zoom-in"><span
                        class="ladda-label"><i class="fa fa-save"></i> Сохранить </span>
            </button>
        </div>

@endsection

@section('footer_scripts')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="{{asset('/assets/js/jquery.nestable2.js')}}"></script>
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.5.0/jquery.nestable.min.js"></script>--}}
    <script src="{{asset('/assets/js/jquery.nestable++.js')}}"></script>
    <script>
        $(document).ready(function(){


            var json ='{!! $result !!}';

//            $('#nestable3').nestable({
//
//                json: json,
//                contentCallback: function(item) {
//                    var content = item.content || '' ? item.content : item.name;
//                    content += ' <i>(id = ' + item.id + ')</i>';
//                    content += ' <span class="button-delete btn btn-default btn-xs pull-right" data-action="removeRow"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span>';
//                    content += ' <span class="button-edit btn btn-default btn-xs pull-right"  data-owner-id="' + item.id + '"> <i class="fa fa-pencil" aria-hidden="true"></i> </span>';
//
//                    return content;
//                }
//
//            }).on('change', function() {
//                $('.inputField').off();
//
//                $('.inputField').on('focusout',function() {
//                    $('#nestable3').trigger("change");
//                });
//
//            });
            $(document).ready(function(){
                var obj = json;
                var output = '';
                function buildItem(item) {

                    var html = "<li class='dd-item' data-id='" + item.id + "'>";
                    html += "<div class='dd-handle'>" + item.name ;
                    html += "<span class='button-delete btn btn-default btn-xs pull-right' data-action='removeRow'><i class='fa fa-times-circle-o' aria-hidden='true'></i></span> <a title='Remove Row' class='removeButton pull-right' data-action='removeRow'>X</a></div>";
                    if (item.children) {

                        html += "<ol class='dd-list'>";
                        $.each(item.children, function (index, sub) {
                            html += buildItem(sub);
                        });
                        html += "</ol>";

                    }

                    html += "</li>";

                    return html;
                }

                $.each(JSON.parse(obj), function (index, item) {

                    output += buildItem(item);

                });

                $('#dd-empty-placeholder').html(output);
                $('#nestable3').nestable().on('change', function() {

                    $('.inputField').off();

                    $('.inputField').on('click',function() {
                        $('#nestable3').trigger("change");
                    });
                });
            });


            $('#nestable-menu').on('click', function(e) {
                var target = $(e.target),
                    action = target.data('action');
                if(action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if(action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }

            });

            $('#del').on('click', function(e) {
                var target = $(e.target),
                action = target.data('del');
                console.log(action);
//                    $('.dd').nestable('remove', action);


            });


            $('#toArray').on('click',function () {
                var f = $('.dd').nestable();

                console.log(f);

                var list = f.length ? f : $(f.target),
                    output = list.data('output');
//                console.log(JSON.stringify(list.nestable('serialize')));
 var dataup = JSON.stringify(list.nestable('serialize'))

                var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
                // send it with POST
                $.ajax({
                    
                    url: '/maketree/cat',
                    type: 'POST',
                    
                    data: {_token: CSRF_TOKEN, data:dataup},
                })
                    .done(function () {
                        console.log("success",dataup);
                        {{--new PNotify({--}}
                            {{--title: "{{ trans('backpack::crud.reorder_success_title') }}",--}}
                            {{--text: "{{ trans('backpack::crud.reorder_success_message') }}",--}}
                            {{--type: "success"--}}
                        {{--});--}}
                    })
                    .fail(function () {
                        console.log("error");
                        {{--new PNotify({--}}
                            {{--title: "{{ trans('backpack::crud.reorder_error_title') }}",--}}
                            {{--text: "{{ trans('backpack::crud.reorder_error_message') }}",--}}
                            {{--type: "danger"--}}
                        {{--});--}}
                    })
                    .always(function () {
                        console.log("complete");
                    });

            });

            $.ajaxPrefilter(function (options, originalOptions, xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-XSRF-TOKEN', token);
                }
            });


        });

    </script>
@stop
