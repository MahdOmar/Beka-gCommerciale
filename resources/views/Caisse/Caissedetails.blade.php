
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
 



</div>
    
 
  
       <table class="table table-striped table-hover text-center mt-2">
        <thead class="bg-dark text-white">
          <tr>
            
           
            <th>BL</th>
            <th>Amount</th>
            <th>Date</th>
            <th>User</th>
            <th>Options</th>
           
           
          </tr>
        </thead>
        <tbody>

            @foreach ( $Caisses as $Caisse)
            <tr>
              <td>Bon N°{{ $Caisse->Bl_id }}</td>
              <td>{{  number_format($Caisse->Amount,2,'.',',') }}</td>
              <td>{{ $Caisse->created_at->format('d-m-Y') }} </td>
              <td>{{ $Caisse->user->name }} </td>
              @if ($Caisse->user->id == $user)
  
              <td> 
                <a href="/dashboard/Caissedetails/{{ $Caisse->id }}/print" class="btn btn-success text-white" role="button" ><i class="fas fa-plus-square"></i></a>

               
                <button onclick="deleteOperation({{$Caisse->id}})" id="btn{{$Caisse->id}}" class="btn btn-danger" ><i class="fas fa-trash"></i></button>
               </tr>
                  
              @else
  
              <td> 
                <a href="/dashboard/Caissedetails/{{ $Caisse->id }}/print" class="btn btn-success text-white" role="button" ><i class="fas fa-plus-square"></i></a>

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



  </script>