<?php

include __DIR__.'/../config.php';
include root.'/assets/bootstrap.php';
include root.'/Common/header.php';
$DBcon = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);
$query = "select * from medicines";
$result = $DBcon->query($query);
$query1 = "select * from lab_procedures";
$result1 = $DBcon->query($query1);
// print_r();
?>
<!-- Modal -->
<div id="inp_pat" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Alert !</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <label> The Entered ID is an out Patient </label>
        </div>  
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Go Back</button>
        <button type="button" class="btn btn-default" onclick="javascript: window.location.href = '/patient/op.php'">Go to OUT patient</button>
      </div>
    </div>

  </div>
</div>
<div id="medicine" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width : 80%">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <table class="table" >
            <thead id="pres_table">
              <th>Medicine Name</th>
              <th>Morning</th>
              <th>Afternoon</th>
              <th>Night</th>
              <th>Total Days</th>
              <th>When</th>
              <th></th>
            </thead>
            <tbody>
            <tr>
            <td><select class="form-control" id="med_nam">
              <option>Medicine Name</option>
              <?php while ($exe = $result->fetch_assoc()) {
                echo "<option value=".$exe['id'].">".$exe['medicine_name']."</option>";
              }

              ?>
            </select>
            <p id="price"></p></td>
          
          
            
              <td><input type="number" class="form-control" id="mor"></td>
            
            
              <td><input type="number" class="form-control" id="aft"></td>
            
            
              <td><input type="number" class="form-control" id="nig"></td>
              <td><input type="number" class="form-control" id="day"></td>
              <td><label><input type="radio" name="optradio" class="bef_aft" value="1">Before Food</label>
            
              <label><input type="radio" name="optradio" class="bef_aft" value="0">After Food</label></td>
              
                
              
              <td><button class="btn btn-default" id="add_med">Add</button></td>
            </tr>
            </tbody>
          
            
              
          </table>  
          
          
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div>
                
              <table class="table">
                <thead>
                  <th>Name</th>
                  <th>Morning</th>
                  <th>Afternoon</th>
                  <th>Night</th>
                  <th>Total Days</th>
                </thead>
                <tbody class="med">
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="save_pres">Save</button>
      </div>
    </div>

  </div>
</div>
<div id="test" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign Test</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-4">
            <select class="form-control" id="test_nam">
              <option selected disabled>Test Name</option>
              <?php while ($exe1 = $result1->fetch_assoc()) {
                echo "<option value=".$exe1['procedure_id'].">".$exe1['procedure_name']."</option>";
              }
              ?>
            </select>
            <p id="price"></p>
          </div>
          <div class="col-sm-4">
            <button class="btn btn-default" id="add_test"> Add</button>
              
            
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div>
              
                
              <table class="table">
                <thead>
                  <th>Name</th>
       
                </thead>
                <tbody class="tst">
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="save_test">Save</button>
      </div>
    </div>

  </div>
</div>
<div id="change_room_confirm" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body" style="text-align: center;">
        <label>Here are the Room Details, Verify and Confirm.</label><br>
        <label>Block:<span id="cnf_block"></span></label><br>
        <label>Ward:<span id="cnf_ward"></span></label><br>
        <label>Room:<span id="cnf_room"></span></label><br>
        <label>Are You Sure to Change the Room?</label>
      </div>
      <div class="modal-footer" style="text-align: center;">
        <label id="result_room"></label>
        <button type="button" class="btn btn-success" id="change_room_confirm_yes">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>

  </div>
</div>
<div id="update" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-body">
        <div id="question">
          <div class="row">
            <div class="col-lg-12">
              <h3><center><label id="lab">Are you the Consultant?
              </label></center></h3>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <button class="btn pull-right" id="yes">Yes</button>
            </div>
            <div class="col-lg-6">
              <button class="btn" id="no">No</button>
            </div>
          </div>        
        </div>
        
        <div id="updates" style="display: none">
          <div class="row">
            <div class="col-lg-12">
              <h3><center><label id="lab">Update Consultant Visit
              </label></center></h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" id="doc">
                <option>Select Doctor</option>
              </select>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control" disabled value="<?php echo date('Y-m-d H:m:s');?>">
            </div>
            <div class="col-md-4">
              <input type="text" id="comments" class="form-control" placeholder="Comments">
            </div>
          </div>        
          <hr>
          <div style="text-align: center;">
            <button class="btn btn-success" id="save_visit" data-dismiss="modal">Save</button>
          </div>
        </div>
      </div>

      <!-- <div class="modal-footer">
        <center><button type="button" class="btn btn-" data-dimdiss="modal">Close</button></center>
      </div> -->
    </div>
  </div>
</div>
<div id="show_visits" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="color: white">Visits</div><br>
      <div class="modal-body">
        
        <div class="row">
        <div class="col-md-12">
            <table class="table table-stripped" id="visits_table">
              <thead>
                <th>Doctor</th>
                <th>Consulted on</th>
                <th>Comments</th>
              </thead>
              <tbody id="visit_body">
                
              </tbody>

            </table>
        </div>
        </div>
        
      </div>
      <div class="modal-footer center-block">
        <button type="button" class="btn " id="valid">OK</button>
        <!-- <button type="button" class="btn " id="not_valid">NOT VALID</button> -->
      </div> 
    </div>

  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="col-md-3">
            <input type="text" class="form-control" name="name" placeholder="ID" id="pat_id">
            <label id="alert"></label>
            <div class="row">
              <div class="col-md-6">
                <button type="button" class="form-control" onclick="get_details_with_register_number($('#pat_id').val())">Visit ID</button>
              </div>
              <div class="col-md-6">
                <button type="button" class="form-control" onclick="get_details_with_patient_id($('#pat_id').val())">Patient ID</button>
              </div>
              
            </div>
        </div>
        <div class="col-md-9" style="margin-top: 5px;">
        <div class="col-md-4">
            <label>Name:<span id="name"></span></label>
          
        </div>
        <div class="col-md-4">
            <label>DOB:<span id="dob"></span></label>
          
        </div>
        <div class="col-md-4">
            <label>Condition:<span id="complaint"></span></label>
        </div>
        </div>
      </div>
    </div>
  </div>
  <div id="wrd" style="display: none">
  <div class="row">
      <div class="col-md-6">
          <div class="panel panel-default">
              <div class="panel-body">
                <button class="btn btn-info" data-toggle="modal" data-target="#update">UPDATE VISIT</button>
                <button class="btn btn-info" data-toggle="modal" data-target="#show_visits" id="show_visits_btn">SHOW VISITS</button>
              </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-header"><label>Change to Reallocate Bed</label></div>
              <div class="panel-body">
                
                <div class="col-md-4">
                  <select class="form-control" id="block">
                    <option>Block Number</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <select class="form-control" id="ward">
                    <option>Ward Name</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <select class="form-control" id="room">
                    <option>Room Number</option>
                  </select>
                </div>

                <div class="row" style="text-align: center;">

                  <button class="btn btn-success" id="update_rm_confm">Click To Update</button>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-default">
              <div class="panel-body">
                <div class="pull-right" style="margin-bottom: 7px"><button class="btn btn-warning" data-toggle="modal" data-target="#medicine">Add Medicine</button></div>
                <table class="table">
                  <thead>
                    <th>Medicine Name</th>
                    <th>Quatity</th>
                    <th>Used Date</th>
                    <th>Status</th>
                    
                  </thead>
                  <tbody id="med_pres">
                    
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      
        <div class="col-md-6">
          <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">
                <div class="col-sm-4">
                  <form action="<?php echo domain.'/View/ot.php' ?>" method="post">
                    <button class="btn btn-danger">Send to Operation</button>
                    <input type="hidden" name="reg_id" id="ot">
                  </form>
                </div>
                <div class="col-sm-4">
                <h3>Clinical Data</h3>
                </div>
                <div class="col-sm-4" style="text-align: center;">
                  <button class="btn btn-warning" data-toggle="modal" data-target="#test">Assign Test</button>

                </div> 
                </div>
                <table class="table">
                  <thead>
                    <!-- <th></th> -->
                    <th>Test Name</th>
                    <th>Requested On</th>
                    <th>Recommended By</th>
                    <th>Status</th>
                    <th>Results</th>
                    <!-- <th>Result</th> -->
                  </thead>
                  <tbody id="test_reports">
                    
                  </tbody>
                </table>
                <!-- <label class="pull-right">Total amt:<span>250</span></label> -->
              </div>
          </div>
        </div>
        
  </div>

  
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
<?php if($_GET['reg_id']){ ?>
  window.reg_id = <?php echo $_GET['reg_id']; ?>;
  get_details_with_register_number(window.reg_id);
<?php } ?>
  var amt = 0;
  var type = 0;
  var price = 0;
  var total = 0;
  var row = "";
  var medicines = [];
  var reg_id = 0;
  var room = 0;
  $('#reg_id').on('change',function(){
    value = $(this).val();
    $('#ot').val(value);
    get_details(value);
    get_lab_details(value);   
    medicine(value);
    $('#wrd').css("display","block");
  });    
  $('#show_visits_btn').on('click',function(){
    $.ajax({
      url    :    "<?php echo inpatient; ?>",  
      method   :      "post",
      data     : {'reg_id':reg_id},
      success : function(response){
        // if (response.data.total_visits.length) 
        // {
          response = JSON.parse(response);
          console.log(response);
          result = "";
          result1 = "";
           for(var i = 0 ; i< response.data.length ; i++)
            {
              result += "<tr>";
              result += "<td>"+response.data[i].l_name+"</td>";
              result += "<td>"+response.data[i].visited_on+"</td>";
              result += "<td>"+response.data[i].comments+"</td>";
              result += "</tr>";
              
            }
              result1 += "<tr>";
              result1 += "<td></td>";
              result1 += "<td>Total Charged</td>";
              result1 += "<td>"+response.data[0].total_amt+"</td>";
              result1 += "</tr>";
            // $('#total').html(response.data[0].total_amt);  
            $('#visit_body').html(result);
            $('#visits_table').DataTable();
        // }
      },   

        
    });
    
    
  });    
  $('#change_room_confirm_yes').on('click',function(){
    data = {'room_id' : $('#room').val() , 'reg_id' :window.reg_id };
    $.ajax({
      url: "<?php echo inpatient; ?>",
      method : 'post',
      dataType: 'JSON',
      data: { 'update_room' : 1 , 'data' : JSON.stringify(data) },
      success: function(response) {
        if(response.details)
        {
          $('#result_room').html(response.details);
        }
        
      }
    });  
  });
  $('#update_rm_confm').on('click',function(){
    $('#cnf_room').html($('#room').find("option:selected").text());
    $('#cnf_ward').html($('#ward').find("option:selected").text());
    $('#cnf_block').html($('#block').find("option:selected").text());
    $('#change_room_confirm').modal('show');
  });
  $('#yes').on('click',function(){
    $('#updates').css('display','block');
    $('#doc').html('<option value="<?php echo $_SESSION['userId'];?>">Dr. <?php echo $_SESSION['userSession'];?></option>');
    $('#question').css('display','none');
  });
  $('#no').on('click',function(){
    $('#updates').css('display','block');
    $('#question').css('display','none');
  });
  $('#save_visit').on('click',function(){
    comments = $('#comments').val();
    doc_id = $('#doc').val();
    $.ajax({
      url: "<?php echo inpatient; ?>",
      method : 'post',
      dataType: 'JSON',
      data: {'save_visit': 1, 'data' : JSON.stringify({'doc_id' : doc_id, 'comments' : comments ,'reg_id' : reg_id})},
      success: function(response) {
        
        
      }
    });  
  });
  $.ajax({
      url: "<?php echo patientDetails1; ?>",
      method : 'post',
      dataType: 'JSON',
      data: {'team_id' : 10},
      success: function(response) {
        if(response.status="success")
        {
        $('#doc').html("<option selected disabled>Select Doctor</option>");
        for(var i = 0 ; i<response.data.length;i++)
        {
          $('#doc').append('<option value="'+response.data[i].staff_id+'">Dr. '+ response.data[i].f_name+'</option>');
        }
      }
        
      }
    });
  $('#block').on('change',function(){
    update_ward($(this).val());
  });
  $('#ward').on('change',function(){
    update_room($(this).val());
  });
  
  var tests = [];
  $('#add_test').on('click',function(){
    // var qty = $('#qty').val();
    // $('#qty').val("");

    // console.log(total);
    var test_name = $('#test_nam').find("option:selected").text();
    if(test_name != "Test Name"){
        tests.push({'id' : $('#test_nam').val()});
       row += "<tr><td>"+test_name+"</td></tr>";
       // var tot = "<tr><td>Total Amt:</td><td>"+total+"</td>";
       $('.tst').html(row);
    }
    
  });
  $('#save_test').on('click',function(){
    // console.log(medicines);
    if(tests.length && window.reg_id){
    $.ajax({
      url: '<?php echo update_op; ?>',
      method : 'post',
      dataType : 'json',
      data: {'tests' : JSON.stringify(tests) , 'reg_id' :window.reg_id , 'doc_id': <?php echo $_SESSION['userId'];?>},
      success: function(response) {
      
        alert("Added Success");
        
      }
     });
    }
    else{alert("Please Add tests");}
  });
  
  var total = 0;
  $('#med_nam').on('change',function(){
    var med_name = $(this).val();
    $.ajax({
      url: '<?php echo med_price; ?>',
      method : 'post',
      dataType : 'json',
      data: {'med_id' : med_name},
      success: function(response) {
        price = response.data.price;
        $('#price').html("$"+price);
      }
     });
    
  });
  $('#add_med').on('click',function(){
    var morn = $('#mor').val() != "" ? $('#mor').val() : 0;
    var aft = $('#aft').val() != "" ? $('#aft').val() : 0;
    var nig = $('#nig').val() != "" ? $('#nig').val() : 0;
    var days = $('#day').val() != "" ? $('#day').val() : 0;
    var bef_aft = $('.bef_aft:checked').val();
    var bef_aft_text  = bef_aft == "1" ? "Before Food" : "After Food";

    

    console.log(total);

    var name = $('#med_nam').find("option:selected").text();
    if(days != "" && name != ""){
      qty = (parseInt(morn)+parseInt(aft)+parseInt(nig))*days;
        medicines.push({'id' : $('#med_nam').val(), 'morning' : morn , 'afternoon' : aft,'night' : nig,'days':days , 'qty' : qty,'bef_aft': bef_aft });
      total += parseInt(qty)*parseInt(price);
       row += "<tr><td>"+name+"</td><td>"+morn+"</td><td>"+aft+"</td><td>"+nig+"</td><td>"+days+"</td><td>"+ bef_aft_text +"</td></tr>";
       var tot = "<tr><td>Total Amt:</td><td>"+total+"</td>";
    }
    $('#mor').empty();
    $('#aft').empty();
    $('#nig').empty();
    $('#day').empty();
    $('#med_name').empty();

    $('.med').html(row+tot);
  });
  $('#save_pres').on('click',function(){
    if(medicines.length && window.reg_id){
    $.ajax({
      url: '<?php echo update_op; ?>',
      method : 'post',
      dataType : 'json',
      data: {'medicines' : JSON.stringify(medicines) , 'reg_id' : window.reg_id},
      success: function(response) {
      medicines = [];
        alert("Added Success");
        rowq = "";
          for(var i = 0; i< response.data.length ; i++)
          {
          rowq += "<tr><td>"+response.data[i].medicine_name+"</td><td>"+response.data[i].morning+"</td><td>"+response.data[i].afternoon+"</td><td>"+response.data[i].night+"</td><td>"+response.data[i].days+"</td><td>"+response.data[i].on_date+"</td></tr>";
          }
          $('.med_pres').html(rowq);
          $('.med').html("");
          row = "";tot = "";
          total = 0;
          // addPrescription(window.reg_id);
      }
     });

    }
    else{alert("Please Add Medicines");}
  });
  
});
function medicine(reg_id)
  {
    $.ajax({
        url: '<?php echo update_op; ?>',
        method : 'post',
        dataType : 'json',
        data: {'reg_id': reg_id},
        success: function(response) {
          rowq = "";
          if(response.data)
          {
            console.log(response.data);
            for(var i = 0; i< response.data.length ; i++)
            {
            rowq += "<tr><td>"+response.data[i].medicine_name+"</td><td>"+response.data[i].qty+"</td><td>"+response.data[i].on_date+"</td><td>"+(response.data[i].status == "0"? "Pending" : "Delivered" )+"</td></tr>";
            }
            $('#med_pres').html(rowq);
        }
        }
       });
  } 
function get_details(value)
  {
    $.ajax({
      url: '<?php echo patientDetails; ?>',
      method : 'post',
      dataType : 'json',
      data: {'patient_id' : value, 'complaint' : 1},
      success: function(response) {
        console.log(response);
        if(!response.data)
        {
          $('#alert').html("Patient Id not available");
        }
        if(response.status == "success")
        {
          if(response.is_inp == "1")
          {

            var options = "";
            var result = "";
            reg_id = value;
            $('#name').html(response.data[0].name);
            $('#dob').html(response.data[0].dob);
            $('#complaint').html(response.now_complaint);  

            rooms(response.data[0].room_id);
            room = response.data[0].room_id;
          }
          else
          {
            $('#inp_pat').modal('show');
          }
        }
        
      }   

    });

  }
  function rooms(value)
  {
      $.ajax({
        url: "<?php echo patientDetails1; ?>",
        method : 'post',
        dataType: 'JSON',
        data: {'get_room_1' : 'true'},
        success: function(response) {
        if(response.status="success")
        {
          console.log(response);
          $('#room').html("<option selected disabled>"+value+"</option>");
          for(var i = 0 ; i<response.data.length;i++)
          {
            if(response.data[i].room_id == value){
              get_ward_block(response.data[i].ward_id);
              continue;
            }
            $('#room').append('<option value="'+response.data[i].room_id+'">Room Type:'+response.data[i].type_name +'</option>');
          }

          
        }
          
        }
      });
  }
  function get_ward_block(room)
  {
    $.ajax({
        url: "<?php echo patientDetails1; ?>",
        method : 'post',
        dataType: 'JSON',
        data: {'get_ward_block' : room},
        success: function(response) {
        if(response.status="success")
        {
          console.log(response);
          create_select_box(response.data.blocks,response.data.selected.block,"block");
          create_select_box(response.data.wards,response.data.selected.ward,"ward");
          // $('#ward').html("<option selected disabled>"+value+"</option>");
          // for(var i = 0 ; i<response.data.length;i++)
          // {
          //   if(response.data[i].room_id == value){
          //     get_ward_block(response.data[i].ward_id,value)
          //     continue;
          //   }
          //   $('#room').append('<option value="'+response.data[i].room_id+'">Room Type:'+response.data[i].type_name +'</option>');
          // }

          
        }
          
        }
      });

  }
  function create_select_box(list,selected,onclass)
  {
      val = "#"+onclass;
      $(val).html("<option selected disabled value='"+selected.id+"' >"+selected.name+"</option>");
      for(var i = 0 ; i<list.length;i++)
      {
        if(list[i].id == selected.id){ 
          continue;
        }
        $(val).append('<option value="'+list[i].id+'">'+list[i].name +'</option>');
      }    
  }
  function update_ward(data)
  {
    $.ajax({
        url: "<?php echo patientDetails1; ?>",
        method : 'post',
        dataType: 'JSON',
        data: {'get_wards' : data},
        success: function(response) {
          if(response.status="success")
          {

            create_select_box(response.data,"Select Ward","ward");
          }
          
        }
      });
  }
  function update_room(data)
  {

    $.ajax({
        url: "<?php echo patientDetails1; ?>",
        method : 'post',
        dataType: 'JSON',
        data: {'get_room' : 'data','data' : data},
        success: function(response) {
        if(response.status="success")
        {
          console.log(response);
          if(!response.data.length)
            $('#room').html("<option selected disabled>No Room Available In Ward</option>");
          else
            $('#room').html("<option selected disabled>Select Room</option>");
          for(var i = 0 ; i<response.data.length;i++)
          {
            $('#room').append('<option value="'+response.data[i].room_id+'">Room Type:'+response.data[i].type_name +'</option>');
          }

          
        }
          
        }
      }); 
  }
function get_details_with_patient_id(value)
{
  $.ajax({
      url: '<?php echo patientDetails1; ?>',
      method : 'post',
      dataType : 'json',
      data: {'get_last_reg': 1 ,'pat_id' : value},
      success : function(response){
        reg_id = response.data.registration_id;
        get_details_with_register_number(reg_id);

      }
  });
    
}
function get_details_with_register_number(reg_id)
{
  $('#ot').val(reg_id);
  window.reg_id = reg_id;
  getAllDetails(window.reg_id);
  $.ajax({
      url: '<?php echo patientDetails1; ?>',
      method : 'post',
      dataType : 'json',
      data: { 'complaint' : 1,'reg_id' : window.reg_id},
      success: function(response) {
        
        if(!response.data)
        {
          $('#alert').html("Patient Id not available");
        }
        if(response.status == "success")
        {
          if(response.is_inp == "0")
          {

            var options = "";
            var result = "";
            
            for(var i = 0 ; i< 5 ; i++)
            {
              $('#alert').html("");
              if(response.complaint[i]){

                options +='<button class="btn btn-default reg_button" value="'+response.complaint[i].registration_id+'">Visit No '+response.complaint[i].registration_id+'<br>'+response.complaint[i].on_date.substr(0, 10);+'</button>'
              }
              
              
            }
            for(var i = 0 ; i< response.data.length ; i++)
            {
              
              
              // result += "<tr>";  
              result += "<td>"+response.data[i].name+"</td>";
            result += "<td>"+response.data[i].dob+"</td>";
            result += "<td>"+response.data[i].sex+"</td>";
            result += "<td>"+response.now_complaint+"</td>";
            // result += "<td>"+response.data[i].last_visit+"</td>";
              // result += "</tr>"; 
            }
            // head += result + "</tbody></table>"
            $('#reg_buttons').html(options);  
            $('#pat_details').html(result); 
            

          }
          else
          {
            $('#out_pat').modal('show');  
          }
        }
        
      }   

    });
    
}
function getAllDetails(value)
{
  $.ajax({
    url: '<?php echo patientDetails; ?>',
    method : 'post',
    dataType : 'json',
    data: {'patient_id' : value, 'complaint' : 1,'single' :1},
    success: function(response) {
      $('#navs').show();
      window.reg_id = response.complaint.registration_id;
      $('.reg_id').val(window.reg_id);
      get_details(window.reg_id);
      get_lab_details(window.reg_id);   
      medicine(window.reg_id);
      $('#wrd').css("display","block");
      // addComplaint(response.complaint.complaint,window.reg_id);
      // addInvestigation(response.complaint.investigation,window.reg_id);
      // addDiagnosis(response.complaint.diagnosis,window.reg_id);
      // addPrescription(window.reg_id);
      // addAdvice(response.complaint.advice,response.complaint.next_visit,window.reg_id);
      // addLabTest(window.reg_id);
      // addVitals(response.vitals,window.reg_id);
      // genBill(window.reg_id);
      // // $('#complaintTab1').trigger('click');
      // $('#complaintTab1').find('a').trigger('click');
      
    }
  });
}
function get_lab_details(reg_id)
  {

    $.ajax({
        url: "<?php echo inpatient; ?>",
        method : 'post',
        dataType: 'JSON',
        data: {'get_lab' : 'true','data' : reg_id},
        success: function(response) {
          if(response.status="success")
          {
            var content = "";
            for(var i = 0 ; i<response.data.length;i++)
            {
                content += "<tr>";
                content += "<td>"+response.data[i].procedure_name+"</td>";
                content += "<td>"+response.data[i].at_time+"</td>";
                content += "<td> Dr."+response.data[i].f_name+" "+response.data[i].l_name+"</td>";
                content += "<td>"+(response.data[i].status == "1" ? "Completed" : "Pending" )+"</td>";
                content += "<td>"+response.data[i].result_value+"</td>";
                content += "</tr>"
            }  

            $('#test_reports').html(content);
            
          }
          
        }
      }); 
  }
</script>