<?php
// TA:60:4
$page_title = "Police sector | GBV ";
$current_page = "home";

require_once 'includes/global.inc.php';

// check to see if they're logged in
if (isset($_SESSION['logged_in'])) {
    
    // get the user object from the session
    $user = unserialize($_SESSION['user']);
    
if( !($userTools->isAdmin($user->user_group) &&  $user->sector === '3')){
        print " You do not have permission to access this page.";
        return;
    }
    
    // include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1
    include "../../includes/Dash_header.php"; // TA:60:1
    include "../../includes/topbar.php"; // TA:60:1
    ?>
    
 

<script type="text/javascript">

   
function shaw_progress_bar(){
	//$("#progress_bar").html("<img src='../../UI/images/data_loading_animation.gif' width=300 height=200/>");
 
    var box = document.createElement('div');
    box.style.position = 'fixed';
    box.style.left = '180px';
    box.style.top = '407px';
    box.style.align = 'center';
    box.style.fontFamily = 'Verdana, Arial, serif';
    document.body.appendChild(box);

    var message = document.createElement('span');
    message.style.fontWeight = 'bold';
    message.style.textAlign = 'center';
    message.innerHTML = 'Please wait. Your file is being uploaded...';
    box.appendChild(message);
//not working ????
//     var img = document.createElement('IMG');
//     img.setAttribute('src', 'data_loading_animation.gif');
//   //  img.style.display = 'block';
//     box.appendChild(img);
}

    </script>

<div id="main-content_with_side_bar">

	<div id="content-body">
		
		<!-- TA:60:1 -->
		<div class="profile-data" align="left">

			<!-- TA:60:1 START -->

			<div id='progress_bar' align='center'style="position: absolute; top: 250px; left: 200px;"></div>
			
			<div id="entry_form">

			<h2 class="page-title-section">Police sector import excel</h2>
			<form onsubmit="shaw_progress_bar();" action="enter_data.php?mode=add_aggregates_csv" method="post" enctype="multipart/form-data">
			<table width="900px" border="0" cellspacing="5"
				style='font-family: Verdana, Geneva, sans-serif; font-size: 12px;'>
				<tr>
					<td>
					Instruction:<br>
					1. Download Excel template <a href="files/Police sector data entry sheet.xlsx">here</a><br>
					2. Enter data into white cells only. <i>Gray cells are not editable. Do not change headers or do not move columns.</i><br>
					3. Save file into your local computer<br>
					3. When file is ready to be uploaded save file as CSV file. <i>In MS Excel: File -> Save As -> Save as type: CSV (Comma delimeted) (*.csv)</i><br>
					4. Select file from your local computer: <input type="file" id="fileToUpload" name="fileToUpload" multiple size="50" ><br><br>
					<button type="submit" name='submit' class="submit_button">Upload file</button> 
					</td>
				</tr>
				<tr><td><div id='out'></div></td></tr>
				
                
				
			</table>
			</form>
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
    include "../../includes/footer.php";
} else {
    // Redirect user back to login page if there is no valid session created
    header("Location: ../../login.php");
}
?>