/******************************************************************** 
 * Comportamento e configurações globais da aplicação
 * Só mexa nesse arquivo se souber exatamente o que está fazendo
 ********************************************************************/


$(document).ready(function() {
	// define o efeito de "loading"
	$('#div-loading').hide().ajaxStart(function() {
		$(this).show();
	}).ajaxStop(function() {
		$(this).hide();
	});
				
	// define a aparência dos botões
	$("input[type=button]").button();
	$("button").button();
	$(".radio-h").buttonset();

	// recalcula a área de scroll
	resizeWindow();
	$(window).resize(function(){
		resizeWindow();
	});
	
	// define a aparência dos campos
	$("input[type=text],input[type=password],textarea,select").addClass("ui-widget-content ui-corner-all form-font");
	
	// configura os campos do tipo checkbox
	$(".div-form .checkbox").checkbox({
		disabled: null,
		text: false,
		label: null,
		icons: {
			on: 'ui-icon-check',
			off: 'ui-icon-minus'
		}
	});
	$(".checkbox-label").checkbox({
		disabled: null,
		text: true,
		label: null,
		icons: {
			on: 'ui-icon-check',
			off: 'ui-icon-minus'
		}
	});

	// define as abas
	$(".memory-tabs").tabs();
	
	// accordion
	$(".accordion").accordion({
		autoHeight: false,
		navigation: true
	});
	
	// multiaccordion
	$(".multiaccordion").addClass("ui-accordion ui-accordion-icons ui-widget ui-helper-reset")
       .find("h3")
       .addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-corner-bottom")
       .hover(function() { $(this).toggleClass("ui-state-hover"); })
       .prepend('<span class="ui-icon ui-icon-triangle-1-e"></span>')
       .click(function() {
          $(this)
           .toggleClass("ui-accordion-header-active ui-state-active ui-state-default ui-corner-bottom")
           .find("> .ui-icon").toggleClass("ui-icon-triangle-1-e ui-icon-triangle-1-s").end()
           .next().toggleClass("ui-accordion-content-active").slideToggle('fast');
          return false;
       })
       .next()
       .addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom")
       .css("display", "block")
       .hide()
       .end();
	
	$('input[placeholder], textarea[placeholder]').placeholder();
	
});



var tableHighlight = false;

// função para recalcular a área de scroll /////////////////////////////////////////////////////////////////////////////////
function resizeWindow() {
	var altMenu = 0;
	var altHeader = 0;
	if ($('#menu').is(":visible")) altMenu = $('#menu').outerHeight();
	if ($('#header').is(":visible")) altHeader = $('#header').outerHeight();
	var alturaDiff = (altHeader+altMenu+$('#titulo-pagina').outerHeight()+$('#acoes').outerHeight()+$('#dados').outerHeight()) - $('#dados').height();
	$("#dados").css({
		'height':($(window).height()-alturaDiff)+'px'
	});
}

// Função auxiliar para manipular forms e listas ////////////////////////////////////////////////////////////////////////////
var FormUtil = {
	
	// Marca/desmarca todos os checkboxes da tabela
	checkAll: function(id) {
		var ipts = $("#"+id).find("td input");
		var val = $('input[name=checkall]').is(':checked');
		$.each(ipts, function(){
			$(this).attr('checked', val);
			if (tableHighlight) {
				if ($(this).attr('checked')=='checked') {
					$(this).parent().parent().addClass('ui-state-highlight');
				} else {
					$(this).parent().parent().removeClass('ui-state-highlight');
				}
			}
		} );
	}
}

// Funções para manipulação de botões /////////////////////////////////////////////////////////////////////////////////////
var Buttons = {
	mapEnterKey: function(trigger) {
		$(document).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				eval("$('#"+trigger+"').click()");
			}
		});
	},
	disable: function() {
		$('#acoes :input').attr('disabled', true);
	},
	enable: function() {
		$('#acoes :input').removeAttr('disabled');
	}
}

// textCounter para o TEXTAREA ////////////////////////////////////////////////////////////////////////////////
function textCounter(field, countfield, maxlimit){
	var len = $('#'+field).val().length;
	if (len > maxlimit) {
		v = $('#'+field).val();
		$('#'+field).val(v.substring(0, maxlimit));
	} else {
		$('#'+countfield).text(maxlimit - len);
	}
}

// Popup de LOV ////////////////////////////////////////////////////////////////////////////////////////////////
function lov(paginaLov, nome_campo, largura, crit) {
	if (crit == null) {
		crit = '';
	} else {
		crit = '&'+crit;
	}
	if (largura == null) {
		largura = 350;
	}
	iframePopup.open(paginaLov+'?nome_campo='+nome_campo+crit, largura, 520);
}

// Popup de MLOV ///////////////////////////////////////////////////////////////////////////////////////////////
function lovm(paginaLov, largura) {
	if (largura == null) {
		largura = 350;
	}
	iframePopup.open(paginaLov,largura,520);
}


// hint /////////////////////////////////////////////////////////////////////////////////////////////////
var hintcontainer = null;

function showhint(obj, txt) {
	if (hintcontainer == null) {
		hintcontainer = document.createElement("div");
		hintcontainer.className = "hintstyle ui-state-highlight ui-corner-all"; //hintstyle 
		document.body.appendChild(hintcontainer);
	}
	obj.onmouseout = hidehint;
	obj.onmousemove = movehint;
	hintcontainer.innerHTML = txt;
}
function movehint(e) {
	if (!e) e = event;
	hintcontainer.style.top = (e.clientY+document.documentElement.scrollTop+2)+"px";
	hintcontainer.style.left = (e.clientX+document.documentElement.scrollLeft+10)+"px";
	hintcontainer.style.display = "";
}
function hidehint() {
	hintcontainer.style.display = "none";
	$(".ui-state-hover").removeClass("ui-state-hover");
}

// Mensagens na camada client //////////////////////////////////////////////////////////////////////////////
var Messages = {
	success: function(msg) {
		var t;
		if ($("#appmsg-container").is(":visible")) {
			$("#appmsg-container").remove();
		}
		$("#dados").before("<div id='block-appmsg'><div id='appmsg-container'><div id='appmsg' class='ui-state-highlight ui-corner-all'>"+msg+"</div></div></div>");
		clearTimeout(t);
		t = setTimeout(function() {
			$('#appmsg-container').remove();
		}, 5000);
	},
	error: function(msg) {
		if ($("#appmsg-container").is(":visible")) {
			$("#appmsg-container").remove();
		}
		$("#dados").before("<div id='block-appmsg'><div id='appmsg-container'><div id='appmsgerror' class='ui-state-error ui-corner-all'>"+msg+"</div></div></div>");
	}
}

// Dialogos de alerta e confirmação //////////////////////////////////////////////////////////////////////////
var Dialog = {
	alert: function(msg, titulo) {
		var t = 'Atenção';
		if (titulo != null) {
			t = titulo;
		}
		$("#dialog-confirm p").html(msg);
		$("#dialog-confirm" ).dialog({
			modal: true,
			title: t,
			resizable: false,
			width: 400,
			height: 200,
			buttons: {
				Ok: function() {
					$(this).dialog("close");
				}
			}
		});
	},
	confirm: function(msg, f, titulo) {
		var t = 'Confirmação';
		if (titulo != null) {
			t = titulo;
		}
		$("#dialog-confirm p").html(msg);
		$("#dialog-confirm").dialog({
			resizable: false,
			height: 200,
			width: 400,
			modal: true,
			title: t,
			buttons: {
				"Ok": function() {
					f();
					$(this).dialog("close");
				},
				"Cancelar": function() {
					$(this).dialog("close");
				}
			}
		});
	}
}

// Janela auxiliar /////////////////////////////////////////////////////////////////////////////////////////////////////////////
function popup(pagina, largura, altura) {
	newWindow = window.open(pagina,'newWin','toolbar=no,location=no,scrollbars=yes,resizable=no,width='+largura+',height='+altura+',top=100,left=150');
}

// Janela auxiliar virtual (div) com iframe dentro  ////////////////////////////////////////////////////////////////////////////
var iframePopup = {
	open: function (pagina, largura, altura) {
		$.modal('<iframe src="' + pagina + '" height="'+altura+'" width="'+largura+'" style="border:0">', {
			closeHTML:"",
			containerCss:{
				backgroundColor:"#FFFFFF",
				borderColor: "#000000",
				height: altura+5,
				padding: 10,
				width: largura
			},
			overlayCss: {
				backgroundColor:"#000000"
			},
			opacity:40,
			overlayClose:false,
			escClose: false,
			onOpen: function (dialog) {
				dialog.overlay.fadeIn('fast', function () {
					dialog.container.slideDown('fast', function () {
						dialog.data.fadeIn('fast');
					});
				});
			},
			onClose: function (dialog) {
					dialog.data.fadeOut('fast', function () {
						dialog.container.slideUp('fast', function () {
							dialog.overlay.fadeOut('fast', function () {
								$.modal.close();
							});
						});
					});
				}
		});
	},
	close: function() {
		top.$.modal.close();
	},
	reload: function() {
		top.location.reload();
	}
}

// Popup com conteúdo ajax via URL /////////////////////////////////////////////////////////////////////////////////////////////
var Popover = {
	show: function(url, largura, altura) {
		$.get(url, function(data){
			$.modal(data, {
				closeHTML:"<div class='popover-fechar'></div>",
				containerCss:{
					backgroundColor:"#FFFFFF",
					borderColor: "#000000",
					padding: 10,
					width: largura,
					height: altura+5
				},
				overlayCss: {
					backgroundColor:"#000000"
				},
				opacity:20,
				overlayClose:true,
				escClose: true,
				autoResize: false,
				onOpen: function (dialog) {
					dialog.overlay.fadeIn('fast', function () {
						dialog.container.slideDown('fast', function () {
							dialog.data.fadeIn('fast');
						});
					});
				},
				onClose: function (dialog) {
					dialog.data.fadeOut('fast', function () {
						dialog.container.slideUp('fast', function () {
							dialog.overlay.fadeOut('fast', function () {
								$.modal.close();
							});
						});
					});
				}
			});
		});
	}
}

// Manipulação de tabelas ////////////////////////////////////////////////////////////////////////////////////////////////
var Tables = {
	
	setHighlightOnHover: function(x) {
		if (x) {
			$('.div-table tr').hover(function() {
				$(this).addClass('highlight-mouse');
			}, function() {
				$(this).removeClass('highlight-mouse');
			});
		}
	},
	setHighlightOnSelect: function(x) {
		tableHighlight = x;
		if (x) {
			$('.div-table table .checkbox input').click(function(e) {
				if (e.target.type == 'checkbox') {
					$(this).parent().parent().toggleClass('ui-state-highlight');
				}
			});
			$('.div-table table input[type=radio]').click(function(e) {
				if (e.target.type == 'radio') {
					var ipts = $('.div-table table').find("input");
					$.each(ipts, function(){
						$(this).parent().parent().removeClass('ui-state-highlight');
					} );
					$(this).parent().parent().addClass('ui-state-highlight');
				}
			});			
			
		}		
	},
	showFilter: function(theTable) {
		// cria campo
		$("#acoes").append("<input id='filterField' type='text' placeholder='filtro' value='' class='ui-widget-content ui-corner-all form-font' style='float:right; margin-top: 4px' />");
		// aplica evento
		$("#filterField").keyup(function() {
			var t = $("#"+theTable+" table");
			$.uiTableFilter(t, $("#filterField").val());
		});
	}
}

// Funções para exibir/esconder uma DIV ////////////////////////////////////////////////////////////////////////////////////////
function foldingShowHide(obj, url) {
	var el = $('#'+obj+"_content");
	if (el.css("display") == 'block') {
		el.slideUp('fast', function() {
			$('#'+obj+'_imgfld').attr('src','../img/icons/bullet_mais.gif');
		});
	} else {
		$('#'+obj+'_content').load(url, function() {
			el.slideDown('fast', function() {
				$('#'+obj+'_imgfld').attr('src','../img/icons/bullet_menos.gif');
			});			
		});

	}
}
function divShowHide(obj) {
	var el = $('#'+obj);
	if (el.css("display") == 'block') {
		el.slideUp('fast');
	} else {
		el.slideDown('fast');
	}
}

function expandCriteria() {
	divShowHide("more-text");
}

// Manipulação de valores no componente LOV ////////////////////////////////////////////////////////////////////////////////////
var Lov = {
	getSelectedValue: function() {
		return $("input[name='sel']:checked").val();
	},
	isSelected: function() {
		return (typeof(Lov.getSelectedValue()) != 'undefined');
	},
	getLabel: function() {
		return $('#dummy_'+Lov.getSelectedValue()).html();
	},
	transfer: function(campo) {
		var campoDummy = campo+'Dummy';
		top.$("#"+campo).val(Lov.getSelectedValue());
		top.$("#"+campoDummy).val(Lov.getLabel());
	}
	
	
}

// Manipulação de valores no componente ListboxLov ////////////////////////////////////////////////////////////////////////////
var ListboxLov = {
	transfer: function(nomeCampo) {
		//$("input[name=sel[]]:checked").each(
		$("tbody input[type=checkbox]:checked").each(
			function(index, element) {
				var id = $(element).val();
				var label = $("#dummy_" + id).html();
				top.$('#'+nomeCampo).append($("<option></option>").attr("value",id).text(label)); 
			});
		ListboxLov._removeDuplicated(nomeCampo);
	},
	_removeDuplicated: function(nomecampo) {
		var usedNames = {};
		top.$("#"+nomecampo+" > option").each(function () {
			if (usedNames[this.text]) {
				$(this).remove();
			} else {
				usedNames[this.text] = this.value;
			}
		});
	},
	removeSelected: function(nomeCampo) {
		$("#" + nomeCampo + " option:selected").each(function(){
			$(this).remove();
		});  
	},
	selectAll: function(nomeCampo) {
		top.$("select[name='"+nomeCampo+"[]'] > option").each(function () {
			$(this).attr("selected",true);
		});
	}
}