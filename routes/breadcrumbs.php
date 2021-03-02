<?php

// main
Breadcrumbs::register('main', function ($breadcrumbs) {
    $breadcrumbs->push('Главная', route('main'));
});

// main > About
Breadcrumbs::register('cart', function ($breadcrumbs) {
    $breadcrumbs->parent('main');
    $breadcrumbs->push('Корзина', route('cart'));
});

Breadcrumbs::register('pegasus', function ($breadcrumbs) {
    $breadcrumbs->parent('main');
    $breadcrumbs->push('TecDoc', route('pegasus'));
});

Breadcrumbs::register('model', function ($breadcrumbs, $marks) {

    $mark = \App\Models\Marks::where('manuId', $marks)->first();

    $breadcrumbs->parent('pegasus');
    $breadcrumbs->push($mark->name, route('model', $mark->manuId));
});

Breadcrumbs::register('modif', function ($breadcrumbs,$marks,$models) {
//    $types = \App\Models\TecDoc\Models::where([['MOD_MFA_ID',$marks],['MOD_ID',$Models]])->first();

    $types = \App\Models\ModelsCars::where('modelId', $models)->first();

//    dd($types);
    $breadcrumbs->parent('model',$marks);
    $breadcrumbs->push($types->modelname, route('modif',[$marks,$models,$types->modelId]));
});

Breadcrumbs::register('tree', function ($breadcrumbs,$marks,$models,$modifs) {

    $data = Cache::tags([$marks, $models])->get($modifs);
    $breadcrumbs->parent('modif',$marks,$models);
    $breadcrumbs->push($data, route('maintree',[$marks,$models,$modifs]));
});

Breadcrumbs::register('subtree', function ($breadcrumbs,$marks,$models,$modifs,$maintree) {
    $data = Cache::tags([$marks, $models,$modifs])->get($maintree);
//dd($data);
    $breadcrumbs->parent('tree',$marks,$models,$modifs);

    $breadcrumbs->push($data, route('subtree',[$marks,$models,$modifs,$maintree]));
});
Breadcrumbs::register('subtree1', function ($breadcrumbs,$marks,$models,$modifs,$maintree,$parenid) {
    $data =  Cache::tags([$marks, $models,$modifs,$maintree])->get($parenid);

    $breadcrumbs->parent('subtree',$marks,$models,$modifs,$maintree);
    $breadcrumbs->push($data , route('subtree1',[$marks,$models,$modifs,$maintree,$parenid]));
});


Breadcrumbs::register('pgspares', function ($breadcrumbs,$marks,$models,$modifs,$maintree,$parenid,$parenid1) {
    $data = Cache::tags([$marks,$models,$modifs,$maintree,$parenid])->get($parenid1);
//dd($data,$marks,$models,$modifs,$maintree,$parenid,$parenid1);
    $breadcrumbs->parent('subtree1',$marks,$models,$modifs,$maintree,$parenid);
    $breadcrumbs->push($data, route('pgspares',[$marks,$models,$modifs,$maintree,$parenid,$parenid1]));
});

Breadcrumbs::register('pgsparesfull', function ($breadcrumbs,$marks,$models,$modifs,$maintree,$parenid,$parenid1,$articleId, $articleLinkId,$brandName) {
    $data = Cache::tags(['sp',$marks,$models,$modifs,$maintree,$parenid,$parenid1])->get($brandName);
//dd($data,$marks,$models,$modifs,$maintree,$parenid,$parenid1);
    $breadcrumbs->parent('pgspares',$marks,$models,$modifs,$maintree,$parenid,$parenid1);
    $breadcrumbs->push($data, route('pgsparesinfo',[$marks,$models,$modifs,$maintree,$parenid,$parenid1,$articleId, $articleLinkId,$brandName]));
});

Breadcrumbs::register('subtree2', function ($breadcrumbs,$marks,$models,$modifs,$maintree,$parenid,$parenid1) {
    $data = Cache::tags([$marks,$models,$modifs,$maintree,$parenid])->get($parenid1);
//dd($data,$marks,$models,$modifs,$maintree,$parenid,$parenid1);
    $breadcrumbs->parent('subtree1',$marks,$models,$modifs,$maintree,$parenid);
    $breadcrumbs->push($data, route('subtree2',[$marks,$models,$modifs,$maintree,$parenid,$parenid1]));
});
Breadcrumbs::register('pgspares1', function ($breadcrumbs,$marks,$models,$modifs,$maintree,$parenid,$parenid1,$parenid2) {
    $data = Cache::tags([$marks,$models,$modifs,$maintree,$parenid,$parenid1])->get($parenid2);

//    dump(Cache::tags([$marks,$models,$modifs,$maintree,$parenid,$parenid1])->has($parenid2));
//dd($data,$marks,$models,$modifs,$maintree,$parenid,$parenid1);
    $breadcrumbs->parent('subtree2',$marks,$models,$modifs,$maintree,$parenid,$parenid1);
    $breadcrumbs->push($data, route('pgspares1',[$marks,$models,$modifs,$maintree,$parenid,$parenid1,$parenid2]));
});

Breadcrumbs::register('pgsparesfull1', function ($breadcrumbs,$marks,$models,$modifs,$maintree,$parenid,$parenid1,$parenid2,$articleId, $articleLinkId,$brandName) {
    $data = Cache::tags(['sp',$marks,$models,$modifs,$maintree,$parenid,$parenid1,$parenid2])->get($brandName);
//dd($data,$marks,$models,$modifs,$maintree,$parenid,$parenid1);
    $breadcrumbs->parent('pgspares1',$marks,$models,$modifs,$maintree,$parenid,$parenid1,$parenid2);
    $breadcrumbs->push($data, route('pgsparesinfo1',[$marks,$models,$modifs,$maintree,$parenid,$parenid1,$parenid2,$articleId, $articleLinkId,$brandName]));
});
// main > Blog
//Breadcrumbs::register('blog', function($breadcrumbs)
//{
//    $breadcrumbs->parent('main');
//    $breadcrumbs->push('Blog', route('blog'));
//});
//
//// main > Blog > [Category]
//Breadcrumbs::register('category', function($breadcrumbs, $category)
//{
//    $breadcrumbs->parent('blog');
//    $breadcrumbs->push($category->title, route('category', $category->id));
//});
//
//// main > Blog > [Category] > [Page]
//Breadcrumbs::register('page', function($breadcrumbs, $page)
//{
//    $breadcrumbs->parent('category', $page->category);
//    $breadcrumbs->push($page->title, route('page', $page->id));
//});