
@extends('layouts.dashboard')

@section('content')


<div class="m-3 ">

  <h4><a class="text-info" href="/dashboard">Dashborad</a> / Bls </h4>


</div>
<div  class=" shadow p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">

<div class="row">

  <div class="col-md-4">
    <input type="text" name="search" class="form-control" id="searchP" placeholder="search" >
  </div>
  <div class="col-md-4 col-lg-4 d-flex " style="width:350px">
   

</div>


 

<div class="col-md-4 col-xl-4 d-flex justify-content-end">
 
 

  <div >
    @if($role == "commercial" || $role == "admin")
    <a  class="btn btn-dark btn-sm  p-2 text-white" role="button" data-bs-toggle="modal" data-bs-target="#myModal" ><i class="fas fa-plus-square m-1"></i>Add Bl</a>
     @endif
  </div>
      
</div>  

</div>
    
 
  
       <table class="table table-striped table-hover text-center mt-2">
        <thead class="bg-dark text-white">
          <tr>
            
            <th>Bl</th>
            <th>Client Name</th>
            <th>N° BC</th>
            <th>Statut</th>
            <th>Date</th>
            <th>User</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>

          @foreach ( $bls as $bl)
          @php
              $total =0 ;
              $expNum = explode('/', $bl->Bl_num);
          @endphp
          <tr>
            <td>Bl N°{{ $expNum[0] }}/{{  str_pad($expNum[1], 3, '0', STR_PAD_LEFT) }} </td>
            <td>{{ $bl->client->Name }}</td>
            <td>{{ $bl->BC }}</td>

            <td>{{ $bl->Status }}</td>

            <td>{{ $bl->created_at->format('d-m-Y') }} </td>
            <td>{{ $bl->user->name }} </td>
            @if ($bl->user->id == $user || Auth::user()->role == "admin")

            <td>
              <a href="/dashboard/BL/{{ $bl->id }}/details" class="btn btn-success text-white" role="button" ><i class="fas fa-plus-square"></i></a>
              

                   <button onclick="deleteBl({{ $bl->id }})" id="btn{{ $bl->id }}" class='btn btn-danger' ><i class="fas fa-trash"></i></button>
         
                 
             </tr>
                
            @else

            <td>
              <a href="/dashboard/BL/{{ $bl->id }}/details" class="btn btn-success text-white" role="button" ><i class="fas fa-plus-square"></i></a>
           <!--   <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#trans"  disabled><i class="fa-solid fa-rotate"></i></button>
           -->
                  
         
                 
             </tr>
                
            @endif
           
              
          @endforeach
         
         
         
      
        </tbody>
       </table>

       
      
       
   
      
      
       
       


</div>
<!-- Transorm Model  -->

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Add Bl</h4>
         
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
      </div>
      <div class="modal-body">
    
         <p class="text-success success text-center"></p>
         <p class="text-danger error text-center"></p>

         <div class="form-group m-2">
          <label for="nameE" class="mb-2">Client:</label>
          <select name="nameE" id="ClientName" class="form-control form-select ">
            <option value="" disabled selected>Selectionner Client</option>
          @foreach ($clients as $client)
          <option value="{{ $client->id }}">{{ $client->Name }}</option>
              
          @endforeach
         
       </select>    
          
         </div>

         <div class="form-group m-2">
          <label for="bc" class="mb-2">N° BC:</label>
          <input type="text" id="Bc" class="form-control" name="bc"   required>

          
         </div>




         <div class="form-group m-2">
          <label for="bl_f" class="mb-2">Facturation:</label>
          <select name="nameE" id="bl_f" class="form-control form-select">
            <option value="" disabled selected>Selectionner Oui/Non </option>
            <option value="Oui">Oui</option>
            <option value="Non" >Non</option>

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
          <h4 class="modal-title">Update Bl</h4>
         
        <button type="button"class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
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


<div id="Errors" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Error</h4>
         
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
      </div>
      <div class="modal-body">
    
        <p class="text-danger text-center Eror"></p>
         
  
      </div>
     
   
    </div>

  </div>
</div>




        
  @endsection
  
  <script src="{{ asset('js/jquery.min.js') }}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>

$(function(){
       
       $('.submit').click(function(){
           $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

   console.log( $('#ClientName').val());

      if( $('#ClientName').val()  == null || $('#Bc').val()  == null    ||$('#bl_f').val() == null)
      {
       
        $('.error').text("All fiels are required");
        
       
        setTimeout(function() { $('.error').text('');
        

            }, 3000);

      }
      else{

      
           

         
          var data = {
            'date' : $('#date').val(),
            'ClientName': $('#ClientName').val(),
            'BC': $('#Bc').val(),
            'Factured': $('#bl_f').val(),
          
           
          }
           
            
      
          $.ajax({
             url : '/dashboard/BL',
             data: data,
             type: 'post',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {

            
            
          
             $('.success').text('Bl Added')

             $('#date').val('All')

             

             fetch(result);
       

            
             

             $('#ClientName').val(''),
           

             setTimeout(function() { $('.success').text('');
             $('#myModal').modal('toggle');
            }, 1000);
            
             
            

            /*    */
             

             },
             error: function()
            {
                
             
            }
          });
        }
       });
      
      
   });


   $(function(){
       
       $('.transform').click(function(){

        console.log( $('#idBl').val());
           $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

   

      if( $('#FacType').val()  == null)
      {
       
        $('.success').text("Selectionner Type ");
        
       
        setTimeout(function() { $('.success').text('');
        

            }, 3000);

      }
      else{

      
           

         
          var data = {
            'id':  $('#idBl').val(),
          
            'Type': $('#FacType').val(),
          
           
          }
           
            
      
          $.ajax({
             url : '/dashboard/Bl/transform',
             data: data,
             type: 'post',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {

             $('.success').text('Bl Transformed');

            
             $('#FacType').val('');
           

             setTimeout(function() { $('.success').text('');
             $('#trans').modal('toggle');
            }, 1000);
            
             
            

            /*    */
             

             },
             error: function()
            {
                
             
            }
          });
        }
       });
      
      
   });

   function setId(id){

    console.log(id);
    $('#idBl').val(id);

   }

   function getBl(id){

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
             url : '/dashboard/Bl/show',
             data: data,
             type: 'get',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {
              $.each(result, function(key, item){
                $('#id').val(item.id)

                $('#ClientNameE').val(item.client.id);
                



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
  
          
         
          var data = {
            'id': $('#id').val(),
           
            'ClientName': $('#ClientNameE').val(),
         
           
          }
           
            
      
          $.ajax({
             url : '/dashboard/BL/update',
             data: data,
             type: 'post',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {
            
             
          
            $('.successe').text('Bl Updated')
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
        
       });
      
   });

   function deleteBl(id)

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
             url : '/dashboard/Bl/delete',
             data:{'id':id},
             type: 'delete',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {

              if(result.error)
              {
                $('.Eror').text(result.error);
                $('#Errors').modal('toggle');


                setTimeout(function() { $('.Eror').text('');
             $('#Errors').modal('toggle');
             }, 3000);

              }
              else{
                $("#btn"+id).closest("tr").remove();


              }
            
          

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
             url : '/dashboard/Bl/filter',
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

    
          
    


    $.each(result.bls, function(key, item){
     

      
            

                var dateString = moment(item.created_at).format('DD-MM-YYYY');
              
                if(result.user == item.User_id || result.role == 'admin')
                {

                
               
                $('tbody').append('\
              <tr>\
            <td>Bl N°'+item.Bl_num+'</td>\
            <td>'+item.client.Name+'</td>\
            <td>'+item.BC+'</td>\
            <td>'+item.Status+'</td>\
            <td>'+dateString+' </td>\
            <td>'+item.user.name+' </td>\
            <td> \
           <a href="/dashboard/BL/'+item.id+'/details" class="btn btn-success text-white" role="button" ><i class="fas fa-plus-square"></i></a>\
                <button onclick="deleteBl('+item.id+')" id="btn'+item.id+'" class="btn btn-danger" ><i class="fas fa-trash"></i></button>\
       \
              </tr>')

            }

            else
            {
              $('tbody').append('\
              <tr>\
            <td>'+item.id+'</td>\
            <td>'+item.client.Name+'</td>\
            <td>'+item.BC+'</td>\
            <td>'+item.Status+'</td>\
            <td>'+dateString+' </td>\
            <td>'+item.user.name+' </td>\
            <td> \
           <a href="/dashboard/BL/'+item.id+'/details" class="btn btn-success text-white" role="button" ><i class="fas fa-plus-square"></i></a>\
       \
              </tr>')



            }


             })

             


}

   
   



  </script>