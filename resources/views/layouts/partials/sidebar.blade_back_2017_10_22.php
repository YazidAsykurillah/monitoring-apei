<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        @if(Auth::user()->profile_picture != NULL)
          <?php $user_profile = \Auth::user()->profile_picture; ?>
          {!! Html::image('img/user/thumb_'.$user_profile, 'User Image', ['class'=>'img-circle']) !!}
        @else
          {!! Html::image('img/admin-lte/user2-160x160.jpg', 'User Image', ['class'=>'img-circle']) !!}
        @endif

      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
        <a href="#"><i class="fa fa-lock text-success"></i>{{ Auth::user()->roles->first()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">NAVIGATION</li>
      <li {{{ (Request::is('home') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('home') }}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

      @if(\Auth::user()->can('index-dpd'))
      <li {{{ (Request::is('dpd*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('dpd') }}">
          <i class="fa fa-home"></i> <span>DPD</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-proposal'))
      <li class="treeview {{{ (Request::is('proposal*') ? 'active':'') }}}">
        <a href="#">
          <i class="fa fa-newspaper-o"></i>
          <span>Proposal</span>
        </a>
        <ul class="treeview-menu">
          <li class="{{{ (Request::is('proposal/?status=all') ? 'active':'') }}}">
            <a href="{{ URL::to('proposal/?status=all') }}">
              <i class="fa fa-circle-o"></i> Daftar Proposal
            </a>
          </li>
         
          <li class="{{{ (Request::is('proposal/?status=9') ? 'active':'') }}}">
            <a href="{{ url('proposal/?status=9') }}">
              <i class="fa fa-circle-o"></i> Arsip Proposal
            </a>
          </li>
        </ul>
      </li>
      @endif

      @if(\Auth::user()->can('index-member'))
      <li {{{ (Request::is('member*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('member') }}">
          <i class="fa fa-user"></i> <span>Member</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-administrator-dpp') || \Auth::user()->can('index-administrator-dpd'))
      <li class="treeview {{{ (Request::is('user*') ? 'active':'') }}}">
        <a href="#">
          <i class="fa fa-user-secret"></i>
          <span>Administrator</span>
        </a>
        <ul class="treeview-menu">
          @if(\Auth::user()->can('index-administrator-dpp'))
          <li class="{{{ (Request::is('user-dpp*') ? 'active':'') }}}">
            <a href="{{ URL::to('user-dpp') }}">
              <i class="fa fa-circle-o"></i> Administrator DPP
            </a>
          </li>
          @endif
          <li class="{{{ (Request::is('user-dpd*') ? 'active':'') }}}">
            <a href="{{ url('user-dpd') }}">
              <i class="fa fa-circle-o"></i> Administrator DPD
            </a>
          </li>
        </ul>
      </li>
      @endif
      @if(\Auth::user()->can('access-configuration'))
      <li class="treeview {{{ (Request::is('configuration*') ? 'active':'') }}}">
        <a href="#">
          <i class="fa fa-cog"></i>
          <span>Configuration</span>
        </a>
        <ul class="treeview-menu">
          
          <li class="{{{ (Request::is('configuration/proposal/equalization') ? 'active':'') }}}">
            <a href="{{ URL::to('configuration/proposal/equalization') }}">
              <i class="fa fa-circle-o"></i> Proposal Penyetaraan
            </a>
          </li>
          <li class="{{{ (Request::is('configuration/proposal/new') ? 'active':'') }}}">
            <a href="{{ URL::to('configuration/proposal/new') }}">
              <i class="fa fa-circle-o"></i> Proposal Pengajuan Baru
            </a>
          </li>
          <li class="{{{ (Request::is('configuration/proposal/extension') ? 'active':'') }}}">
            <a href="{{ URL::to('configuration/proposal/extension') }}">
              <i class="fa fa-circle-o"></i> Proposal Perpanjangan
            </a>
          </li>
          <li class="{{{ (Request::is('configuration/role*') ? 'active':'') }}}">
            <a href="{{ URL::to('configuration/role') }}">
              <i class="fa fa-circle-o"></i> Role
            </a>
          </li>
          <li class="{{{ (Request::is('configuration/permission*') ? 'active':'') }}}">
            <a href="{{ URL::to('configuration/permission') }}">
              <i class="fa fa-circle-o"></i> Permission
            </a>
          </li>
        </ul>
      </li>
      @endif

    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
