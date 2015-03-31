<?php
/*********************************************************************
* Author: Benard Koech
* Email: benardkkoech@gmail.com.
* Gender Base violence Information system
***********************************************************************/
//users_accounts.php
  $page_title = "User accounts| GBV";
    $current_page = "home";
	
require_once 'includes/global.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

include "includes/header.php"; 
include_once('includes/connection.php');
include_once('includes/functions.php');
$tabActive ='tab1';




?>

	    <div id="sidebar">
	  <center><h3 style="text-size:18px; font-family: TStar-Bol"></h3></center>
<div class="sidebar-nav">
	<?php
	  include "includes/sidebar.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		
        <div class="" align="left">
              <div class="tabbable" >
                  <ul class="nav nav-tabs">
                   <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Users</a></li>
                    <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">User Groups</a></li>
                    
                  </ul>
				<div class="tab-content" style="min-height: 350px ">
                    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
		<center><h3 class="page-title">Users</h3></center>
		<section class="" style="width:85%;">
	       <form action="#">
          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
          <a class="link-btn" href="create_users.php">Add New User</a>
        </form>
		</section>
        <div class="profile-data" align="left">
          <?php 
            
          if (isset($_GET['id'])) {
            $query = "DELETE FROM users WHERE id= '$_GET[id]'";
            mysql_query($query) or die(mysql_error());
          }
          ?>
            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover">
            <thead>
              <th><b>ID</b></th>
			 
			   <th><b>First Name</b></th>
			    <th><b>Last Name</b></th>
			  <th><b>User Name</b></th>
			   <th><b>User Group</b></th>
			    <th><b>Sector</b></th>
			  <th><b>Email</b></th>
			  <th><b> Created Date</b></th>
                           <th><b>View</b></th>
                        <th><b>Edit</b></th>
			   <th><b>Delete</b></th>
            </thead>
            <?php
         
     $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
            if ($page <= 0) $page = 1;
 
          $per_page = 10; // Set how many records do you want to display per page.
 
          $startpoint = ($page * $per_page) - $per_page;
          

       $statement = "`users` WHERE user_group!=1 ORDER BY id ASC"; // Change `records` according to your table name.
        
       //$where ="'sector_id'= $user_sector_name";
  
       $results = mysqli_query($conDB,"SELECT * FROM {$statement}  LIMIT {$startpoint} , {$per_page}");
        
        if (mysqli_num_rows($results)!= 0) {
     
       // displaying records.
        while ($row = mysqli_fetch_array($results)) {
         
                          $id = $row['id'];
			  $firstname = $row['firstname'];
			   $lastname = $row['lastname'];
			   $user_name = $row['username'];
			    $Ugroup = $row['user_group'];
			     $Usector = $row['sector'];
			    $email = $row['email'];
			  $date = $row['join_date'];
			  
         $groups_result = $db->selectData("user_groups","id = $Ugroup");

              foreach ($groups_result as $grows) 
                      {
  
                      $Ugroup = $grows['id'];
                      $group_name = $grows['group_name'];
                      }
             $sectors_result = $db->selectData("sectors","sector_id = $Usector");

              foreach ($sectors_result as $srows) 
                      {
  
                      $Usector = $srows['sector_id'];
                      $Usectorname = $srows['sector'];
                      }
        
    ?>
              <tr bgcolor="#FFFFFF" style="border-bottom: 1px solid #B4B5B0;">
                <td><?php echo $id ?></td>
                                 <td><?php echo $firstname ?></td>
				 <td><?php echo $lastname ?></td>
				  <td><?php echo $user_name ?></td>
				  <td><?php echo $group_name ?></td>
				  <td><?php echo $Usectorname ?></td>
				   <td><?php echo $email ?></td>
				<td><?php echo $date ?></td>
                               <td align="center"><a href='view_user.php?id=<?php echo $id;?>'><img src="images/icons/view2.png" height="20px"/><a></td>
			       <td align="center"><a href='edit_user.php?id=<?php echo $id;?>'><img src="images/icons/edit2.png" height="20px"/></a></td>
                             <td align="center"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>);'><img src="images/icons/delete.png" height="20px"/></a></td>
              </tr>
         <?php
            }
            } 
            else
            {
            ?>
            <tr>
          <td colspan="8"><?php echo "No records are found.";?></td>
          </tr>
              <?php }
            
 // displaying paginaiton.
        ?>
       <tr>
          <td colspan="8"><?php echo pagination($statement,$per_page,$page,$url='?');?></td>
          </tr>
          </table>
      <br clear="all"><br clear="all"><br clear="all">
      </div><br clear="all">
	  </div>
       <!--tab 2 ==============================================================================================-->
      <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
          <section class="" style="width:85%;">
		    <center><h3 class="page-title">User Groups</h3></center>
	       <form action="#">
          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
          <a class="link-btn" href="create_user_group.php">Add New Group</a>
        </form>
		</section>
        <div class="profile-data" align="left">
        
        
            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover">
            <thead>
              <th><b>ID</b></th>
			  <th><b>User Group</b></th>
			  <th><b>Description</b></th>
			  <th><b> Created Date</b></th>
              <th><b></b></th>
              <th><b></b></th>
			   <th><b></b></th>
            </thead>
            <?php
            $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
            if ($page <= 0) $page = 1;
 
            $per_page = 10; // Set how many records do you want to display per page.
 
            $startpoint = ($page * $per_page) - $per_page;
          

            $statement = "`user_groups` ORDER BY id ASC"; // Change `records` according to your table name.
        
       //$where ="'sector_id'= $user_sector_name";
  
           $results = mysqli_query($conDB,"SELECT * FROM {$statement}  LIMIT {$startpoint} , {$per_page}");
        
        if (mysqli_num_rows($results)!= 0) {
     
       // displaying records.
        while ($row = mysqli_fetch_array($results)) {
         
                             $id = $row['id'];
			    $group_name = $row['group_name'];
			    $description = $row['description'];
			    $date = $row['created'];
        ?>
       
              <tr bgcolor="#FFFFFF" style="border-bottom: 1px solid #B4B5B0;">
                <td><?php echo $id ?></td>
				 <td><?php echo $group_name ?></td>
				   <td><?php echo $description ?></td>
				<td><?php echo $date ?></td>
                 <td align="center"><a href='view_usergroup.php?id=<?php echo $id;?>'><img src="images/icons/view2.png" height="20px"/><a></td>
	         <td align="center"><a href='edit_usergroup.php?id=<?php echo $id;?>'><img src="images/icons/edit2.png" height="20px"/></a></td>
                 <td align="center"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>);'><img src="images/icons/delete.png" height="20px"/></a></td>
              </tr>
            <?php
            }
            } 
            else
            {
            ?>
            <tr>
          <td colspan="8"><?php echo "No records are found.";?></td>
          </tr>
              <?php }
            
 // displaying paginaiton.
        ?>
       <tr>
          <td colspan="8"><?php echo pagination($statement,$per_page,$page,$url='?');?></td>
          </tr>
          </table>
      <br clear="all"><br clear="all"><br clear="all">
      </div>
	      </div> 	
		</div> 		
	  </div> 
      </div>
	  <br clear="all">

	    </div> 		
	  </div> 
		

      
<!--filter includes-->
    <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>
    <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
    <script type="text/javascript">
                $(function() {
                  $('input#id_search').quicksearch('table tbody tr');
                });
    </script>
    <script>
      function show_confirm(id) {
        if (confirm("Are you Sure you want to delete?")) {
          location.replace('users_accounts.php?id=' + id);
        } else {
          return false;
        }
      }
    </script>
	<script type="text/javascript" >
	
!function ($) {

  "use strict"; // jshint ;_;


 /* TAB CLASS DEFINITION
  * ==================== */

  var Tab = function (element) {
    this.element = $(element)
  }

  Tab.prototype = {

    constructor: Tab

  , show: function () {
      var $this = this.element
        , $ul = $this.closest('ul:not(.dropdown-menu)')
        , selector = $this.attr('data-target')
        , previous
        , $target
        , e

      if (!selector) {
        selector = $this.attr('href')
        selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') //strip for ie7
      }

      if ( $this.parent('li').hasClass('active') ) return

      previous = $ul.find('.active:last a')[0]

      e = $.Event('show', {
        relatedTarget: previous
      })

      $this.trigger(e)

      if (e.isDefaultPrevented()) return

      $target = $(selector)

      this.activate($this.parent('li'), $ul)
      this.activate($target, $target.parent(), function () {
        $this.trigger({
          type: 'shown'
        , relatedTarget: previous
        })
      })
    }

  , activate: function ( element, container, callback) {
      var $active = container.find('> .active')
        , transition = callback
            && $.support.transition
            && $active.hasClass('fade')

      function next() {
        $active
          .removeClass('active')
          .find('> .dropdown-menu > .active')
          .removeClass('active')

        element.addClass('active')

        if (transition) {
          element[0].offsetWidth // reflow for transition
          element.addClass('in')
        } else {
          element.removeClass('fade')
        }

        if ( element.parent('.dropdown-menu') ) {
          element.closest('li.dropdown').addClass('active')
        }

        callback && callback()
      }

      transition ?
        $active.one($.support.transition.end, next) :
        next()

      $active.removeClass('in')
    }
  }


 /* TAB PLUGIN DEFINITION
  * ===================== */

  var old = $.fn.tab

  $.fn.tab = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('tab')
      if (!data) $this.data('tab', (data = new Tab(this)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.tab.Constructor = Tab


 /* TAB NO CONFLICT
  * =============== */

  $.fn.tab.noConflict = function () {
    $.fn.tab = old
    return this
  }


 /* TAB DATA-API
  * ============ */

  $(document).on('click.tab.data-api', '[data-toggle="tab"], [data-toggle="pill"]', function (e) {
    e.preventDefault()
    $(this).tab('show')
  })

}(window.jQuery);
	
	
	</script>

<!-- Popup Div Ends Here -->
	
<?php
 include "includes/footer.php";
	
	}

else
{
	//Redirect user back to login page if there is no valid session created
	header("location: login.php");
}
?>

