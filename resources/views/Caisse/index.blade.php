@extends('layouts.dashboard')

@section('content')

<div class="m-3">

  <h4><a class="text-info" href="/dashboard/stats">Dashborad</a> / Caisse </h4>


</div>



<div  class="shadow  p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">

  
  
  <div class="row">
  <div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="mt-2">Ajouter Opération</h5>
            
        </div>
        <div class="card-body">

          <p class="text-success success text-center"></p>
           <p class="text-danger error text-center"></p>
            <div class="form-group m-2">
                <label for="nameE" class="mb-2">Opération:</label>
                <select name="nameE" id="Type" class="form-control form-select">
                  <option value="" disabled selected>Selectionner Type d'Opération</option>
                  <option value="Encaissement de Bl" >Encaissement Bl</option>
                  <option value="Encaissement de Facture" >Encaissement de Facture</option>
                  <option value="Autre Encaissement" >Autre Encaissement</option>
                  <option value="Reglement de depenses" >Règlement de dépenses</option>

                
               
             </select>    
                
               
               
            </div> 

            <div class="form-group m-2 regl" style="display: none">
              <label for="nameE" class="mb-2">Type:</label>
              <select name="nameE" id="Treg" class="form-control form-select">
                <option value="" disabled selected>Selectionner Type de Règlement</option>
                <option value="Client" >Remboursement Client</option>
                <option value="Autre" >Autre</option>
              
             
           </select>    
              
             
             
          </div> 






            <div class="form-group m-2 clients" style="display: none">
              <label for="nameE" class="mb-2">Client:</label>
              <select name="nameE" id="ClientName" class="form-control form-select">
                <option value="" disabled selected>Selectionner Client</option>
              @foreach ($clients as $client)
              <option value="{{ $client->id }}">{{ $client->Name }}</option>
                  
              @endforeach
             
           </select>    
              
             
             
             </div>

            <div class="form-group m-2 F" style="display: none;">
                <label for="nameE" class="mb-2">Facture:</label>
                <select name="nameE" id="Facture" placeholder="Native Select" data-search="false" data-silent-initial-value-set="true"  class="form-control  " multiple>
               
               
             </select>     
                
               
               
               </div> 
      

            <div class="form-group m-2 D" style="display: none" >
                <label for="Des" class=" mb-2">Designation:</label>
                <input type="text" id="Des" class="form-control" name="Des"   required>
               
               
           </div>

           <div class="form-group m-2 M" >
            <label for="price" class=" mb-2">Montant:</label>
            <input type="number"  id="price" class="form-control" step="1"  name="price" required>
           
          </div>

         

       
       
        </div>
    </div>
    <div class="d-flex justify-content-end">
      <button class="btn btn-primary submit m-2">Valider</button>

    </div>
  
  </div>

  <div class="col-md-6">

    <div class="card">
        <div class="card-header">
            <h5 class="mt-2">la Caisse</h5>

           
            
        </div>
        <div class="card-body">

          <div class="d-flex justify-content-center m-3">
          <img src="/img/caisse.png" width="150" height="150" alt="">
        </div>

        @php
        $total = 0 ;
           foreach($caisse as $cais)
            {
              if($cais->Operation == "Encaissement de Facture" || $cais->Operation == "Encaissement de Bl"
              ||$cais->Operation == "Autre Encaissement" )
              {
                $total = $total + $cais->Amount;

              }

              else {
                $total = $total - $cais->Amount;
              }

            }
         

          
           
        @endphp

          <h4 class="text-center" id="total">Total: {{ number_format($total,2,'.',',')  }}  Da</h4>
        </div>
    </div>
  
</div>



</div>
    
 
  

</div>

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

         <div class="form-group m-2 D" >
          <label for="DesE" class=" mb-2">Designation:</label>
          <input type="text" id="DesE" class="form-control" name="Des"   >
         
         
         </div>

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

<div class="d-flex justify-content-center mb-5">
  <button class="btn btn-dark  " id='details'>Voir détails</button>

</div>


<div  class="shadow p-3 mb-5 bg-white rounded" id="dtable"  style=" margin-left:10px;margin-right:10px;display:none">


  



  <div class="row">

    <div class="col-md-4 ">
      <input type="text" name="search" class="form-control" id="searchP" placeholder="search" >
    </div>

   
    
  
  
   
  
 
  
  </div>
      
   
    
         <table class="table table-striped table-hover text-center mt-2 " >
          <thead class="bg-dark text-white">
            <tr>
              
              <th>Num</th>
              <th>Operation</th>
              <th>Designation</th>
              <th>Montant</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($caisse as $item)
            <tr>
              <td>{{ $item->id }}</td>
              <td>{{ $item->Operation }}</td>
            @if ( $item->Operation == "Encaissement de Facture" || $item->Operation == "Encaissement de Bl" )
            <td>{{$item->Designation}}</td>
            @else
            <td>{{$item->Designation}}</td>
            @endif
             
              <td>{{ number_format($item->Amount ,2,'.',',') }} </td>

              @if ( $item->Operation == "Encaissement de Facture" || $item->Operation == "Encaissement de Bl" )
              <td> <a href="/dashboard/Caisse/{{$item->id}}/details" class="btn btn-success text-white"   role="button" >Details</a>

                  
              @else
              @if ($user == $item->user->id)
              <td>  <button  data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-primary text-white" role="button" onclick="getOperation({{$item->id}})"  ><i class="fas fa-edit"></i></button>
                @if (str_contains($item->Designation,'Remboursement Client'))
                <a href="/dashboard/Caisse/{{ $item->id }}/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print  "></i></a>
  
                @endif
                <button onclick="deleteOperation({{$item->id}})" id="btn{{$item->id}}" class="btn btn-danger" ><i class="fas fa-trash"></i></button>
              
                  
              @else
              @if (str_contains($item->Designation,'Remboursement Client'))
             <td> <a href="/dashboard/Caisse/{{ $item->id }}/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print"></i></a>
             </td>
              @endif
                  
              @endif
              
            
              
            

              
                  
              @endif
             

              

          </tr>
                
            @endforeach

          </tbody>
        </table>
        <div class="pagination d-flex justify-content-center mt-4 ">
      
          {{ $caisse->links('pagination::bootstrap-4') }}
  
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

         if( ($('.D').is(":visible") && $('#Des').val() == '' &&$('#Treg').val() != "Client" ) || $('#price').val() == '' )
         {

            $('.error').text("All fields are required");

              setTimeout(function() { $('.error').text('');
                }, 3000);


         }

         else if(  $('#price').val() < 0)
           {
             $('.error').text("Amount can not be 0 or negative");

              setTimeout(function() { $('.error').text('');
                }, 3000);

           }

           else

          {

         
          var data = {
           
            'Type': $('#Type').val(),
            'Treg':$('#Treg').val(),
            'Des': $('#Des').val(),
            'Price': $('#price').val(),
            'Client': $('#ClientName').val(),
            'Bls': $('#Facture').val(),
            'Price': $('#price').val()
          
           
          }
           
            
      
          $.ajax({
             url : '/dashboard/Caisse/depense',
             data: data,
             type: 'post',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {
              console.log('******'+result.Error);
              if(result.Error)
               {
               
                $('.error').text(result.Error)
                setTimeout(function() { $('.error').text('');}, 2000);
               }
            
           else 
           {
           
            $('.success').text('Operation Added');
             fetch(result)


          
           
            $('#Des').val('');
            $('#price').val('');

           
            setTimeout(function() { $('.success').text('');}, 1000);
       
            
            
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
             url : '/dashboard/Caisse/show',
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
             url : '/dashboard/Caisse/update',
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
             url : '/dashboard/Caisse/delete',
             data:{'id':id},
             type: 'delete',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {
            
            fetch(result);
          
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
             url : '/dashboard/Caisse/filter',
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


   
$(function(){
       
       $('#Type , #TypeE').change(function(){

        
          var type = $(this).val();

          if( type == "Encaissement de Facture")
          {
            $('.F').show();
            $('.clients').show();
            $('.regl').hide();
            $('.D').hide() ;
            
          }
          else if(type == "Encaissement de Bl"){
            $('.F').hide();
            $('.clients').show();
            $('.D').hide();
            $('.regl').hide();


          }

          else if(type == "Autre Encaissement"){
            $('.F').hide();
            $('.clients').hide();
            $('.D').show();
            $('.regl').hide();

          }


          else{
            $('.F').hide();
            $('.clients').show();
            $('.D').show();
            $('.regl').show();

          }
      
          
       });
      
   });

   function fetch (result){


$('tbody').html('')

            $.each(result.caisses, function(key, item){

            

            if(item.Operation == "Reglement de depenses" )

            { 

              if(item.Designation.includes("Remboursement")) 
              {
                if(result.user == item.UserId){

                  $('tbody').append('\
            <tr>\
              <td>'+item.id+'</td>\
          <td>'+item.Operation+'</td>\
          <td>'+item.Designation+'</td>\
          <td>'+item.Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
          <td>  <button  data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-primary text-white" role="button" onclick="getOperation('+item.id+')"  ><i class="fas fa-edit"></i></button>\
            <a href="/dashboard/Caisse/'+item.id+'/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print  "></i></a>\
            <button onclick="deleteOperation('+item.id+')" id="btn'+item.id+'" class="btn btn-danger"  ><i class="fas fa-trash"></i></button>\
     \
            </tr>')




                }
                else{

               
                
                $('tbody').append('\
            <tr>\
              <td>'+item.id+'</td>\
          <td>'+item.Operation+'</td>\
          <td>'+item.Designation+'</td>\
          <td>'+item.Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
            <td><a href="/dashboard/Caisse/'+item.id+'/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print  "></i></a></td>\
     \
            </tr>')

              }
            }
         else{

          if(result.user == item.UserId){
          
        

              $('tbody').append('\
            <tr>\
              <td>'+item.id+'</td>\
          <td>'+item.Operation+'</td>\
          <td>'+item.Designation+'</td>\
          <td>'+item.Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
          <td>  <button  data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-primary text-white" role="button" onclick="getOperation('+item.id+')"  ><i class="fas fa-edit"></i></button>\
            <button onclick="deleteOperation('+item.id+')" id="btn'+item.id+'" class="btn btn-danger" ><i class="fas fa-trash"></i></button></td>\
     \
            </tr>')
          }
          else{

            $('tbody').append('\
            <tr>\
              <td>'+item.id+'</td>\
          <td>'+item.Operation+'</td>\
          <td>'+item.Designation+'</td>\
          <td>'+item.Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
     \
            </tr>')


          }

          }
            }
            

           else if(item.Operation == "Autre Encaissement" )
           {
             if(result.user == item.UserId){
          
        

              $('tbody').append('\
            <tr>\
              <td>'+item.id+'</td>\
          <td>'+item.Operation+'</td>\
          <td>'+item.Designation+'</td>\
          <td>'+item.Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
          <td>  <button  data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-primary text-white" role="button" onclick="getOperation('+item.id+')"  ><i class="fas fa-edit"></i></button>\
            <button onclick="deleteOperation('+item.id+')" id="btn'+item.id+'" class="btn btn-danger" ><i class="fas fa-trash"></i></button></td>\
     \
            </tr>')
          }
          else{

            $('tbody').append('\
            <tr>\
              <td>'+item.id+'</td>\
          <td>'+item.Operation+'</td>\
          <td>'+item.Designation+'</td>\
          <td>'+item.Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
     \
            </tr>')


          }





           }


            else
            {
            $('tbody').append('\
            <tr>\
              <td>'+item.id+'</td>\
          <td>'+item.Operation+'</td>\
          <td>'+item.Designation+'</td>\
          <td>'+item.Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
          <td> <a href="/dashboard/Caisse/'+item.id+'/details" class="btn btn-success text-white"   role="button" >Details</a>\
            </tr>')

                      }





          total = 0;
          
             $.each(result.caisses, function(key, item){

              if( item.Operation == "Encaissement de Facture" || item.Operation == "Encaissement de Bl"
                || item.Operation == "Autre Encaissement" )
              {

                total = total + item.Amount;

              }
              else{ 
                total = total - item.Amount;
              }
              

             })
           
           


            



             $("#total").text('Total: '+total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' Da' )

          

    


           })


}


$(function(){
       
       $('#details').click(function(){

        $("#dtable").toggle();
        window.scrollTo(0, document.body.scrollHeight);
                return false
        
        

         
      
          
       });


       $('#Treg').change(function(){
        $.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

        var type = $(this).val();

if( type == "Client")
{
  
  $('.clients').show();
  $('.D').hide();
  $.ajax({
      url : '/dashboard/Caisse/clients',
      data: {'Client':type},
      type: 'get',
     contentType: "application/json; charset=utf-8",
      dataType: 'json',
      success: function(result)
      {
      

       
       

      $("#ClientName").html(result.html); 
      



      
  
         
      },
      error: function()
     {
         //handle errors
         alert('error...');
     }
   });


  
}
else{
  $('.clients').hide();
  $('.D').show();

  


}




      



 

  
});
      
   });
  

   $(function(){

    $(document).ready(function(){

  
VirtualSelect.init({ 
ele: '#Facture' 
});

});
         
$('#ClientName').change(function(){

 $.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
   
  
   var client = $(this).val();
  

  
   $.ajax({
      url : '/dashboard/Caisse/bls',
      data: {'Client':client},
      type: 'get',
     contentType: "application/json; charset=utf-8",
      dataType: 'json',
      success: function(result)
      {
      

       console.log(result.html);
       

       document.querySelector('#Facture').setOptions(result.html);
   


      
  
         
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
  