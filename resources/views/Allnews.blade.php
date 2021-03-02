@extends('layouts.app')
@section('content')
    <section class="section-1 container px-3 py-5 my-3">
        <h1>Новости нашего магазина</h1>
        <hr>
    </section>
    <section class="section-2 container px-3 py-5">
            @foreach($articles as $article)
                <div class="news-block">
                    <div class="inner">
                        <!--<h3><a href="{{ url('news/'.$article->id) }}">{!!$article->title  !!} </a></h3>-->
                        <!--<img src="{!! $article->image !!}" alt="{!! $article->title!!}" width="100%"; >-->
                        <?php $text=str_limit($article->content, $limit = 550, $end = '...')?>
                        <p class="h3">{!!$article->title!!}</p>
                        <p>{!! $text !!}</p>
                        <small class="post-date"><i>{!!date_format($article->date,'d-m-Y')!!}</i></small>
                        <!--<div class="news-bottom clearfix">
                            <a class="btn btn-default" role="button" href="{{ url('news/'.$article->id) }}">Читать новость</a>
                            <i></i>
                        </div>-->
                    </div>
                </div>
            @endforeach
        <?php echo $articles->links(); ?>
    </section>
@endsection
@section('footer_scripts')
@stop
