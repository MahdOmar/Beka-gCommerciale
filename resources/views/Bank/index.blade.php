@extends('layouts.dashboard')

@section('content')

<div class="m-3">

  <h4><a class="text-info" href="/dashboard/stats">Dashborad</a> / Banque </h4>


</div>



<div  class="shadow  p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">

  
  
  <div class="row">
  <div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="mt-2">Ajouter Opération</h5>
            
        </div>
        <div class="card-body">

          <p class="text-success success fw-bold text-center"></p>
           <p class="text-danger error fw-bold text-center"></p>
           

           






            <div class="form-group m-2 clients" >
              <label for="nameE" class="mb-2">Client:</label>
              <select name="nameE" id="ClientName" class="form-control form-select">
                <option value="" disabled selected>Selectionner Client</option>
              @foreach ($clients as $client)
              <option value="{{ $client->id }}">{{ $client->Name }}</option>
                  
              @endforeach
             
           </select>    
              
             
             
             </div>

            <div class="form-group m-2 F" >
                <label for="nameE" class="mb-2">Facture:</label>
                <select name="nameE" id="Facture" placeholder="Native Select" data-search="false" data-silent-initial-value-set="true"  class="form-control  " multiple>
               
               
             </select>    
                
               
               
               </div>

               <div class="form-group m-2 ">
                <label for="">Mode de paiement:</label>
               <select name="nameE" id="Mode" class="form-control form-select">
                <option value="" disabled selected> Selectionner Mode de paiement</option>
            
              <option value="Versement à la banque"> Versement à la banque</option>
              <option value="Virement bancaire"> Virement bancaire</option>
              <option value="Chèque bancaire">Chèque bancaire</option>


                  
             
             
           </select> 
           
        </div>
      

            <div class="form-group m-2 cheq"  >
                <label for="cheque" class=" mb-2">Numéro d'opétation:</label>
                <input type="text" id="cheque" class="form-control" name="Des"   required>
               
               
           </div>

           <div class="form-group m-2 Date" >
            <label for="Date_enc" class=" mb-2">Date:</label>
            <input type="date" id="Date_enc" class="form-control" name="Des"   required>
           
           
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
            <h5 class="mt-2">la Banque</h5>

           
            
        </div>
        <div class="card-body">

          <div class="d-flex justify-content-center m-3">
          <img src="/img/bank.png" width="150" height="150" alt="">
        </div>

          <h4 class="text-center" id="total">Total: {{ number_format($total ,2,'.',',') }}   Da</h4>
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
          <label for="DesE" class=" mb-2">Numéro de Chèque:</label>
          <input type="text" id="DesE" class="form-control" name="Des"   required>
         
         
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
              
            
              <th>Client</th>
              <th>Mode de Payment</th>
              <th>Total Amount</th>
              <th>Facture</th>
              <th>Facture Amount</th>
              <th>Date_enc</th>
              <th>Date</th>

              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($banks as $bank)
            <tr>
            <td>{{ $bank->client->Name }}</td>
            <td>{{ $bank->Mode }}</td>
            <td>{{ number_format($bank->Total_Amount ,2,'.',',') }}</td>
            <td>{{ $bank->Fact_num }}</td>
            <td>{{ number_format($bank->Fact_Amount ,2,'.',',') }}</td>
            @if ($bank->Date_Enc > date("Y-m-d"))
            <td class="text-danger">{{ $bank->Date_Enc }} </td>

            @else
            <td>{{ $bank->Date_Enc }} </td>

            @endif
            <td>{{ $bank->created_at->format('d-m-Y') }} </td>
            @if ($bank->UserId == $user || Auth::user()->role == "admin")
            <td>
              <a href="/dashboard/Bank/{{ $bank->id }}/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print"></i></a>

              
            
                   <button onclick="deleteOperation({{$bank->id}})" id="btn{{ $bank->id }}" class='btn btn-danger' ><i class="fas fa-trash"></i></button>
         
            </td>
                
            @else
            <td>
              <a href="/dashboard/Bank/{{ $bank->id }}/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print"></i></a>

              
            </td>
                
            @endif
           
          </tr>


                
            @endforeach

        

          </tbody>
        </table>
        <div class="pagination d-flex justify-content-center mt-4 ">
      
          {{-- {{ $caisse->links('pagination::bootstrap-4') }} --}}
  
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
         if($("#ClientName").val() == "" || $('#Facture').val() ==  "" || $('#Mode').val() == "" ||  $('#cheque').val() == "" || $("#Date_enc").val()=="" || $('#price').val() == "" )
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
           
           
           
            'Price': $('#price').val(),
            'Client': $('#ClientName').val(),
            'Factures': $('#Facture').val(),
            'Mode': $('#Mode').val(),
            'Num':$('#cheque').val(),
            "Date":$('#Date_enc').val()
          
           
          }
           
            
      
          $.ajax({
             url : '/dashboard/bank/create',
             data: data,
             type: 'post',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {
              if(result.error)
               {
               
                $('.error').text( result.error)
                setTimeout(function() { $('.error').text('');}, 2000);
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
             url : '/dashboard/bank/delete',
             data:{'id':id},
             type: 'delete',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {
            
              $("#btn"+id).closest("tr").remove();
              total = 0;
          
             $.each(result.banks, function(key, item){

             

                total = total + item.Total_Amount;

              

             })
           
           

             $("#total").text('Total: '+total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' Da' )
          
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
       
       $('#Mode').change(function(){
        
          var type = $(this).val();
          if( type == "cheque")
          {
            $('.cheq').show();
            
            
          }
          else if ( type == "especes"){
            $('.Date').hide();
            $('.cheq').hide();
           
          }
          else{
          
            $('.Date').show();


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
            window.scrollTo({ top: 0, behavior: 'smooth' });
            total = 0;
            $.each(result.banks, function(key, item){
            
            
            
              var dateString = moment(item.Date_Enc).format('DD-MM-YYYY');
              var dateString2 = moment(item.created_at).format('DD-MM-YYYY');

        
              total = total + item.Amount;

              if(result.user == item.UserId || result.role == "admin")
                {

            $('tbody').append('\
            <tr>\
          <td>'+item.client.Name+'</td>\
          <td>'+item.Mode+'</td>\
          <td>'+item.Total_Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
          <td> Facture N°'+item.Fact_num+'</td>\
          <td>'+item.Fact_Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
          <td>'+dateString+'</td>\
          <td>'+dateString2+'</td>\
          <td>               <a href="/dashboard/Bank/'+item.id+'/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print"></i></a>\
             <button onclick="deleteOperation('+item.id+')" id="btn'+item.id+'" class="btn btn-danger" ><i class="fas fa-trash"></i></button>\
               </td>\    </tr>')

              }

              else{
                $('tbody').append('\
            <tr>\
          <td>'+item.client.Name+'</td>\
          <td>'+item.Mode+'</td>\
          <td>'+item.Total_Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
          <td> Facture N°'+item.Fact_num+'</td>\
          <td>'+item.Fact_Amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
          <td>'+dateString+'</td>\
          <td>'+dateString2+'</td>\
          <td>               <a href="/dashboard/Bank/'+item.id+'/print" class="btn btn-success text-white" role="button" ><i class="fas fa-print"></i></a>\
               </td>\    </tr>')

              }



                  
          
            
           }) 
          
          
           $("#total").text('Total: '+result.total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' Da' )

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
      url : '/dashboard/Bank/facture',
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