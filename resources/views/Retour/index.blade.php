@extends('layouts.dashboard')

@section('content')

<div class="m-3">

  <h4><a class="text-info" href="/dashboard/stats">Dashborad</a> / Bl / Retour </h4>


</div>



<div  class="shadow  p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">

  <div>
    <h4>Bl N°{{ $bl->Bl_num }} de {{ $bl->client->Name }}</h4>
  </div>
  
  <div class="row">
  <div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mt-2">Retour</h5>
            
        </div>
        <div class="card-body">

          <p class="text-success success fw-bold text-center"></p>
           <p class="text-danger error fw-bold text-center"></p>

           <input type="number" name="" id="id" value="{{ request()->route('id') }}" style="display: none">

           <div class="form-group m-2 M" >
            <label for="Des" class=" mb-2">Designation:</label>
            <input type="text"  id="Des" class="form-control"   name="Des" required>
           
          </div>

           

           <div class="form-group m-2 M" >
            <label for="price" class=" mb-2">Montant:</label>
            <input type="number"  id="amountt" class="form-control" step="1"  name="price" required>
           
          </div>

         

       
       
        </div>
    </div>
    <div class="d-flex justify-content-end">
      <button class="btn btn-primary submit m-2">Valider</button>

    </div>
  
  </div>

  <div class="col-md-8">

    <table class="table table-striped table-hover text-center mt-2">
      <thead class="bg-dark text-white">
        <tr>
          <th>Designation</th>
          <th>Montant</th>
          <th>Date</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>

        @foreach ( $retours as $retour)
       
            <tr>
              <td>{{$retour->client->Name }}</td>

            
              <td>{{  number_format($retour->Amount,2,'.',',') }}</td>
              <td>{{ $retour->created_at->format('d-m-Y') }} </td>
              @if ($retour->user->id == $user)
  
              <td> 

                <button onclick="deleteOperation({{$retour->id}})" id="btn{{$retour->id}}" class="btn btn-danger" ><i class="fas fa-trash"></i></button>
               </tr>
                  
              @else
  
              <td> 
               
               </tr>
                  
              @endif
              
           @endforeach
            </tr>

       
    
      </tbody>
     </table>


  </div>





</div>
    
 
  

</div>

















        
  @endsection

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>

$(function(){
 
         
$('#ClientName').change(function(){
 $.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
   
  
   var client = $(this).val();
  
  
   $.ajax({
      url : '/dashboard/Bank/retour',
      data: {'Client':client},
      type: 'get',
     contentType: "application/json; charset=utf-8",
      dataType: 'json',
      success: function(result)
      {
      
       console.log(result.html);
       
       $('#Bl').html(result.html);
   
      
  
         
      },
      error: function()
     {
         //handle errors
         alert('error...');
     }
   });
 
 
   
});
});


/*************************////////////////////////
$(function(){
       
       $('.submit').click(function(){
           $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
         if($("#Des").val() == ""  ||  $('#amountt').val() == "" )
         {
            $('.error').text("All fields are required");
              setTimeout(function() { $('.error').text('');
                }, 3000);
         }
         else if(  $('#price').val() <= 0)
           {
             $('.error').text("Amount can not be 0 or negative");
              setTimeout(function() { $('.error').text('');
                }, 3000);
           }
           else
          {
         
          var data = {
           
           
            'id':$('#id').val(),
            'Des': $('#Des').val(),
            'Amount': $('#amountt').val(),
           
          
           
          }
           
            
      
          $.ajax({
             url : '/dashboard/Retour/create',
             data: data,
             type: 'post',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {
              if(result.error)
               {
               
                $('.error').text( result.error)
                setTimeout(function() { $('.error').text('');}, 3000);
               }
            
           else 
           {
           
            fetch(result)
            setTimeout(function() { $('.success').text('');}, 2000);
               
            
            
           }
            
          
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


   function fetch (result){

if(result.error)
{
  $('.error').text(result.error);
  window.scrollTo({ top: 0, behavior: 'smooth' });
  return ;
}


$('tbody').html('')

        $('.success').text("Operation Added");
       
        $.each(result.retours, function(key, item){
        
        
          var dateString = moment(item.created_at).format('DD-MM-YYYY');

    
          if(result.user == item.UserId)
            {

        $('tbody').append('\
        <tr>\
      <td>'+item.Designation+'</td>\
      <td>'+item.Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
      <td>'+dateString+'</td>\
      <td>                <button onclick="deleteOperation('+item.id+')" id="btn'+item.id+'" class="btn btn-danger" ><i class="fas fa-trash"></i></button>\
      \
           </td>\    </tr>')

          }

          else{
            $('tbody').append('\
            <tr>\
      <td>'+item.Designation+'</td>\
      <td>'+item.Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
      <td>'+dateString+'</td>\
      <td>             \
           </td>\    </tr>')

          }



              
      
        
       }) 
      
      

}

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
             url : '/dashboard/Retour/delete',
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