<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>HYDRAUCRUZ | </title>

    <!-- Bootstrap -->
    <link href="{{asset('assets/dashboard/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link href="{{asset('assets/dashboard/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('assets/dashboard/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('assets/dashboard/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{asset('assets/dashboard/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('assets/dashboard/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('assets/dashboard/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/DataTables/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    
    <!-- Custom Theme Style -->
    <link href="{{asset('assets/dashboard/build/css/custom.min.css')}}" rel="stylesheet">
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{url('home')}}" class="site_title"><i class="fa fa-wrench"></i> <span>HYDRAUCRUZ</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix" style="display: flex; justify-content: center; align-items: center;" >
                        <div class="profile_pic"  >
                            <img src="{{asset('assets/dashboard/images/HC2.png')}}" alt="..." class="img-circle" style="width: 120%">
                        </div>
                        
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <!--<li><a href="{{url('getAllAutomoviles')}}"><i class="fa fa-truck"></i> Movilidades <span class="fa fa-chevron-right"></span></a>
                                     <ul class="nav child_menu">
                                        <li><a href="index.html">Dashboard</a></li>
                                        <li><a href="index2.html">Dashboard2</a></li>
                                        <li><a href="index3.html">Dashboard3</a></li>
                                    </ul> 
                                </li>
                                <li><a><i class="fa fa-edit"></i> Más opciones <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{'getAllMarcas'}}">Marcas</a></li>
                                        <li><a href="{{'getAllClases'}}">Clases</a></li>
                                        <li><a href="{{'getAllTipos'}}">Tipos</a></li>
                                        <li><a href="{{'getAllPaises'}}">Procedencias</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{url('getAllChoferes')}}"><i class="fa fa-users"></i> Choferes <span class="fa fa-chevron-right"></span></a>
                                </li>
                                <li><a href="{{url('getAllAccesorios')}}"><i class="fa fa-cogs"></i> Accesorios <span class="fa fa-chevron-right"></span></a>
                                </li>-->
                                <li><a><i class="fa fa-info"></i> Inventario <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" >
                                        @can('inventario')
                                        <li><a href="{{url('mostrarinventario')}}">Inventario por Grupos</a></li>     
                                        @endcan
                                        <li><a href="{{url('mostrarinventariotodo')}}">Inventario Completo</a></li>
                                        <!--<li><a href="{{url('mostrarinventariotodosaldo')}}">Inventario Con Saldos</a></li>-->
                                        <li><a href="{{url('mostrararticulosmenoresa')}}">Inventario Menores A:</a></li>
                                        <li><a href="{{url('mostrarbienes')}}">Agregar Grupo O Item</a></li>
                                        @can('reportescf')
                                        <li><a>Reportes<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="{{url('mostrarinventariotodosf')}}">Inventario Completo</a></li>
                                                <li><a href="{{url('mostrarinventariotodosaldosf')}}">Inventario Con Saldos</a></li>
                                            </ul>
                                        </li>
                                        @endcan
                                    </ul>
                                </li>
                                <!--<li><a href="{{url('mostrarentradas')}}"><i class="fa fa-area-chart"></i> Compras <span class="fa fa-chevron"></span></a></li>-->
                                <li><a><i class="fa fa-area-chart"></i> Compras <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" >
                                        <li><a href="{{url('mostrarentradas')}}">Agregar Compra</a></li>
                                        <li><a href="{{url('mostrarproveedores')}}">Agregar Proveedor</a></li>
                                        <li><a href="{{url('reportefechaentrada')}}">Reporte por Fecha</a></li>
                                        @can('reportescf')<li><a href="{{url('librodecompras')}}">Libro de Compras</a></li>@endcan
                                    </ul>   
                                </li>   
                                <!--<li><a href="{{url('mostrarsalidas')}}"><i class="fa fa-line-chart"></i> Ventas <span class="fa fa-chevron"></span></a></li>-->
                                <li><a><i class="fa fa-line-chart"></i>Ventas <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" >
                                        <li><a href="{{url('mostrarsalidas')}}">Agregar Venta</a></li>
                                        <li><a href="{{url('mostrarclientes')}}">Agregar Cliente</a></li>
                                        <li><a href="{{url('reportefechasalida')}}">Reporte por Fecha</a></li>
                                        @can('reportescf')<li><a href="{{url('librodeventas')}}">Libro de Ventas</a></li>@endcan
                                    </ul>   
                                </li>  
                                <li><a href="{{url('mostrarcotizaciones')}}"><i class="fa fa-industry"></i> Cotizaciones <span class="fa fa-chevron"></span></a></li>
                                <li><a href="{{url('mostrarreservas')}}"><i class="fa fa-credit-card"></i> Reservas <span class="fa fa-chevron"></span></a></li>
                                <li><a><i class="fa fa-bar-chart"></i> Creditos <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" >
                                        <li><a href="{{url('mostrarcreditos/compra')}}">Compras</a></li>
                                        <li><a href="{{url('mostrarcreditos/venta')}}">Ventas</a></li>
                                    </ul>   
                                </li>                         
                                    
                                
                                @can('users.index')
                                    <li><a href="{{url('users')}}"><i class="fa fa-users"></i> Usuarios <span class="fa fa-chevron"></span></a></li>    
                                @endcan
                                <!--<li><a href="{{url('mostrarclientes')}}"><i class="far fa-address-card"></i>....Clientes <span class="fa fa-chevron"></span></a></li> 
                                <li><a href="{{url('mostrarproveedores')}}"><i class="fa fa-university"></i> Proveedores <span class="fa fa-chevron"></span></a></li>    -->
                                <li><a><i class="fa fa-bar-chart"></i> Caja <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" >
                                        <li><a href="{{url('mostrarcaja')}}">Movimiento de Caja</a></li>
                                        <li><a href="{{url('reportefechacaja')}}">Reporte por Fecha</a></li>
                                        @can('reportescaja')
                                        <li><a href="{{url('crearsaldoini')}}">Saldo inicial</a></li>
                                        @endcan
                                    </ul>   
                                </li>
                                <li><a><i class="fa fa-sitemap"></i> Bancos <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" >
                                        <li><a href="{{url('mostrarbancos')}}">Ver Bancos</a></li>
                                        <li><a>Movimiento Bancos<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                @php
                                                $bancos = App\Models\Banco::all();
                                                @endphp
                                                @foreach ($bancos as $banco)
                                                <li class="sub_menu"><a href="{{url('movimientobanco/'.$banco->id)}}">{{$banco->nombre_banco}}</a></li>
                                                @endforeach
                                                
                                                
                                            </ul>
                                        </li>
                                        <li><a href="{{url('reportefechabanco')}}">Reporte por Fecha</a></li>
                                    </ul>   
                                </li>
                                <li><a><i class="fa fa-sitemap"></i>Reportes Generales <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" >
                                        <li><a href="{{url('reportefechasalidadia')}}">Reporte general de Ingresos</a></li>
                                        <li><a href="{{url('reportefechaentradames')}}">Reporte general de Gastos</a></li>
                                        <li><a href="{{url('reportefechacuentaspagar')}}">Reporte general Cuentas por Pagar</a></li>
                                        <li><a href="{{url('reportefechacuentascobrar')}}">Reporte general Cuentas por Cobrar</a></li>
                                        <li><a href="{{url('reportegeneralsaldos')}}">Reporte general de Saldos</a></li>
                                    </ul>   
                                </li>
                            </ul>
                        </div>
                        <!--<div class="menu_section">
                            <h3>Live On</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="e_commerce.html">E-commerce</a></li>
                                        <li><a href="projects.html">Projects</a></li>
                                        <li><a href="project_detail.html">Project Detail</a></li>
                                        <li><a href="contacts.html">Contacts</a></li>
                                        <li><a href="profile.html">Profile</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="page_403.html">403 Error</a></li>
                                        <li><a href="page_404.html">404 Error</a></li>
                                        <li><a href="page_500.html">500 Error</a></li>
                                        <li><a href="plain_page.html">Plain Page</a></li>
                                        <li><a href="login.html">Login Page</a></li>
                                        <li><a href="pricing_tables.html">Pricing Tables</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="#level1_1">Level One</a>
                                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li class="sub_menu"><a href="level2.html">Level Two</a>
                                                </li>
                                                <li><a href="#level2_1">Level Two</a>
                                                </li>
                                                <li><a href="#level2_2">Level Two</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="#level1_2">Level One</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                            </ul>
                        </div>-->

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                     <img src="{{asset('assets/dashboard/images/HC2.png')}}" alt="" >
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="javascript:;"> Profile</a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">Help</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i>Cerrar Sesión </a> </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown open" style="padding-left: 25px;">
                                @if (Auth::user() != null)
                                    <a href="{{'home'}}">{{Auth::user()->name}}</a>
                                @else
                                    <a href="{{'home'}}">---</a>
                                @endif
                                
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="row">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="dashboard_graph">
                            @yield('ruta')
                            <br>
                            @yield('content')
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
                <br />

            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                     <a href="http://hydraucruz@hotmail.com">hydraucruz@hotmail.com</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    @yield('modal')
    
    <script src="{{asset('js/app.js')}}"></script>
    <!-- jQuery -->
    <script src="{{asset('assets/dashboard/vendors/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/vendors/jquery-validation/dist/jquery.validate.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('assets/dashboard/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{asset('assets/dashboard/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{asset('assets/dashboard/build/js/custom.min.js')}}"></script>

    <!-- para select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>




    <!-- datatables -->
    <script type="text/javascript" charset="utf8" src="{{asset('assets/DataTables/datatables.js')}}"></script>
    <script src="{{asset('assets/DataTables/dataTables.bootstrap4.min.js')}}"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

    @yield('js')

</body>

</html>