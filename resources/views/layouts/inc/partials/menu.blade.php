@if (($menu_item->page_id && is_object($menu_item->page)) || !$menu_item->page_id)
    @if ($menu_item->children->count())
        @foreach ($menu_item->children as $i => $child)
            <li class="navitem dropdown {{ ($k==0)?' fistitem':'' }} {{ ($child->url() == Request::url())?'active':'' }}">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false">{{ $menu_item->name }} <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    @foreach ($menu_item->children as $i => $child)
                        <li class=""><a href="{{ $child->url() }}">{{ $child->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    @else
        <li class="nav-item px-2 {{ ($k==0)?' fistitem':'' }} {{ ($menu_item->url() == Request::url())?' active':'' }}">
            <a class="nav-link" href="{{ $menu_item->url() }}">{{ $menu_item->name }}</a>
        </li>
    @endif
@endif