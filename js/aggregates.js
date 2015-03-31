function ajaxFunction()
{
	
	//alert(10);
var httpxml;
try
{
// Firefox, Opera 8.0+, Safari
httpxml=new XMLHttpRequest();
}
catch (e)
{
// Internet Explorer
try
{
httpxml=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
try
{
httpxml=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e)
{
alert("Your browser does not support AJAX!");
return false;
}
}
}
function stateChanged() 
{
if(httpxml.readyState==4)
{
//document.getElementById("msgDsp").style.display='inline'; // if Message box is hidden before
// red = #f00000; green = #00f040; yellow = #f0f000; brick= #f0c000; light yello = #f0f0c0
var myObject = JSON.parse(httpxml.responseText); 
if(myObject.data[0].status_form==="NOTOK"){ // status of form if notok
document.getElementById("msgDsp").style.borderColor='red';
document.getElementById("msgDsp").innerHTML=myObject.data[0].msg;
}/// end of if if form status is notok
else {
document.getElementById("msgDsp").style.borderColor='blue';
//document.getElementById("msgDsp").innerHTML=" Validation passed ";
document.getElementById("msgDsp").innerHTML=myObject.data[0].msg;
document.myForm.reset();
} // end of if else if status form notok

//alert(myObject.data[0].t1 + myObject.data[0].r1 +myObject.data[0].s1 + myObject.data[0].c1);
if(myObject.data[0].t1==="F")
{document.getElementById("t1").style.borderStyle='solid';
document.getElementById("t1").style.borderWidth='1px';
document.getElementById("t1").style.borderColor='red';}
else{
document.getElementById("t1").style.borderStyle='solid';
document.getElementById("t1").style.borderWidth='1px';
document.getElementById("t1").style.borderColor='white';
}


if(myObject.data[0].s1==="F")
{ document.getElementById("s1").style.borderStyle='solid';
document.getElementById("s1").style.borderWidth='1px';
document.getElementById('s1').style.borderColor='red' ; }
else{
document.getElementById("s1").style.borderStyle='solid';
document.getElementById("s1").style.borderWidth='1px';
document.getElementById('s1').style.borderColor='white' ; 
}

if(myObject.data[0].s2==="F")
{ document.getElementById("s2").style.borderStyle='solid';
document.getElementById("s2").style.borderWidth='1px';
document.getElementById('s2').style.borderColor='red' ; }
else{
document.getElementById("s2").style.borderStyle='solid';
document.getElementById("s2").style.borderWidth='1px';
document.getElementById('s2').style.borderColor='white' ; 
}

if(myObject.data[0].s3==="F")
{ document.getElementById("s3").style.borderStyle='solid';
document.getElementById("s3").style.borderWidth='1px';
document.getElementById('s3').style.borderColor='red' ; }
else{
document.getElementById("s3").style.borderStyle='solid';
document.getElementById("s3").style.borderWidth='1px';
document.getElementById('s3').style.borderColor='white' ; 
}

}
}

function getFormData(myForm) { 
var myParameters = new Array(); 
//// Text field data collection //
var val=myForm.aggregates.value;
val = "aggregates="+val;
myParameters.push(val);



// End of text field data collection //


////// Start of select box data collection ///////////
var val=myForm.county.options[myForm.county.options.selectedIndex].value;
val = "county="+val;
myParameters.push(val);

var val=myForm.survey.options[myForm.survey.options.selectedIndex].value;
val = "survey="+val;
myParameters.push(val);
var val=myForm.survey.options[myForm.survey.options.selectedIndex].value;

val = "sector="+val;
myParameters.push(val);

var val=myForm.indicator.options[myForm.indicator.options.selectedIndex].value;
val = "indicator="+val;
myParameters.push(val);
////////End of select box data collection /////////////


//alert(myParameters.join("&"));
return myParameters.join("&"); // return the string after joining the array


} 



var url="process_aggregates.php";
var myForm = document.forms[0]; 

var parameters=getFormData(myForm);
httpxml.onreadystatechange=stateChanged;
httpxml.open("POST", url, true)
httpxml.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
httpxml.send(parameters) 
document.getElementById("msgDsp").innerHTML="<img src=wait.gif>";

}
