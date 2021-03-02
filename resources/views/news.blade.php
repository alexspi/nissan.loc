@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

        </div>
       {{--{!!   dump($news)!!}--}}
        <div class="col-md-10">

                <div>
                    
                  <h2> {!! $title !!}</h2><p> {!! $news['date'] !!}</p>
    
                    <img src="/{!! $news->image !!}" alt="{!! $news->title!!}" width="100%"; >
                    <p>{!! $news['content'] !!}</p>

                </div>


        </div>

    </div>
    </div>
    </div>
@endsection

@section('footer_scripts')

@stop
