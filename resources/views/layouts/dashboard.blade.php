<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>gCommerciale</title>
    
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
    
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}"  rel="stylesheet">
        <link href="{{ asset('css/all.css') }}"  rel="stylesheet">
        <link href="{{asset('css/virtual-select.min.css')}}"  rel="stylesheet">

        

        <!-- Fonts -->
        <link href="{{ asset('css/font.css') }}" rel="stylesheet">
       
     
        <script src="{{ asset('js/jquery.min.js') }}"></script>
 
        <script src="{{ asset('js/sweetalert.min.js') }}" ></script>

        <script src="{{ asset('js/virtual-select.min.js') }}" ></script>
      
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                   beka
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle"   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

<div class="main d-flex">
    <div class=" side-bar bg-white shadow " > 
        

        <div class="text-center mt-4">
            <img  src="/img/user.png" width="80" height="90" alt="" >
            <p class="mt-2" style="font-weight: bold"> {{ Auth::user()->name }} (Admin)</p>
           

        </div>
        <hr>

        
        
        <ul class="text center">
            <li><a class="{{ (request()->segment(2) == 'stats') ? 'active' : '' }}" href="/dashboard/stats"> <i class="fas fa-chart-line"></i>Dashboard</a></li>
           
            <li><a class="{{ (request()->segment(2) == 'Clients') ? 'active' : '' }}"  href="/dashboard/Clients"><i class="fa-solid fa-users"></i>Gestion de Clients</a></li>

            <li><a class="{{ (request()->segment(2) == 'BL') ? 'active' : '' }}"  href="/dashboard/BL"><i class="fa-solid fa-file-invoice-dollar"></i>Gestion de BLs</a></li>
            <li><a class="{{ (request()->segment(2) == 'Factures') ? 'active' : '' }}" href="/dashboard/Factures"><i class="fa-solid fa-file-lines"></i>Gestion de Factures</a></li>
    
                
            

            @if (Auth::user()->role == "caissier" || Auth::user()->role == "admin")
            <li><a class="{{ (request()->segment(2) == 'Caisse') ? 'active' : '' }}"  href="/dashboard/Caisse"><i class="fa-solid fa-cash-register"></i>Gestion de la Caisse</a></li>
            {{-- <li><a class="{{ (request()->segment(2) == 'Bank') ? 'active' : '' }}"  href="/dashboard/Bank"><i class="fa-solid fa-building-columns"></i>Gestion de la Banque</a></li> --}}
    
            @endif
          
       
      
     

        






    

      
     </ul>
    
    
    </div>

    <div class="main flex-grow-1 mt-4">
      
        @yield('content')
    </div>

</div>




<script
src="{{asset('js/popper.min.js')}}"
></script>
<script
src="{{asset('js/bootstrap.min.js')}}"

></script>




<script>

$(document).ready(function(){
  $("#searchP , #searchP2 ").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  



});


</script>
</body>
</html>
 
