<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Optional theme --><!--
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<style>
			/* Sticky footer styles
		-------------------------------------------------- */
		html {
		position: relative;
		min-height: 100%;
		}
		body {
		/* Margin bottom by footer height */
		margin-bottom: 60px;
		}
		.footer {
		position: absolute;
		bottom: 0;
		width: 100%;
		/* Set the fixed height of the footer here */
		height: 60px;
		background-color: #f5f5f5;
		}
		/* Custom page CSS
		-------------------------------------------------- */
		/* Not required for template or sticky footer method. */
		.container {
		width: auto;
		max-width: 680px;
		padding: 0 15px;
		}
		.container .text-muted {
		margin: 20px 0;
		}
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<h1>{{ $task->body }}</h1>
			<br/>
			<br/>
			<a href="/tasks">Tilbake</a>
			<br/>
			<br/>
			<a href="/tasks/{{$task->id}}/edit">Edit</a>
			<br/>
			<br/>
			<!--<button class="btn btn-danger">Delete task</button>-->
			<button type="button-btn" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm">Delete task</button>
			{{ Form::model($task, array('route' => array('delete', $task->id), 'method' => 'DELETE')) }}
			<div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Er du sikker på at du vil slette task?</h4>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-danger">Delete</button>
						</div>
						</div><!-- /.modal-content -->
					</div>
				</div>
				{{ Form::close() }}
			</div>
			<footer class="footer">
				<div class="container">
					<p class="text-muted">Place sticky footer content here.</p>
				</div>
			</footer>
		</body>
	</html>