<?php
class Element {

	public static function link($title, $url, $alt = "") {
		return "<a title='$alt' class='link' href='$url'>$title</a>";
	}

	public static function tag($str) {
		return "<span style='margin: 1px; padding: 1px' class='ui-widget-content ui-corner-all'>".$str."</span>";
	}

	public static function clickShow($title, $url, $largura=400, $altura=300, $icon="") {
		$ic = $icon;
		if ($ic == "")
			$ic = Icons::DETAIL;
		return "<span class='click-show' onmouseover='$(this).attr(\"class\",\"click-show-mouse\")' onmouseout='$(this).attr(\"class\",\"click-show\")' onclick='Popover.show(\"" . $url . "\",$largura,$altura)'>$ic $title</span>";
	}

	public static function image($url, $title="", $size="") {
		$st = "";
		if ($size!="") {
			$st = " style='width: $size' ";
		}
		return "<img src='" . $url . "' title='" . $title . "' $st />";
	}

	public static function headBlock() {
		$out = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n" .
				"<title>" . SYS_TITLE . "</title>" .
				"<link href=\"../css/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n" .
				"<link href=\"../css/".SIS_TEMA_JQUERY."/jquery-ui.css\" rel=\"stylesheet\" type=\"text/css\"/>\n" .
				"<link href=\"../css/jquery.message.css\" rel=\"stylesheet\" type=\"text/css\"/>\n" .
				"<link href=\"../inc/js/jquery.ui.stars/jquery.ui.stars.min.css\" rel=\"stylesheet\" type=\"text/css\"/>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/jquery-1.8.2.min.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/jquery-ui-1.9.0.min.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/jquery.ui.stars/jquery.ui.stars.min.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/jquery.message.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/jquery.simplemodal.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/jquery.maskedinput-1.3.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/jquery.checkbox.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/jquery.uitablefilter.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/jquery-ui-timepicker-addon.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/validate/jquery.validate.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/validate/messages_ptbr.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/validate/additional-methods.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/core.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/jquery.ui.datepicker-pt-BR.js\"></script>\n" .
				"<link href=\"../css/superfish/superfish.css\" rel=\"stylesheet\" type=\"text/css\"/>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/superfish/hoverIntent.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/superfish/superfish.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/superfish/supersubs.js\"></script>\n" .
				"<script type=\"text/javascript\" src=\"../inc/js/jquery.placeholder.min.js\"></script>\n" .
				"<link href=\"../custom/mystyle.css\" rel=\"stylesheet\" type=\"text/css\"/>\n" .
				"<script type=\"text/javascript\" src=\"../custom/myjavascript.js\"></script>\n";

		$out .= "<script type=\"text/javascript\">\n" .
				"$(function() {\n" .
				"$.datepicker.setDefaults( $.datepicker.regional[ \"pt-BR\" ] );\n" .
				"});\n" .
				"</script>\n";

		$out .= "<script type=\"text/javascript\">\n" .
				"$(function() {\n" .
				"if ($(\"#menu\").is(\":visible\")) {" .
				"$(\"#menu\").load(\"".SIS_MENU."\", function(){" .
				"$('ul.sf-menu').superfish();" .
				"});" .
				"}" .
				"});\n" .
				"</script>\n";
		echo $out;
	}

	public static function loadRichTextEditor() {
		$out = "<script type=\"text/javascript\" src=\"../inc/js/ckeditor/ckeditor.js\"></script>\n";
		$out .= "<script type=\"text/javascript\" src=\"../inc/js/ckeditor/adapters/jquery.js\"></script>\n";
		$out .= "<script type=\"text/javascript\">\n" .
				"$(function() {\n" .
				"var config = { toolbar: [".
									"{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },".
									"{ name: 'clipboard', items : [ 'Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },".
									"{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent' ] },".
									"{ name: 'links', items : [ 'Link','Unlink' ] },".
									"{ name: 'insert', items : [ 'Table','SpecialChar' ] },".
									"{ name: 'tools', items : [ 'Maximize' ] },".
									"{ name: 'document',    items : [ 'Source' ] }".
								"], toolbarCanCollapse : false, removePlugins : 'elementspath' };" .
				"$('.richtexteditor').ckeditor(config);\n" .
				"});\n" .
				"</script>\n";
		echo $out;
	}

	public static function scrollBlock($content = "", $height = "300px", $theWidth = "100%") {
		$out = "<div style='background-color: #FFFFFF; height: $height; width: $theWidth; ";
		$out .= "overflow: auto; border: 0px; padding: 1px;'>";
		$out .= $content;
		$out .= "</div>";
		return $out;
	}

	public static function placeHolder($id, $valorInicial = "") {
		return "<span id='" . $id . "'>$valorInicial</span>";
	}

	public static function label($id, $valorInicial = "") {
		return "<label for='" . $id . "'>$valorInicial</label>";
	}

	public static function criaXML($valor, $mensagem="", $sucesso="true") {
		return "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n" .
				"<ajax>\n" .
				"<mensagem><![CDATA[$mensagem]]></mensagem>\n" .
				"<sucesso>$sucesso</sucesso>\n" .
				"<valor><![CDATA[$valor]]></valor>\n" .
				"</ajax>\n";
	}

	public static function hint($texto) {
		return " <div onmouseover='$(this).addClass(\"ui-state-hover\");showhint(this, \"" . $texto . "\");' style='vertical-align: top; height: 21px; width: 23px; cursor: pointer;' class='ui-button ui-state-default ui-corner-all'><span style='margin: 3px;' class='ui-icon ui-icon-help'></span></div>";
	}

	public static function header($pagetitle="Página sem nome") {
		if (strlen(Security::getUser()) > 0) {
			$info = "Usuário: " . strtoupper(Security::getUser()) . "&nbsp;&nbsp;&nbsp;[<a href='../common/sair.php'> sair </a>]";
		} else {
			$info = "Usuário não conectado [<a href='../common/login.php'> entrar </a>]";
		}
		$out = "<div id=\"header\" class=\"ui-widget-header\"><div id=\"header-title\">" . SYS_TITLE . "</div><div id=\"header-info\">" . $info . "</div></div>" .
				"<div id=\"menu\"></div>" .
				"<div id=\"titulo-pagina\" class=\"ui-state-default\">" . $pagetitle . "</div>" .
				"<div id=\"dialog-confirm\" title=\"\"><p></p></div><span id='div-loading'><img src='../img/ajax-loader.gif' /></span>";
		echo $out;
	}

	public static function headerLov($pagetitle="Página sem nome") {
		$out = "<div id=\"header\" style=\"display: none;\">" . SYS_TITLE . "</div>" .
				"<div id=\"menu\" style=\"display: none;\"></div>" .
				"<div id=\"titulo-pagina\" class=\"ui-state-default\">" . $pagetitle . "</div>" .
				"<div id=\"dialog-confirm\" title=\"\"><p></p></div><span id='div-loading'><img src='../img/ajax-loader.gif' /></span>";
		echo $out;
	}

	public static function h3($title) {
		echo "<h3 class='h3'>".$title."</h3>";
	}

	public static function div($id, $content="") {
		echo "<div id='$id'>$content</div>";
	}

	public static function iframe($id, $url="") {
		echo "<iframe id='".$id."' name='".$id."' src='".$url."' height='0' width='0' style='border:0' />";
	}

}
