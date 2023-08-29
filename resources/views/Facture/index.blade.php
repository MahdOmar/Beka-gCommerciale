

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>gCommerciale</title>
    
        <!-- Scripts -->
       
    
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
    
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}"  rel="stylesheet">
        <link href="{{ asset('css/all.css') }}"  rel="stylesheet">
        <link href="{{asset('css/virtual-select.min.css')}}"  rel="stylesheet">
        <link href="{{ asset('css/font.css') }}" rel="stylesheet">


        

        <!-- Fonts -->
     
   
        <script
        src="{{asset('js/popper.min.js')}}"
        ></script>
        <script
        src="{{asset('js/bootstrap.min.js')}}"
        
        ></script>


     

       

        
      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
       

        <script src="{{ asset('js/jquery.min.js') }}" ></script>
        <script src="{{ asset('js/sweetalert.min.js') }}" ></script>

        <script src="{{ asset('js/virtual-select.min.js') }}" ></script>
      
       
        
        


        <script>
             
        
      </script>

<script src="{{ asset('js/app.js') }}" defer></script>
       
      
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
          <li><a class="{{ (request()->segment(2) == 'Clients') ? 'active' : '' }}"  href="/dashboard/Clients"><i class="fa-solid fa-users"></i>Gestion de Client</a></li>

      <li><a class="{{ (request()->segment(2) == 'BL') ? 'active' : '' }}"  href="/dashboard/BL"><i class="fa-solid fa-file-invoice-dollar"></i>Gestion de BL</a></li>
      <li><a class="{{ (request()->segment(2) == 'Factures') ? 'active' : '' }}" href="/dashboard/Factures"><i class="fa-solid fa-file-lines"></i>Gestion de Facture</a></li>
      @if (Auth::user()->role == "caissier" || Auth::user()->role == "admin")
      <li><a class="{{ (request()->segment(2) == 'Caisse') ? 'active' : '' }}"  href="/dashboard/Caisse"><i class="fa-solid fa-cash-register"></i>Gestion de la Caisse</a></li>
      {{-- <li><a class="{{ (request()->segment(2) == 'Bank') ? 'active' : '' }}"  href="/dashboard/Bank"><i class="fa-solid fa-building-columns"></i>Gestion de la Banque</a></li> --}}
       @endif
     

        






    

      
     </ul>
    
    
    </div>

    <div class="main flex-grow-1 mt-4">

      <div class="m-3 ">

        <h4><a class="text-info" href="/dashboard">Dashborad</a> / Facture </h4>
      
      
      </div>
      <div  class=" shadow p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">
      
      <div class="row">
      
        <div class="col-md-4">
          <input type="text" name="search" class="form-control" id="searchP" placeholder="search" >
        </div>
     <div class="col-md-4"></div>
      
      
       
      
      <div class="col-md-4 d-flex justify-content-end">

       

       
       
      
        <div >
          @if($role == "commercial" || $role == "admin")
          <button  class="btn btn-dark btn-sm  p-2 text-white"  data-bs-toggle="modal" data-bs-target="#myModal" ><i class="fas fa-plus-square m-1"></i>Add Facture</button>
          @endif
        </div>
            
      </div>  
      
      </div>
          
       
        
             <table class="table table-striped table-hover text-center mt-2">
              <thead class="bg-dark text-white">
                <tr>
                  
                  <th>Facture</th>
                  <th>Client Name</th>
                  <th>Type</th>
                  <th>Mode de Payment</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>User</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
      
                  @foreach ( $facs as $fac)
                  @php
                     $expNum = explode('/', $fac->Fac_num);
                  @endphp
                  <tr>
                    <td>Facture N°{{ $expNum[0] }}/{{  str_pad($expNum[1], 3, '0', STR_PAD_LEFT) }} </td>
                    <td>{{ $fac->client->Name }}</td>
                    <td>{{ $fac->Type }}</td>
                    <td>{{ $fac->ModePay }}</td>
                    <td>{{ $fac->Status }}</td>
                    
                    <td>{{ $fac->created_at->format('d-m-Y') }} </td>
                    <td>{{ $fac->user->name }} </td>
                 
                    @if ($fac->user->id == $user || Auth::user()->role == "admin")
        
                    <td>
                      <a href="/dashboard/Factures/{{ $fac->id }}/details" class="btn btn-success text-white" role="button" ><i class="fas fa-plus-square"></i></a>
                      
                          
                           <button onclick="deleteFacture({{ $fac->id }})" id="btn{{ $fac->id }}" class='btn btn-danger' ><i class="fas fa-trash"></i></button>
                 
                         
                     </tr>
                        
                    @else
        
                    <td> 
                      <a href="/dashboard/Factures/{{ $fac->id }}/details" class="btn btn-success text-white" role="button" ><i class="fas fa-plus-square"></i></a>
                      
                          
                 
                         
                     </tr>
                        
                    @endif
                   
                      
                  @endforeach
              
            
              </tbody>
             </table>
      
             <div class="pagination d-flex justify-content-center mt-4 ">
            
              {{ $facs->links('pagination::bootstrap-4') }}
            </div>
            
             
         
            
            
             
             
      
      
      </div>
      
      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Facture</h4>
               
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              
            </div>
            <div class="modal-body">
          
               <p class="text-success success text-center"></p>
               <p class="text-danger error text-center"></p>
      
               <div class="form-group m-2 ">
                <label for="nameE" class="mb-2">Client:</label>
                <select name="nameE" id="ClientName" class="form-control form-select">
                  <option value="" disabled selected>Selectionner Client</option>
                @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->Name }}</option>
                    
                @endforeach
               
             </select>    
                
               
               
               </div>
      
               <div class="form-group m-2">
                  <label for="nameE" class="mb-2">Type:</label>
                  <select name="nameE" id="Type" class="form-control form-select">
                    <option value="" disabled selected>Selectionner Type de facture</option>
                    <option value="Normal" >Normal</option>
                    <option value="Proforma" >Proforma</option>
                  
                 
               </select>    
                  
                 
                 
                 </div>

                 
                 <div class="form-group m-2 new" style="display: none">
                  <label for="nameE" class="mb-2">Type Proforma:</label>
                  <select name="nameE" id="TypeP" class="form-control form-select">
                    <option value="" disabled selected>Nouveau / Depuis Bls</option>
                 
                  <option value="new">Nouveau</option>
                  <option value="Bls">Depuis Bls</option>
                      
                  
                 
               </select> 
                    
                 </div>


                 <div class="form-group m-2 " >
                  <label for="tva" class="mb-2">TVA:</label>
                  <select name="tva" id="tva" class="form-control form-select">
                 
                  <option value="19">19%</option>
                  <option value="09">09%</option>
                      
                  
                 
               </select> 
                    
                 </div>



      
                 <div class="form-group m-2 bls" style="display: none">
                  <label for="nameE" class="mb-2">Bls:</label>
                  <select  id="Bls" name="native-select" placeholder="Native Select" data-search="false" data-silent-initial-value-set="true"  class="form-control  " multiple  >
                    

                
                    
               </select>    
                  
                 
                 
                 </div>

      
      
      
      
                 <div class="form-group m-2 Mod" style="display:none">
                  <label for="nameE" class="mb-2">Mode de Payment:</label>
                  <select name="nameE" id="Mode" class="form-control form-select">
                    <option value="" disabled selected>Selectionner Mode de Payment</option>
                    <option value="Versement à la banque"> Versement à la banque</option>
                    <option value="Virement bancaire"> Virement bancaire</option>
                    <option value="Chèque bancaire">Chèque bancaire</option>
                    <option value="Espèces"> Espèces</option>
                  
                 
               </select>    
                  
                 
                 
                 </div>
      
      
      
        
            </div>
            <div class="modal-footer">
                <button
                type="button"
                class="btn btn-danger"
                data-bs-dismiss="modal"
              >
                Fermer
              </button>
              <div class="form-group">
              <button  class="btn btn-dark submit">Add </button>
              </div> 
            </div>
          </form>
          </div>
      
        </div>
      </div>
      
      <!--      Update Model             -->
      
      <div id="myModal2" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Facture</h4>
               
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              
            </div>
            <div class="modal-body">
          
               <p class="text-success successe text-center"></p>
               <p class="text-danger errore text-center"></p>
      
               <input type="hidden" id="id" name="id">
               <div class="form-group  m-2">
                <label for="nameE" class="mb-2">Client:</label>
                <select name="nameE" id="ClientNameE" class="form-control form-select">
      
                @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->Name }}</option>
                    
                @endforeach
      
                </select> 
               
                
               </div>
      
               <div class="form-group m-2">
                  <label for="nameE" class="mb-2">Type:</label>
                  <select name="nameE" id="TypeE" class="form-control form-select">
                    <option value="Normal" >Normal</option>
                    <option value="Proformat" >Proformat</option>
                  
                 
               </select>    
                  
                 
                 
                 </div>

                 <div class="form-group m-2 " >
                  <label for="tva" class="mb-2">TVA:</label>
                  <select name="tva" id="tvaE" class="form-control form-select">
                 
                  <option value="19">19%</option>
                  <option value="09">09%</option>
                      
                  
                 
               </select> 
                    
                 </div>
      
                 <div class="form-group m-2 Mod" style="display:none">
                  <label for="nameE" class="mb-2">Mode de Payment:</label>
                  <select name="nameE" id="ModeE" class="form-control form-select">
                      <option value="" disabled selected>Selectionner Mode de Payment</option>
                    <option value="cheque" >Chéque Bancaire</option>
                    <option value="verment" >Verment</option>
                    <option value="especes" >Especes</option>
                  
                 
               </select>    
                  
                 
                 
                 </div>
      
       
        
            </div>
            <div class="modal-footer">
                <button
                type="button"
                class="btn btn-danger"
                data-bs-dismiss="modal"
              >
                Fermer
              </button>
              <div class="form-group">
              <button  class="btn btn-dark update">Update </button>
              </div> 
            </div>
          </form>
          </div>
      
        </div>
      </div>
      
      
      
      
      
      
       
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

  $(function(){
  
    
  
         
         $('.submit').click(function(){
             $.ajaxSetup({
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
  
  
        if( $('#ClientName').val()  == null   )
        {
         
          $('.error').text("Selectionner Client");
          
         
          setTimeout(function() { $('.error').text('');
          
  
              }, 3000);
  
        }
  
        else if($('#Type').val() == null)
        {
          $('.error').text("Selectionner Type Facture");
          
         
          setTimeout(function() { $('.error').text('');
          
  
              }, 3000);
  
        }

        else if($('#tva').val() == null)
        {
          $('.error').text("Selectionner Type Facture");
          
         
          setTimeout(function() { $('.error').text('');
          
  
              }, 3000);
  
        }

        else if( ($('#myModal .bls').is(":visible") &&  $('#Bls').val().length == 0))
        {
  
          $('.error').text("Selectionner les Bls");
          
         
          setTimeout(function() { $('.error').text('');
         
          
  
              }, 3000);
  
        }


  
        else if( ($('#myModal .Mod').is(":visible") &&  $('#Mode').val() == null))
        {
  
          $('.error').text("Selectionner Mode de Payment");
          
         
          setTimeout(function() { $('.error').text('');
         
          
  
              }, 3000);
  
        }

        
  
  
  
  
  
        else{
  
        
             
  
           
            var data = {
              'date' : $('#date').val(),
              'ClientName': $('#ClientName').val(),
              'TypeP' :$('#TypeP').val(),
              'Type': $('#Type').val(),
              'tva': $('#tva').val(),
              'Mode': $('#Mode').val(),
              'Bls': $('#Bls').val()
            
             
            }

            
            // console.log(JSON.Parse($('#Bls').val()));
              
        
           $.ajax({
               url : '/dashboard/Facture',
               data: data,
               type: 'post',
             //  contentType: "application/json; charset=utf-8",
               dataType: 'json',
               success: function(result)
               {
  
              
              
            
               $('.success').text('Facture Added')
  
               $('#date').val('All')
  
               
  
               fetch(result);
         
  
              
               
  
               $('#ClientName').val('')
               $('#Type').val('')
               $('#Mode').val('')
             
  
               setTimeout(function() { $('.success').text('');
               $('#myModal').modal('toggle')
               }, 1000);
              
               
              
  
              
               
  
               },
              error: function()
              {
                  
               
              }
            });
          }
         });
        
        
     });
  
     function getFacture(id){
  
      $('.success').text("")
  
      $.ajaxSetup({
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
             
  
           
            var data = {
  
              'id': id,
             
            }
  
  
  
            $.ajax({
               url : '/dashboard/Facture/show',
               data: data,
               type: 'get',
             //  contentType: "application/json; charset=utf-8",
               dataType: 'json',
               success: function(result)
               {
                $.each(result, function(key, item){
                  $('#id').val(item.id)
  
                  $('#ClientNameE').val(item.client.id);
                  $('#TypeE').val(item.Type);
  
                  if(item.Type == "Normal")
                  {
                      $('.Mod').show()
                      $('#ModeE').val(item.ModePay);
                  }
  
                  else{
                      $('.Mod').hide()
                      $('#ModeE').val('');
  
                  }
  
                 
                  
  
  
  
                })
              
                
  
               }
            
              ,
               error: function()
              {
                  //handle errors
                  alert('error...');
              }
            });
  
     }
  
  
  
            $(function(){
         
         $('.update').click(function(){
             $.ajaxSetup({
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
    
     if( ($('#myModal2 .Mod').is(":visible") &&  $('#ModeE').val() == null))
        {
  
          $('.errore').text("Selectionner Mode de Payment");
          
         
          setTimeout(function() { $('.errore').text('');
          
  
              }, 3000);
  
        }
  
        else
        {
            
  
            
           
            var data = {
              'id': $('#id').val(),
             
              'ClientName': $('#ClientNameE').val(),
              'Type': $('#TypeE').val(),
              'Mode': $('#ModeE').val()
           
             
            }
             
              
        
            $.ajax({
               url : '/dashboard/Facture/update',
               data: data,
               type: 'post',
             //  contentType: "application/json; charset=utf-8",
               dataType: 'json',
               success: function(result)
               {
              
               
            
              $('.successe').text('Facture Updated')
              $('#date').val('All')
         
  
              
              fetch(result)
  
              
               setTimeout(function() { $('.successe').text('');
               $('#myModal2').modal('toggle')
               }, 1000);
  
  
              
  
  
              /*    */
               
  
               },
               error: function()
              {
                  //handle errors
                  alert('error...');
              }
            });
          }
         });
        
     });
  
     function deleteFacture(id)
  
     {
        $.ajaxSetup({
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }       
         });
  
         swal({
          title: 'Are you sure?',
          text: 'This record and it`s details will be permanantly deleted!',
          icon: 'warning',
          dangerMode: true,
          buttons: ["Cancel", "Yes!"],
      }).then(function(value) {
          if (value) {
         
         $.ajax({
               url : '/dashboard/Facture/delete',
               data:{'id':id},
               type: 'delete',
             //  contentType: "application/json; charset=utf-8",
               dataType: 'json',
               success: function(result)
               {
              
                $("#btn"+id).closest("tr").remove();
            
  
               },
               error: function()
              {
                
                  alert('error...');
              }
            });
  
          }
      });
  
  
  
  
  
       
  
  
     }
  
  
  
     $(function(){
         
         $('#date').change(function(){
  
          
          
          
          $.ajaxSetup({
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
            
           
            var date = $(this).val();
        
           
            $.ajax({
               url : '/dashboard/Facture/filter',
               data: {'date':date},
               type: 'get',
             //  contentType: "application/json; charset=utf-8",
               dataType: 'json',
               success: function(result)
               {
             
               fetch(result)
  
                
                   
                  
               },
               error: function()
              {
                  //handle errors
                  alert('error...');
              }
            });
            
         });
        
     });
  
  
  function fetch (result){
  
  
    $('tbody').html('')
  
                $.each(result.facs, function(key, item){
  
                  var dateString = moment(item.created_at).format('DD-MM-YYYY');
                
                  if(result.user == item.UserId || result.user == 'admin') 
                  {
  
                  
                 
                  $('tbody').append('\
                <tr>\
              <td>'+item.Fac_num+'</td>\
              <td>'+item.client.Name+'</td>\
              <td>'+item.Type+'</td>\
              <td>'+item.ModePay+'</td>\
              <td>'+item.Status+'</td>\
              <td>'+dateString+' </td>\
              <td>'+item.user.name+' </td>\
              <td>\
             <a href="/dashboard/Factures/'+item.id+'/details" class="btn btn-success text-white" role="button" ><i class="fas fa-plus-square"></i></a>\
                  <button onclick="deleteFacture('+item.id+')" id="btn'+item.id+'" class="btn btn-danger" ><i class="fas fa-trash"></i></button>\
         \
                </tr>')
  
              }
  
              else
              {
                $('tbody').append('\
                <tr>\
              <td>'+item.Fac_num+'</td>\
              <td>'+item.client.Name+'</td>\
              <td>'+item.Type+'</td>\
              <td>'+item.ModePay+'</td>\
              <td>'+item.Status+'</td>\
              <td>'+dateString+' </td>\
              <td>'+item.user.name+' </td>\
              <td>\
             <a href="/dashboard/Factures/'+item.id+'/details" class="btn btn-success text-white" role="button" ><i class="fas fa-plus-square"></i></a>\
         \
                </tr>')
  
  
  
              }
  
  
               })
  
  
  }
  
     
     
  
  $(function(){
         
         $('#Type , #TypeE').change(function(){
  
          
            var type = $(this).val();

            var pro = $('#typeP').val();
  
            if( type == "Normal")
            {
              $('.Mod').show()
              $('.bls').show()
              $('.new').hide()
            }
            else{
              $('.Mod').hide()
              $('.bls').hide()
              $('.new').show()

             

              
             
  
            }
        
            
         });


         $('#TypeP').change(function(){
  
          
            var type = $(this).val();

          console.log('fldslgs '+type);
  
            if( type == "new")
            {
             
              $('.bls').hide()
            }
            else{
            
              $('.bls').show()

             

              
             
  
            }
        
            
         });





        
     });
  
     
  
  $(function(){

   
         
         $('#ClientName').change(function(){
  
          $.ajaxSetup({
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
            
           
            var client = $("#ClientName").val();
            var type = $(this).val();

            console.log(type);
           
        
           
            $.ajax({
               url : '/dashboard/Facture/bls',
               data: {'Client':client,'Type':type},
               type: 'get',
              contentType: "application/json; charset=utf-8",
               dataType: 'json',
               success: function(result)
               {
               

                console.log(result.html);
                
  
                document.querySelector('#Bls').setOptions(result.html);
            


               
           
                  
               },
               error: function()
              {
                  //handle errors
                  alert('error...');
              }
            });
  
  
  
          
          
        
            
         });
        
     });


     
  
  
    </script>
  



<script>

$(document).ready(function(){

  
  VirtualSelect.init({ 
  ele: '#Bls' 
});

  $("#searchP").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  



});



</script>



</body>
</html>
 
