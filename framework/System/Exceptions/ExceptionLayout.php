<!DOCTYPE html>
<html>
	<head>
		<title>Fatal error: <?php echo Utility::encodeHTML($this->_getMessage()); ?></title>
		<meta charset="utf-8" />
		<style type="text/css">
			body {
				font-family: Verdana, Helvetica, sans-serif;
				font-size: 0.8em;
			}

			div {
				border: 1px outset lightgrey;
				padding: 3px;
				background-color: lightgrey;
			}
			
			div div {
				border: 1px inset lightgrey;
				padding: 4px;
			}

			code {
				font-family: Verdana, Helvetica, sans-serif;
				font-size: 0.8em;
			}
			
			h1 {
				background-color: #154268;
				padding: 4px;
				color: #fff;
				margin: 0 0 3px 0;
				font-size: 1.15em;
			}
			h2 {
				font-size: 1.1em;
				margin-bottom: 0;
			}
			
			pre, p {
				margin: 0;
			}
		</style>
	</head>
	<body>
		<div>
			<h1>Fatal error: <?php if(!$this->getExceptionID()) { ?>Unable to write log file, please make &quot;<?php echo Utility::unifyDirSeparator(SYS_DIR); ?>log/&quot; writable!<?php } else { echo Utility::encodeHTML($this->_getMessage()); } ?></h1>
					
			<?php if (System::debugModeIsEnabled()) { ?>
				<div>
					<?php if ($this->getDescription()) { ?><p><br /><?php echo $this->getDescription(); ?></p><?php } ?>
					
					<h2>Information:</h2>
					<p>
						<b>id:</b> <code><?php echo $this->getExceptionID(); ?></code><br>
						<b>error message:</b> <?php echo Utility::encodeHTML($this->_getMessage()); ?><br>
						<b>error code:</b> <?php echo intval($e->getCode()); ?><br>
						<?php echo $this->information; ?>
						<b>file:</b> <?php echo Utility::encodeHTML($e->getFile()); ?> (<?php echo $e->getLine(); ?>)<br>
						<b>php version:</b> <?php echo Utility::encodeHTML(phpversion()); ?><br>
						<b>framework version:</b> <?php echo FRAMEWORK_VERSION; ?><br>
						<b>date:</b> <?php echo gmdate('r'); ?><br>
						<b>request:</b> <?php if (isset($_SERVER['REQUEST_URI'])) echo Utility::encodeHTML($_SERVER['REQUEST_URI']); ?><br>
						<b>referer:</b> <?php if (isset($_SERVER['HTTP_REFERER'])) echo Utility::encodeHTML($_SERVER['HTTP_REFERER']); ?><br>
					</p>
					
					<h2>Stacktrace:</h2>
					<pre><?php echo Utility::encodeHTML($this->__getTraceAsString()); ?></pre>
				</div>
			<?php } else { ?>
				<div>
					<h2>Information:</h2>
					<p>
						<?php if (!$this->getExceptionID()) { ?>
							Unable to write log file, please make &quot;<?php echo Utility::unifyDirSeparator(WCF_DIR); ?>log/&quot; writable!
						<?php } else { ?>
							<b>ID:</b> <code><?php echo $this->getExceptionID(); ?></code><br>
							<?php echo $innerMessage; ?>
						<?php } ?>
					</p>
				</div>
			<?php } ?>
			
			<?php echo $this->functions; ?>
		</div>
	</body>
</html>