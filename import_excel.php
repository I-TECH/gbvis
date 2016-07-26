<?php
// TA:60:4
$page_title = "Education sector | GBV ";
$current_page = "home";

require_once 'includes/global.inc.php';

// check to see if they're logged in
if (isset($_SESSION['logged_in'])) {
    
    // get the user object from the session
    $user = unserialize($_SESSION['user']);
    
 if( !($userTools->isSuperAdmin($user->user_group) || ($userTools->isAdmin($user->user_group) &&  $userTools->judiciary($user->sector)))){
        print " You do not have permission to access this page.";
        return;
    }
    
    // include "includes/header.php";
    include "includes/Dash_header.php"; // TA:60:1
    include "includes/topbar.php"; // TA:60:1
    
    $sector_id = $mode = $_GET['sector_id'];
    $sector_excel_template = "";
    $sector_url_data_enter = "";
    $sector_title = "";
    if($sector_id === '1'){
        $sector_excel_template = "Sectors/Judiciary/files/Judiciary sector data entry sheet.xlsx";
        $sector_url_data_enter = "Sectors/Judiciary/enter_data.php";
        $sector_title = "Judiciary";
    }else if($sector_id === '2'){
        $sector_excel_template = "Sectors/Health/files/Health sector data entry sheet.xlsx";
        $sector_url_data_enter = "Sectors/Health/enter_data.php";
        $sector_title = "Health";
    }else if($sector_id === '3'){
        $sector_excel_template = "Sectors/Police/files/Police sector data entry sheet.xlsx";
        $sector_url_data_enter = "Sectors/Police/enter_data.php";
        $sector_title = "Police";
    }else if($sector_id === '4'){
        $sector_excel_template = "Sectors/Prosecution/files/Prosecution sector data entry sheet.xlsx";
        $sector_url_data_enter = "Sectors/Prosecution/enter_data.php";
        $sector_title = "Prosecution";
    }else if($sector_id === '5'){
        $sector_excel_template = "Sectors/Education/files/Education sector data entry sheet.xlsx";
        $sector_url_data_enter = "Sectors/Education/enter_data.php";
        $sector_title = "Education";
    }else{
        echo "<br><b> Wrong sector id selected.</b>";
        return;
    }
    
    ?>
    
 

<script type="text/javascript">

    function uploadDataOld(){

        //read file content
   	 if (window.File && window.FileReader && window.FileList && window.Blob) {
	   	    var fileSelected = document.getElementById('fileToUpload');

		   	//validate file extension
	   	    if(!fileSelected.value.endsWith('.csv')){
		   	    alert("Please upload CSV file.");
		   	    return;
	   	    }

		   	
	   	         var fileExtension = /text.*/; 
	   	         var fileTobeRead = fileSelected.files[0];
	   	         if (fileTobeRead.type.match(fileExtension)) { 
	   	             var fileReader = new FileReader(); 
	   	             fileReader.onload = function (e) { 
	   	                 var fileContents = document.getElementById('filecontents'); 
	      	             var file_content = fileReader.result.split(/\r\n|\n|\r/).join(";");

		      	          
	      	             
		      	            $.ajax({
			      	      		  type:"post",
			      	      		  url:"<?php echo $sector_url_data_enter;?>?mode=add_aggregates_csv&data=" + file_content,     
			      	      		  beforeSend: function(  ) {
			      	      			  document.getElementById("entry_form").style.visibility = "hidden";
			      	      			  $("#progress_bar").html("<img src='UI/images/data_loading_animation.gif' width=300 height=200/>");
			      	      		  }
			      	      		})
			      	      		  .done(function( data ) {
			      	      			  $("#progress_bar").html("");
			      	      			  if(data){
				      	      			 
			      	      				  alert(data);
			      	      			  }else{
			      	      				  alert("No any data were insirted into database.");
			      	      			  }
			      	      			  document.getElementById("entry_form").style.visibility = "visible";
			      	      			  clean_form();
			      	      		  });
		      	      		  
	   	             } 
	   	             fileReader.readAsText(fileTobeRead); 
	   	         } 
	   	         else { 
	   	             alert("Please select CSV file"); 
	   	         }  
	   	} 
	   	 else { 
	   	     alert("Files are not supported by your browser"); 
	   	 } 
    }

    function uploadData(){
    	

 	   $.ajax({
   		  type:"post",
   		  url:"Sectors/judiciary/enter_data.php?mode=add_aggregates_csv", 
     		fileName: document.getElementById('fileToUpload').value();   
   		  beforeSend: function(  ) {
   			  document.getElementById("entry_form").style.visibility = "hidden";
   			  $("#progress_bar").html("<img src='UI/images/data_loading_animation.gif' width=300 height=200/>");
   		  }
   		})
   		  .done(function( data ) {
   			  $("#progress_bar").html("");
   			  if(data){
      			 
   				  alert(data);
   			  }else{
   				  alert("No any data were insirted into database.");
   			  }
   			  document.getElementById("entry_form").style.visibility = "visible";
   			  clean_form();
   		  });
        
    }

    </script>

<div id="main-content">

	<div id="content-body">
		
		<!-- TA:60:1 -->
		<div class="profile-data" align="left">

			<!-- TA:60:1 START -->

			<div id='progress_bar' align='center'style="position: absolute; top: 250px; left: 200px;"></div>
			<div id="filecontents"></div>
			
			
			<div id="entry_form">

			<h2 class="page-title-section"><?php echo $sector_title;?> sector import excel</h2>
			
			<table width="900px" border="0" cellspacing="5"
				style='font-family: Verdana, Geneva, sans-serif; font-size: 12px;'>
				<tr>
					<td>
					Instruction:<br>
					1. Download Excel template <a href="<?php echo $sector_excel_template;?>">here</a><br>
					2. Enter data into white cells only. <i>Gray cells are not editable. Do not change headers or do not move columns.</i><br>
					3. Save file into your local computer<br>
					3. When file is ready to be uploaded save file as CSV file. <i>In MS Excel: File -> Save As -> Save as type: CSV (Comma delimeted) (*.csv)</i><br>
					4. Select file from your local computer: <input type="file" id="fileToUpload" name="fileToUpload" multiple size="50" ><br><br>
					<button type="submit" name='submit' class="submit_button" onclick=uploadData();>Upload file</button> 
					</td>
				</tr>
			</table>
			
			
			
			</div>
			<br>
			
			


			<!-- TA:60:1 END -->


			

			<br clear="all"> <br clear="all"> <br clear="all"> <br clear="all">
			<!--&nbsp;Your MD5 encrypted password: <font color="white"><?php //echo $passwd; ?></font>-->


			<br clear="all"> <br clear="all"> <br clear="all"> <br clear="all"> <br
				clear="all"> <br clear="all">
		</div>
		<br clear="all">
		</center>
	</div>
</div>
<?php
    include "includes/footer.php";
} else {
    // Redirect user back to login page if there is no valid session created
    header("Location: login.php");
}
?>