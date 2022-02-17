<?php session_start()?>
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
		</div>

		<div class="main-body">

			<!-- <div class="card">
				<img class="card-img" src="">
				<div class="card-body">
					<h3>
						<%=films[i].name %>
					</h3>
					<p>

					</p>
					<button class="w-btn">
						<a href="">
							Trailer</a>
					</button>
				</div>
			</div> -->

		</div>
	</div>
	<script>
		var profileImg = document.querySelector('#profile-img');
		var info = document.querySelector('#info');
		profileImg.src = "<?php echo $_SESSION['imgUrl'] ?>";
		info.innerHTML = "<li>wellcom <?php echo($_SESSION['name']) ?> </li> <li></li>  <li>@ <?php echo($_SESSION['userName']) ?></li>";
		
        $.ajax({
            url: "https://api.twitter.com/1.1/users/show.json",
            type: "Get",
            dataType: 'jsonp',
            async: true,
            crossDomain: true,
            contentType: "application/json; charset=UTF-8",
            headers: {
                'Authorization': "you Token"
                ,'Access-Control-Allow-Origin': 'origin-list'

            },
            data: { screen_name: "ahmedhemeda91" },
            success: function (data) {
                // data.
        }, error : function(httpObj, textStatus) {       
                if(httpObj.status==200)
                    alert("success");
                else
                alert("Oops, something went wrong!");
                }
        }); 

	</script>
	<!-- <a href="/users/logout" class="btn btn-secondary">Logout</a> -->

</body>


</html>