@foreach($menu ?? '' as $k => $v)
@if($v->name != 'Dashboard')
@if($v->number == 2)
<li class="menu-section pl-3">
    <h4 class="menu-text">Administrator</h4>
</li>
@endif
@if($v->number == 3)
<li class="menu-section pl-3">
    <h6 class="menu-text">User</h6>
</li>

@endif
@if($v->number == 4)
<li class="menu-section pl-3">
    <h6 class="menu-text">Medical record</h6>
</li>

@endif
@if($v->number == 5)
<li class="menu-section pl-3">
    <h6 class="menu-text">Notifikasi</h6>
</li>

@endif
@if($v->number == 6)
<li class="menu-section pl-3">
    <h6 class="menu-text">Lainya</h6>
</li>

@endif
<li class="menu-item menu-item-submenu <?php if ($v->slug == Request::segment(1) ) {echo 'menu-item-open';} ?>" aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="{{$v->icon}} menu-icon text-white"></i>
        <span class="menu-text text-white">{{$v->name}}</span>
        <i class="menu-arrow text-white"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <!-- <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text">Applications</span>
                                            </span>
                                        </li> -->
            @foreach($submenu as $a => $s)
            <?php if ($v->menu_id == $s->parent_menu_id) { ?>
            <li class="menu-item menu-item-<?php if ($s->slug == Request::segment(2) ) {echo 'active';} else { echo 'submenu';} ?>" aria-haspopup="true">
                @if($s->slug =='chat')
                <a href="/{{$v->slug}}/{{$s->slug}}" class="menu-link" target="_blank">
                @else
                <a href="/{{$v->slug}}/{{$s->slug}}" class="menu-link">
                @endif
                    <i class="menu-bullet menu-bullet-dot text-white">
                        <span></span>
                    </i>
                    <span class="menu-text text-white">{{$s->name}}</span>
                    <!-- <span class="menu-label">
                                                    <span class="label label-danger label-inline">new</span>
                                                </span> -->
                </a>
            </li>
            <?php } ?>
            @endforeach
        </ul>
    </div>
</li>
@endif
@endforeach
</ul>
<!--end::Menu Nav-->
</div>
<!--end::Menu Container-->
</div>
<!--end::Aside Menu-->
</div>
<!--end::Aside-->
