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
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}"  rel="stylesheet">
        <link href="{{ asset('css/all.css') }}"  rel="stylesheet">
        <link href="{{asset('css/virtual-select.min.css')}}"  rel="stylesheet">

        

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
       
     
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

        <li><a class="{{ (request()->segment(2) == 'Caisse') ? 'active' : '' }}"  href="/dashboard/Caisse"><i class="fa-solid fa-cash-register"></i>Gestion de Caisse</a></li>
      
     

        






    

      
     </ul>
    
    
    </div>

    <div class="main flex-grow-1 mt-4">
      
        @yield('content')
    </div>

</div>




<script
src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
crossorigin="anonymous"
></script>
<script
src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
crossorigin="anonymous"
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
 
