<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="{{ url('api/curl3')}}" enctype="multipart/form-data" method="post">
	@csrf
		<input type="file" name="name">
		<input type="submit" value="添加">
	</form>
</body>
</html> 