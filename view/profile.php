<?php # session_start()?>
<?php # echo ($_SESSION['imgUrl']) ?>
<html>

<head>
    <title>twitter</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="view/login.css"> -->
    <link rel="stylesheet" href="view/profile.css">
    <meta http-equiv="Cache-control" content="no-cache">
</head>

<body>
    <div>
        <div class="main-menu">
            <div class="menu-head">
                <img class="prof-img" id="profile-img" src="">
            </div>
            <div class="menu-body">
                <ul id="info">

                </ul>
            </div>
			
                    <a href="/check-twitter-user/logOut" class="btn btn-secondary"><div class="menu-footer">Logout	</div></a>
		
        </div>

        <div class="main-body">
			<div id=alert>

			</div>
	
            <div class="twit-post"id="twit-post">
                
            </div>
            <div class="card p-25">
                <h3>FeedBack</h3>
                <form action="/check-twitter-user/feedback" method="POST">
				<label> This your account</label>
					<select  name ="check_status"id ="check_status"required>
						<option selected disabled>this your account</option>
						<option value="1">yes it’s my account</option>
						<option value="0">no not my account</option>
					</select>
                    <label>FeedBack</label>
                    <textarea  name ="feedback"required >FeedBack </textarea >

                    <button type="submit" class="w-btn">
                        </i> submit</button>
                    <button type="reset" class="s-btn">cancel</button>

                </form>
            </div>
			<div  id="table">
			</div>

        </div>
    </div>
    <script>
    var profileImg = document.querySelector('#profile-img');
    var info = document.querySelector('#info');
	var alert = document.querySelector('#alert');
	alert.innerHTML ="<div class='alert'> <strong>wellcom ! </strong><?php echo($_SESSION['name']) ?> </div>";
    profileImg.src = "<?php echo $_SESSION['imgUrl'] ?>";
    info.innerHTML =
        "<li><?php echo($_SESSION['name']) ?> </li> <li></li>  <li>@ <?php echo($_SESSION['userName']) ?></li>";

    $.ajax({
        url: "https://api.twitter.com/1.1/users/show.json",
        type: "GET",
        dataType: 'jsonp',
        headers: {
            "Authorization": "your token",
          },
        data: {
            screen_name: "<?php echo($_SESSION['userName']) ?>"
        },
        success: function(data) {
			var info = document.querySelector('#twit-post');
            if (data.errors != null) {
                alert(data.errors[0].message);
				var card="<div class='card'><h1> not have @account</h1></div>";
				info.innerHTML=card;
            } else {
                
                // var profileImg = document.querySelector('#twit-img');
				var card="<div class='card'><img class='card-img' id='twit-img' src="+data.profile_image_url+"><div class='card-body'><h3>"+data.screen_name+"</h3><p class='post'>"+data.status.text+"</p> </div></div>";
				info.innerHTML=card;
			}
        },
        error: function(httpObj, textStatus) {
			var info = document.querySelector('#twit-post');
			var card="<div class='card p-25'><h1> Oops, something was wrong with server :(!</h1></div>";
				info.innerHTML=card;
            alert("Oops, something went wrong!");
        }

    });
debugger;
	$.ajax({
        url: "/check-twitter-user/get/user/feedback",
        type: "GET",
        dataType: 'html',
        success: function(re) {
            // console.log(data);
			var data=JSON.parse(re);
			console.log(data);
			var rows="";
				data.forEach(element =>rows=rows+" <tr><td>"+element.id+"</td><td>"+(element.check_status?"yes":"no")+"</td><td>"+element.feedback+"</td></tr>");
			var tableDAta="	<div class='card'><table><tr><th>id</th><th>is my accont</th><th>feedback</th></tr>"+rows+"</table><div>";
			var table = document.querySelector('#table');
			table.innerHTML=tableDAta;
        },
        error: function(httpObj, textStatus) {
            // alert("Oops, something went wrong!");
        }
    });

	
    </script>
   

</body>


</html>