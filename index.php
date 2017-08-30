<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <title>Gestión Integración></title>
      

        <link rel="stylesheet" href="css/style.css" />

		<link rel="stylesheet" href="css/jquery.mobile-1.3.1.min.css" />
		<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="https://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>

		<style>
		div.ui-input-text { width: 100% !important }
		.ui-field-contain .ui-controlgroup-controls {
    display: inline-block;
    width: 100%;
}
		</style>
    </head>
    <body id="login">

        <div data-role="page" id="page1">

            <div data-role="content">

                <h1 class="textcenter">Bienvenido a Gestión Integración</h1>

                <div class="login">
					<form action="administrador.php" method="post" encType="multipart/form-data">
						<div data-role="fieldcontain">
							<fieldset data-role="controlgroup" data-mini="true">
								<label for="textinput1">User</label>
								<input name="usuario" id="textinput1" type="text" />
							</fieldset>
						</div>
						<div data-role="fieldcontain">
							<fieldset data-role="controlgroup" data-mini="true">
								<label for="textinput2">Password</label>
								<input name="clave" id="textinput2" type="password" />
							</fieldset>
						</div>
						<input data-theme="b" value="Submit" data-mini="true" type="submit" class="ui-custom-btn"/>
					</form>
				</div>
            </div>
        </div>
    </body>
</html>