
@extends('layouts.dashboard')

@section('content')


<div class="m-3 ">

  <h4><a class="text-info" href="/dashboard">Dashborad</a> / Caisse Details </h4>


</div>
<div  class=" shadow p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">

<div class="row">

  <div class="col-md-4">
    <input type="text" name="search" class="form-control" id="searchP" placeholder="search" >
  </div>
 



</div>
    
 
  
       <table class="table table-striped table-hover text-center mt-2">
        <thead class="bg-dark text-white">
          <tr>
            
           <th>Num</th>
            <th>Client</th>
            <th>Amount</th>
            <th>Date</th>
            <th>User</th>
            <th>Options</th>
           
           
          </tr>
        </thead>
        <tbody>

            @foreach ( $Caisses as $Caisse)
            <tr>
              <td>{{$Caisse->id }}</td>

              <td>{{$client->Designation }}</td>
            
              <td>{{  number_format($Caisse->Amount,2,'.',',') }}</td>
              <td>{{ $Caisse->created_at->format('d-m-Y') }} </td>
              <td>{{ $Caisse->user->name }} </td>
              @if ($Caisse->user->id == $user)
  
              <td> 
                <a href="/dashboard/Caissedetails/{{ $Caisse->id }}/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print"></i></a>

                <button  data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-primary text-white" role="button" onclick="getOperation({{$Caisse->id}})"  ><i class="fas fa-edit"></i></button>
                <button onclick="deleteOperation({{$Caisse->id}})" id="btn{{$Caisse->id}}" class="btn btn-danger" ><i class="fas fa-trash"></i></button>
               </tr>
                  
              @else
  
              <td> 
                <a href="/dashboard/Caissedetails/{{ $Caisse->id }}/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print"></i></a>

                <button onclick="deleteOperation({{$Caisse->id}})" id="btn{{$Caisse->id}}" class="btn btn-danger" disabled ><i class="fas fa-trash"></i></button>
           
                   
               </tr>
                  
              @endif
              
           @endforeach
            </tr>

         
         
         
      
        </tbody>
       </table>

       <div class="pagination d-flex justify-content-center mt-4 ">
      
    
      </div>
      
       
   
      
      
       
       


</div>
<!-- Transorm Model  -->

<div id="edit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Edit Operation</h4>
         
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
      </div>
      <div class="modal-body">
    
         <p class="text-success successe text-center"></p>
         <p class="text-danger errore text-center"></p>


         <input type="hidden" id="id" name="id">

        

        <div class="form-group m-2 M" >
         <label for="priceE" class=" mb-2">Montant:</label>
         <input type="number"  id="priceE" class="form-control" step="1"  name="price" required>
     
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
        <button  class="btn btn-dark update">Edit </button>
        </div> 
      </div>
    </form>
    </div>

  </div>
</div>







        
  @endsection

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>

function deleteOperation(id)
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
             url : '/dashboard/Caissedetails/delete',
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
       
       $('.update').click(function(){
           $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
           
          
         
          var data = {
            'id': $('#id').val(),
           
            'Des': $('#DesE').val(),
            'Price': $('#priceE').val(),
            
           
          }
           
            
      
          $.ajax({
             url : '/dashboard/Caisse/update2',
             data: data,
             type: 'post',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {
              if(result.error)
               {
                 console.log(result.error);
                $('.errore').text(result.error)
                setTimeout(function() { $('.errore').text('');}, 2000);
               }
            
           else 
           {
            $('.successe').text('Operation Edited')
             

            fetch(result);
          
           
            
             setTimeout(function() { $('.successe').text('');
             $('#edit').modal('toggle');}, 1000);
            }



           
             },
             error: function()
            {
                //handle errors
                alert('error...');
            }
          });
       });
      
   });

   function getOperation(id){
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
             url : '/dashboard/Caisse/showD',
             data: data,
             type: 'get',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {

              console.log(result);
              
                $('#id').val(result.id)
                $('#DesE').val(result.Designation)
                $('#priceE').val(result.Amount);
              
               
              
            
              
             }
          
            ,
             error: function()
            {
                //handle errors
                alert('error...');
            }
          }); 
   }


   function fetch (result){


$('tbody').html('')

            $.each(result.caisses, function(key, item){

          
            
              var dateString = moment(item.created_at).format('DD-MM-YYYY');
              console.log(item.User_id);

            
              if(result.user == item.UserId)
              {

            $('tbody').append('\
            <tr>\
          <td>'+result.client.Designation+'</td>\
          <td>'+item.Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
          <td>'+dateString+' </td>\
          <td>'+item.user.name+' </td>\
          <td> <a href="/dashboard/Caissedetails/'+item.id+'/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print"></i></a>\
              <button  data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-primary text-white" role="button" onclick="getOperation('+item.id+')"  ><i class="fas fa-edit"></i></button>\
              <button onclick="deleteOperation('+item.id+')" id="btn'+item.id+'" class="btn btn-danger" ><i class="fas fa-trash"></i></button>\
\
            </tr>')
          }
          else{
            $('tbody').append('\
            <tr>\
          <td>'+result.client.Designation+'</td>\
          <td>'+item.Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
          <td>'+dateString+' </td>\
          <td>'+item.user.name+' </td>\
          <td> <a href="/dashboard/Caissedetails/'+item.id+'/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print"></i></a>\
              <button  data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-primary text-white" role="button" onclick="getOperation('+item.id+')" disabled ><i class="fas fa-edit"></i></button>\
              <button onclick="deleteOperation('+item.id+')" id="btn'+item.id+'" class="btn btn-danger" disabled ><i class="fas fa-trash" ></i></button>\
\
            </tr>')
          }

                      





           })


}



  </script>