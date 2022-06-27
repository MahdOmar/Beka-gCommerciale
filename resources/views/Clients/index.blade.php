
@extends('layouts.dashboard')

@section('content')
 

<div class="m-3 ">

  <h4><a class="text-info" href="/dashboard">Dashborad</a> / Clients </h4>


</div>
<div  class=" shadow p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">

<div class="row">

  <div class="col-md-4">
    <input type="text" name="search" class="form-control" id="searchP" placeholder="search" >
  </div>


 

<div class="col-md-8 d-flex justify-content-end">
 
 

  <div >
    <a  class="btn btn-dark btn-sm  p-2 text-white" role="button" data-bs-toggle="modal" data-bs-target="#myModal" ><i class="fas fa-plus-square m-1"></i>Add Client</a>

  </div>
      
</div>  

</div>
    
 
  
       <table class="table table-striped table-hover text-center mt-2">
        <thead class="bg-dark text-white">
          <tr>
            
           
            <th> Name</th>
            <th> Phone</th>
            <th>Address</th>
            <th>R C</th>
            <th>N I F</th>
            <th>A I </th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody id="tbody1">

            @foreach ( $clients as $client)
            <tr>
              <td>{{ $client->Name }}</td>
              <td>{{ $client->Phone }}</td>
              <td>{{ $client->Adress }}</td>
              <td>{{ $client->RC }} </td>
              <td>{{ $client->NIF }} </td>
              <td>{{ $client->AI }} </td>
              
              
  
              <td> <a href="" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#myModal2"  role="button" onclick="getClient({{$client->id}})"><i class="fas fa-edit"></i></a>
                
                    
                     <button onclick="deleteClient({{ $client->id }})" id="btn{{ $client->id }}" class='btn btn-danger' ><i class="fas fa-trash"></i></button>
           
                   
               </tr> 

               @endforeach

        
         
         
         
      
        </tbody>
       </table>

       <div class="pagination d-flex justify-content-center mt-4 ">
      {{ $clients->links('pagination::bootstrap-4') }}
    
      </div>

     
   
</div>

<div class="d-flex justify-content-center mb-5">
  <button class="btn btn-primary  " id='details'>Voir Etat Client</button>

</div>


<div  class=" shadow p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">



<div class="row sear" style="display: none">
  <div class="col-md-4">
    <input type="text" name="search" class=" form-control" id="searchP2" placeholder="search" >

  </div>
</div>


<table class="table table-striped table-hover text-center mt-2 etat" style="display: none">
  <thead class="bg-dark text-white">
    <tr>
      
     
      <th>Name</th>
      <th>Total Bls</th>
      <th>Paid</th>
      <th>Left</th>
      <th>Credit</th>
      <th>Option</th>
    </tr>
  </thead>
  <tbody id="tbody2">

    @foreach ( $Etats as $Etat)
    <tr>
      <td>{{ $Etat->Name }}</td>
      <td>{{ $Etat->bls }}</td>
      <td>{{  number_format($Etat->pay,2,'.',',') }}</td>
      
      @php
          $test = false;
      @endphp
      @foreach ($Bls as $Bl)
         @if ($Bl->ClientId == $Etat->id) 
         <td>{{  number_format($Bl->total - $Etat->pay,2,'.',',') }} </td>
         @php
         $test = true;
        @endphp

         @endif
      @endforeach

      @if (!$test)
      <td>{{  number_format(0,2,'.',',') }} </td>

      @endif

      @if (count($credits) == 0)
      <td>{{  number_format(0,2,'.',',') }} </td>

          
      @else

      @php
      $test2 = false;
     @endphp



      @foreach ($credits as $credit)
      @if ($credit->ClientId == $Etat->id) 
      <td>{{  number_format($credit->Amount,2,'.',',') }} </td>
      @php
      $test2 = true;
     @endphp
     

      @endif
   @endforeach
          
     

      @if (!$test2)
      <td>{{  number_format(0,2,'.',',') }} </td>

      @endif
      @endif
     


   
     
      

      <td> <a href="/dashboard/Clients/{{ $Etat->id }}/Etat_details" class="btn btn-success text-white"   role="button" >Details</a>
        
            
   
           
       </tr> 

       @endforeach


     
   
   
   

  </tbody>
 </table>
</div> 

 

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Add Client</h4>
         
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
      </div>
      <div class="modal-body">
    
         <p class="text-success success text-center"></p>
         <p class="text-danger error text-center"></p>

         <div class="form-group m-2">
          <label for="nameE" class="mb-2">Name:</label>
          <input type="text" class="form-control" name="name" id="ClientName" required>
         
         
         </div>

  <div class="form-group m-2">
          <label for="firstName" class="mb-2">Phone:</label>
          <input type="text"   class="form-control" id="ClientPhone" name="phone" pattern="[0-9]+" minlength="10" maxlength="10" required>
         
  </div>

  <div class="form-group m-2  ">
   
          <label for="adress" class="mb-2">Adress:</label>
          <input type="text" class="form-control" name="ClientAdress" id="ClientAdress"  required>
    
  </div>

  <div class="form-group m-2  ">
   
    <label for="adress" class="mb-2">R C:</label>
    <input type="text" class="form-control" name="ClientAdress" id="rc"  required>

</div>

<div class="form-group m-2  ">
   
    <label for="adress" class="mb-2">N I F:</label>
    <input type="text" class="form-control" name="ClientAdress" id="nif"  required>

</div>

<div class="form-group m-2  ">
   
    <label for="adress" class="mb-2">A I:</label>
    <input type="text" class="form-control" name="ClientAdress" id="ai"  required>

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
          <h4 class="modal-title">Update Client</h4>
         
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
      </div>
      <div class="modal-body">
    
         <p class="text-success successe text-center"></p>
         <p class="text-danger errore text-center"></p>

         <input type="hidden" id="id" name="id">
         <div class="form-group  m-2">
          <label for="nameE" class="mb-2">Name:</label>
          <input type="text" class="form-control" name="name" id="ClientNameE"  required>
         
         
  </div>

  <div class="form-group  m-2">
          <label for="firstName"  class="mb-2">Phone:</label>
          <input type="text"   class="form-control" id="ClientPhoneE" name="phone" pattern="[0-9]+" minlength="10" maxlength="10" required>
         
  </div>

  <div class="form-group   m-2 ">
   
          <label for="adress"  class="mb-2">Adress:</label>
          <input type="text" class="form-control" name="ClientAdress" id="ClientAdressE"  required>
    
  </div>

  <div class="form-group m-2  ">
   
    <label for="adress" class="mb-2">R C:</label>
    <input type="text" class="form-control" name="" id="rce"  required>

</div>

<div class="form-group m-2  ">
   
    <label for="adress" class="mb-2">N I F:</label>
    <input type="text" class="form-control" name="ClientAdress" id="nife"  required>

</div>

<div class="form-group m-2  ">
   
    <label for="adress" class="mb-2">A I:</label>
    <input type="text" class="form-control" name="ClientAdress" id="aie"  required>

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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

      if( $('#ClientName').val()  == '' ||   $('#ClientPhone').val() == '' || $('#ClientAdress').val() == '' 
              || $('#rc').val()  == '' || $('#nif').val()  == '' || $('#ai').val()  == '')
      {
       
        $('.error').text("All fields are required");
        
       
        setTimeout(function() { $('.error').text('');
        

            }, 3000);

      }
      else{

      
           

         
          var data = {
           
            'ClientName': $('#ClientName').val(),
            'ClientPhone': $('#ClientPhone').val(),
            'ClientAdress': $('#ClientAdress').val(),
            'rc': $('#rc').val(),
            'nif': $('#nif').val(),
            'ai': $('#ai').val()
           
          }
           
            
      
          $.ajax({
             url : '/dashboard/Clients',
             data: data,
             type: 'post',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {

            
            
          
             $('.success').text('Client Added')

             $('#date').val('All')

             

             fetch(result);
             fetch2();
       

            
             

             $('#ClientName').val('');
             $('#ClientPhone').val('');
             $('#ClientAdress').val('');
             $('#rc').val('');
             $('#nif').val('');
             $('#ai').val('');

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

   function getClient(id){

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
             url : '/dashboard/Client/show',
             data: data,
             type: 'get',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {
              $.each(result, function(key, item){
                $('#id').val(item.id)

                $('#ClientNameE').val(item.Name);
                $('#ClientPhoneE').val(item.Phone);
                 $('#ClientAdressE').val(item.Adress);
                 $('#rce').val(item.RC);
                 $('#nife').val(item.NIF);
                 $('#aie').val(item.AI);



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
   if( $('#ClientNameE').val()  == '' ||   $('#ClientPhoneE').val() == '' || $('#ClientAdressE').val() == ''
         || $('#rce').val()  == '' || $('#nife').val()  == '' || $('#aie').val()  == '' )
      {
       
        $('.errore').text("All fields are required");
        
       
        setTimeout(function() { $('.errore').text('');
        

            }, 3000);

      }
      else{
          
         
          var data = {
            'id': $('#id').val(),
           
            'ClientName': $('#ClientNameE').val(),
            'ClientPhone': $('#ClientPhoneE').val(),
            'ClientAdress': $('#ClientAdressE').val(),
            'rc': $('#rce').val(),
            'nif': $('#nife').val(),
            'ai': $('#aie').val()
           
          }
           
            
      
          $.ajax({
             url : '/dashboard/Client/update',
             data: data,
             type: 'post',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {
            
             
          
            $('.successe').text('Client Updated')
         
       

            
            fetch(result)
            fetch2()


             $('#ClientNameE').val(''),
             $('#ClientPhoneE').val(''),
             $('#ClientAdressE').val(''),
             $('#rce').val(''),
             $('#nife').val(''),
             $('#aie').val('')
            
             setTimeout(function() { $('.successe').text('');
             $('#myModal2').modal('toggle');
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

   function deleteClient(id)

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
             url : '/dashboard/Client/delete',
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
              else
              {
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



  


function fetch (result){


  $('#tbody1').html('')

              $.each(result, function(key, item){

             
              
                
               
                $('#tbody1').append('\
              <tr>\
            <td>'+item.Name+'</td>\
            <td>'+item.Phone+'</td>\
            <td>'+item.Adress+'</td>\
            <td>'+item.RC+'</td>\
            <td>'+item.NIF+'</td>\
            <td>'+item.AI+'</td>\
            <td> <button  class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#myModal2"   onclick="getClient('+item.id+')"><i class="fas fa-edit"></i></button>\
                <button onclick="deleteClient('+item.id+')" id="btn'+item.id+'" class="btn btn-danger" ><i class="fas fa-trash"></i></button>\
       \
              </tr>')

            

           


             })


}

function fetch2 (){


$('#tbody2').html('')

  $('#tbody2').append('\
  <tr>\
    <td colspan="6"> <a href="/dashboard/Clients" class="btn btn-success text-white" role="button" >Refresh</a> </td>\
    </tr>')

}


$(function(){
       
       $('#details').click(function(){

        $(".etat").toggle();
        $(".sear").toggle();
        window.scrollTo(0, document.body.scrollHeight);
                return false
        
        

         
      
          
       });


      
   });
   
   



  </script>