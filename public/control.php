<?php

$con = mysqli_connect('127.0.0.1', 'root', '', 'sebore');
if (!$con) {
	echo "DB connection failed";
}

if (isset($_POST['update_t'])) {
	$ref = $_POST['ref_id'];
	$q = $_POST['q'];
	$amount = $_POST['amount'];

	$qur = "UPDATE transactions set quantity = " . $q . ", amount = " . $amount . " where ref_id = " . $ref;
	$res = mysqli_query($con, $qur);

	if ($res) {
		echo "<script>alert('Congratulations, You have successfully Updated transaction(" . $ref . ")')</script>";
	} else {
		echo "<script>alert('Can not update this record now, Contact Mukeey @ +2348167236629 (For support)')</script>";
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Control Page</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<script>
		var testV = 1;
		var pass1 = prompt('Please Enter Your Password', ' ');
		while (testV < 3) {
			if (!pass1) {
				alert('Invalid Password');
				history.go(-1)
			};
			if (pass1.toLowerCase() == "@201117") {
				alert('You Got it Right! Click Ok To Enter....');
				// window.open('protectpage.html');
				break;
			}
			testV += 1;
			var pass1 = prompt('Access Denied - Password Incorrect, Please Try Again.', 'Password');
		}
		if (pass1.toLowerCase() != "password" & testV == 3) history.go(-1);


		// Diseble inspect
		document.addEventListener('keydown', function() {
			if (event.keyCode == 123) {
				alert("You Can not Do This!");
				return false;
			} else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
				alert("You Can not Do This!");
				return false;
			} else if (event.ctrlKey && event.keyCode == 85) {
				alert("You Can not Do This!");
				return false;
			}
		}, false);

		if (document.addEventListener) {
			document.addEventListener('contextmenu', function(e) {
				alert("You Can not Do This A!");
				e.preventDefault();
			}, false);
		} else {
			document.attachEvent('oncontextmenu', function() {
				alert("You Can not Do This B!");
				window.event.returnValue = false;
			});
		}
	</script>
	<style>
		html,
		body {
			display: block;
			justify-content: center;
			font-family: Roboto, Arial, sans-serif;
			font-size: 15px;
		}

		form {
			border: 5px solid #f1f1f1;
		}

		input[type=text],
		input[type=password] {
			width: 100%;
			padding: 16px 8px;
			margin: 8px 0;
			display: inline-block;
			border: 1px solid #ccc;
			box-sizing: border-box;
		}

		button {
			background-color: #8ebf42;
			color: white;
			padding: 14px 0;
			margin: 10px 0;
			border: none;
			cursor: grabbing;
			width: 100%;
		}

		h1 {
			text-align: center;
			fone-size: 18;
		}

		button:hover {
			opacity: 0.8;
		}

		.formcontainer {
			text-align: left;
			margin: 18px 40px 8px;
		}

		.container {
			padding: 10px 0;
			text-align: left;
		}

		span.pass {
			float: right;
			padding-top: 0;
			padding-right: 15px;
		}
	</style>
</head>

<body>

	<?php
	if (isset($_GET['ref_id'])) {
		$ref = $_GET['ref_id'];

		// Perform 
		$query =  "SELECT * FROM transactions WHERE ref_id =" . $ref;
		$result = mysqli_query($con, $query);

		if ($row = $result->fetch_assoc()) {
	?>
			<form action="" method="post">
				<h1>Transaction Record</h1>
				<div class="formcontainer">
					<p>Customer: <?php echo $row['customer_id']; ?></p>
					<hr />
					<p>Agent: <?php echo $row['agent_id']; ?></p>
					<hr />
					<p>Item: <?php echo $row['item_id']; ?></p>
					<hr />
					<p>Organization: <?php echo $row['org_id']; ?></p>
					<hr />
					<div class="container">
						<label for="ref_id"><strong>Ref_id</strong></label>
						<input type="text" disabled placeholder="Enter ref_id">
						<input type="hidden" value="<?php echo $row['ref_id']; ?>" name="ref_id" required>
					</div>
					<hr />
					<div class="container">
						<label for="q"><strong>Quantity</strong></label>
						<input type="text" placeholder="Enter quantity" value="<?php echo $row['quantity']; ?>" name="q" required>
					</div>
					<hr />
					<div class="container">
						<label for="amount"><strong>Amount</strong></label>
						<input type="text" placeholder="Enter Amount" name="amount" value="<?php echo $row['amount']; ?>" required>
					</div>
					<button type="submit" name="update_t">Update Record</button>
				</div>
			</form>

			<br><br>
	<?php
		} else {
			echo "<script>alert('No data found')</script>";
		}
	}
	?>

	<form action="" method="GET">
		<h1>Transaction</h1>
		<div class="formcontainer">
			<hr />
			<div class="container">
				<label for="ref_id"><strong>Ref_id</strong></label>
				<input type="text" placeholder="Enter ref_id" name="ref_id" required>
			</div>
			<button type="submit" name="get_t">Get Info</button>
		</div>
	</form>


</body>

</html>
