<html>
<head>
	<script src="../js/jquery.min.js" type="text/javascript" ></script>
</head>
<body>

<script type="text/javascript">

var title = 0;
                  document.title = "["+ title + "] TweetDuvar.im - Markafoni";

function ping(){
       $.ajax({
          url: 'class_twittersearch.php',
          success: function(result){
          	$('#result').html(result);
            title += 1;
            document.title = "["+ title + "]";
          },     
          error: function(result){
          	$('#hata').html("hata oldu");
          }
       });
}

var second = 0;
function display(){ 
    second += 1;
  
  setTimeout("display()",600000);
  ping();
} 
display();

</script>

<div id="result"></div>
</body>
</html>