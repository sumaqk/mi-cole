<ul class="sidebar-menu" data-widget="tree">
    <li class="header">Opciones de acceso de la plataforma</li>
    @if (Session::has('idUser'))
        <li id="mControlPanel" class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Panel de control</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li id="miHome"><a href="{{ url('index/indexadmin') }}"><i class="fa fa-circle-o"></i> Página de
                        inicio</a></li>
                <li><a href="{{ url('/') }}"><i class="fa fa-circle-o"></i> Ir al sitio web</a></li>
                @if (ViewHelper::hasMainRole('Súper usuario'))
                    <li id="miConfigurationManagement" style="border-top: 1px solid #555555;"><a
                            href="{{ url('configuration/management') }}"><i class="fa fa-circle-o"></i> Configuración
                            general</a></li>
                @endif
                @if (ViewHelper::hasMainRole('Súper usuario') || ViewHelper::hasMainRole('Administrador'))
                    <li id="miGeneralBackup"><a href="#"
                            onclick="confirmDialog(function(){ window.location.href='{{ url('general/backup') }}'; });"><i
                                class="fa fa-circle-o"></i> Backup de datos</a></li>
                    <li id="miExceptionGetAll"><a href="{{ url('exception/getall') }}"><i class="fa fa-circle-o"></i>
                            Lista de excepciones</a></li>
                @endif
            </ul>
        </li>
    @endif
    @if (ViewHelper::hasMainRole('Súper usuario') || ViewHelper::hasMainRole('Administrador'))
        <li id="mUserModule" class="treeview">
            <a href="#">
                <i class="fa fa-users"></i> <span>Módulo de usuarios</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li id="miUserInsertAsAdmin"><a href="{{ url('user/insertasadmin') }}"><i class="fa fa-circle-o"></i>
                        Registrar usuario</a></li>
                <li id="miUserGetAll"><a href="{{ url('user/getall/1') }}"><i class="fa fa-circle-o"></i> Lista de
                        usuarios</a></li>
            </ul>
        </li>
    @endif
    @if (ViewHelper::hasMainRole('Súper usuario') || ViewHelper::hasMainRole('Administrador'))
        <li id="mInstitutionModule" class="treeview">
            <a href="#">
                <i class="fa fa-university"></i> <span>Módulo de instituciones</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li id="miInstitutionInsert"><a href="{{ url('institution/insert') }}"><i class="fa fa-circle-o"></i>
                        Nueva institución</a></li>
                <li id="miInstitutionModuleGetAll"><a href="{{ url('institution/getall/1') }}"><i
                            class="fa fa-circle-o"></i> Lista de instituciones</a></li>
            </ul>
        </li>
    @endif
    @if (ViewHelper::hasMainRole('Súper usuario') || ViewHelper::hasMainRole('Administrador'))
        <li id="mUgelModule" class="treeview">
            <a href="#">
                <i class="fa fa-graduation-cap"></i> <span>Módulo de UGELs</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li id="miUgelInsert"><a href="{{ url('ugel/insert') }}"><i class="fa fa-circle-o"></i> Nueva UGEL</a>
                </li>
                <li id="miUgelGetAll"><a href="{{ url('ugel/getall/1') }}"><i class="fa fa-circle-o"></i> Lista de
                        UGELs</a></li>
            </ul>
        </li>
    @endif
    @if (ViewHelper::hasMainRole('Súper usuario') || ViewHelper::hasMainRole('Administrador'))
        <li id="mDistrictModule" class="treeview">
            <a href="#">
                <i class="fa fa-map-marker"></i> <span>Módulo de distritos</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li id="miDistrictInsert"><a href="{{ url('district/insert') }}"><i class="fa fa-circle-o"></i> Nuevo
                        distrito</a></li>
                <li id="miDistrictModuleGetAll"><a href="{{ url('district/getall/1') }}"><i class="fa fa-circle-o"></i>
                        Lista de distritos</a></li>
            </ul>
        </li>
    @endif
    @if (ViewHelper::hasMainRole('Súper usuario') || ViewHelper::hasMainRole('Administrador'))
        <li id="mWaterModule" class="treeview">
            <a href="#">
                <i class="fa fa-life-saver"></i> <span>Supervisión de agua</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li id="miWaterModuleGetAll"><a href="{{ url('water/getall') }}"><i class="fa fa-circle-o"></i> Lista
                        de calidad</a></li>
            </ul>
        </li>
    @endif
    @if (ViewHelper::hasMainRole('Súper usuario') || ViewHelper::hasMainRole('Administrador'))
        <li id="mContenidoWebModule" class="treeview">
            <a href="#">
                <i class="fa fa-edit"></i> <span>Contenido Web</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li id="miContenidoWebVideos"><a href="{{ url('contenidoweb/videos') }}"><i class="fa fa-circle-o"></i>
                        Gestión de videos</a></li>
                <li id="miContenidoWebContenido"><a href="{{ url('contenidoweb/contenido') }}"><i
                            class="fa fa-circle-o"></i> Gestión de contenido</a></li>
            </ul>
        </li>
    @endif
</ul>
