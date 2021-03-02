@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Наши адреса</div>

                    <div class="panel-body">
                        @foreach($contacts as $contact)
                            <div class="row">
                                <div class="col-md-4">
                                    <p>{!! $contact->address !!}</p>
                                    <p>{!! $contact->phone !!}</p>
                                    <p>{!! $contact->mail !!}</p>
                                    <p>{!! $contact->comment !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <img style="max-width: 200px" src="{!! $contact->image !!}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
