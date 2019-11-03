<?php



function str_lreplace($search, $replace, $subject)
{
	return preg_replace('~(.*)' . preg_quote($search, '~') . '(.*?)~', '$1' . $replace . '$2', $subject, 1);
}




if (isset($_POST['type']) && isset($_POST['pattern'])) {
	extract($_POST);
	//flags limit modifiers offset pattern replacement subject type


	$flagsInt=0;
	if (strpos($flags,'PREG_OFFSET_CAPTURE')!==false && strpos($flags,'PREG_PATTERN_ORDER')!==false) $flags='';
	if ($flags) {
		$flagsArray=explode('|',$flags);
		foreach($flagsArray as $flag) {
			$int=constant(trim($flag));
			$flagsInt|=$int;
		}
	}
	$offset=intval($offset);
	if (!$limit) $limit=-1;
	$limit=intval($limit);

	$flagsText=$offsetText=$limitText='';
	if ($flags) $flagsText=", $flags";
	if ($offset) $offsetText=", $offset";
	if ($limit>0) $limitText=", $limit";
	$pl=-1;

	//$subject=str_replace("\r",'',$subject);

	if (preg_match("/^#.+#([imsxADSUXu]+)$/",$pattern,$m)) $modifiers=$m[1];
	else {
		if (!preg_match("/^#.+#$/",$pattern)) $pattern="#$pattern#";
		$pattern=$pattern.$modifiers;
	}
	if (!$flags) $flags=0;
	if (strpos($modifiers,'m')!==false) $pattern=preg_replace("/^#/","#(*ANYCRLF)",$pattern,1);
	$patternCode=htmlentities($pattern);


	switch ($type) {
		case 'preg_match_all':
			$r=@preg_match_all("$pattern",$subject,$found,$flagsInt,$offset);
			$code="<b><i>$type</i></b>( <b>'$patternCode'</b> , \$subject , \$m$flagsText$offsetText);";
			break;
		case 'preg_match':
			$r=@preg_match("$pattern",$subject,$found,$flagsInt,$offset);
			$code="<b><i>$type</i></b>( <b>'$patternCode'</b> , \$subject , \$m$flagsText$offsetText);";
			$limit=1;
			break;
		case 'preg_replace':
			$found=@preg_replace("$pattern",$replacement,$subject,$limit);
			$code="<b><i>$type</i></b>( <b>'$patternCode'</b> , '$replacement' , \$subject$limitText);";
			break;
		case 'preg_split':
			$found=@preg_split("$pattern",$subject,$limit,$flagsInt);
			$code="<b><i>$type</i></b>( <b>'$patternCode'</b> , \$subject$limitText$flagsText);";
			break;



		default:
			die();
	}

	//$matches=preg_replace($pattern,"<span class='matches'>\$0</span>",$subject);

	function wtMatchSpan($m) {
		$s=sizeof($m)-1;
		$b=$m[0];
		$r="";
		for ($i=1;$i<=$s;$i++) {
			$p=strpos($b,$m[$i]);
			$l=strlen($m[$i]);
			if ($p!==false) {
				$r.=substr($b,0,$p)."{MATCH_START $i}".$m[$i]."{MATCH_END}";
				$b=substr($b,$p+$l);
				$r.=$b;
			}
			//$t=str_replace($m[$i],"<span class='matches$i'>".$m[$i]."</span>",$b,1);
			//if (preg_match("<span></span>"))
			//$b=preg_replace('~(.*)' . preg_quote($search, '~') . '(.*?)~', '$1' . $replace . '$2', $subject, 1);
			//$r.=
		}
		if (!$r) $r=$b;
		return "{MATCH_START}$r{MATCH_END}";
	}


	$matches=@preg_replace_callback($pattern, 'wtMatchSpan',$subject,$limit);
	$result=print_r($found,true);
	$result=htmlspecialchars($result);
	//$result=nl2br($result);
	$result="<pre>$result</pre>";

	$matches=htmlspecialchars($matches);
	$matches=nl2br($matches);
	$matches=preg_replace("#{MATCH_START (\d+)}#", "<span class='matches\\1' title='\\1'>", $matches);
	$matches=str_replace("{MATCH_START}","<span class='matches'>",$matches);
	$matches=str_replace("{MATCH_END}","</span>",$matches);
	$matches=str_replace("  ",'&nbsp;',$matches);
	$matches=str_replace("\t",'&nbsp;&nbsp;',$matches);

	$r=compact('matches','code','result','pattern');
	$r=json_encode($r);
	die($r);
}



?>
<!DOCTYPE html><html><head><head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="language" content="en">
		<title>WinNMP Regular Expression Tester</title>
		<script type="text/javascript" src="prototype.js"></script>
		<link href="/tools/style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript">


			if(typeof(Control) == 'undefined')
				var Control = {};
			Control.Tabs = Class.create();
			Object.extend(Control.Tabs,{
				instances: [],
				findByTabId: function(id){
					return Control.Tabs.instances.find(function(tab){
						return tab.links.find(function(link){
							return link.key == id;
						});
					});
				}
			});
			Object.extend(Control.Tabs.prototype,{
				initialize: function(tab_list_container,options){
					this.activeContainer = false;
					this.activeLink = false;
					this.containers = $H({});
					this.links = [];
					Control.Tabs.instances.push(this);
					this.options = {
						beforeChange: Prototype.emptyFunction,
						afterChange: Prototype.emptyFunction,
						hover: false,
						linkSelector: 'li a',
						setClassOnContainer: false,
						activeClassName: 'active',
						defaultTab: 'first',
						autoLinkExternal: true,
						targetRegExp: /#(.+)$/,
						showFunction: Element.show,
						hideFunction: Element.hide
					};
					Object.extend(this.options,options || {});
					(typeof(this.options.linkSelector == 'string')
						? $(tab_list_container).getElementsBySelector(this.options.linkSelector)
						: this.options.linkSelector($(tab_list_container))
					).findAll(function(link){
						return (/^#/).exec(link.href.replace(window.location.href.split('#')[0],''));
					}).each(function(link){
						this.addTab(link);
						}.bind(this));
					this.containers.values().each(this.options.hideFunction);
					if(this.options.defaultTab == 'first')
						this.setActiveTab(this.links.first());
					else if(this.options.defaultTab == 'last')
						this.setActiveTab(this.links.last());
						else
							this.setActiveTab(this.options.defaultTab);
					var targets = this.options.targetRegExp.exec(window.location);
					if(targets && targets[1]){
						targets[1].split(',').each(function(target){
							this.links.each(function(target,link){
								if(link.key == target){
									this.setActiveTab(link);
									throw $break;
								}
								}.bind(this,target));
							}.bind(this));
					}
					if(this.options.autoLinkExternal){
						$A(document.getElementsByTagName('a')).each(function(a){
							if(!this.links.include(a)){
								var clean_href = a.href.replace(window.location.href.split('#')[0],'');
								if(clean_href.substring(0,1) == '#'){
									if(this.containers.keys().include(clean_href.substring(1))){
										$(a).observe('click',function(event,clean_href){
											this.setActiveTab(clean_href.substring(1));
											}.bindAsEventListener(this,clean_href));
									}
								}
							}
							}.bind(this));
					}
				},
				addTab: function(link){
					this.links.push(link);
					link.key = link.getAttribute('href').replace(window.location.href.split('#')[0],'').split('/').last().replace(/#/,'');
					this.containers[link.key] = $(link.key);
					link[this.options.hover ? 'onmouseover' : 'onclick'] = function(link){
						if(window.event)
							Event.stop(window.event);
						this.setActiveTab(link);
						return false;
					}.bind(this,link);
				},
				setActiveTab: function(link){
					if(!link)
						return;
					if(typeof(link) == 'string'){
						this.links.each(function(_link){
							if(_link.key == link){
								this.setActiveTab(_link);
								throw $break;
							}
							}.bind(this));
					}else{
						this.notify('beforeChange',this.activeContainer);
						if(this.activeContainer)
							this.options.hideFunction(this.activeContainer);
						this.links.each(function(item){
							(this.options.setClassOnContainer ? $(item.parentNode) : item).removeClassName(this.options.activeClassName);
							}.bind(this));
						(this.options.setClassOnContainer ? $(link.parentNode) : link).addClassName(this.options.activeClassName);
						this.activeContainer = this.containers[link.key];
						this.activeLink = link;
						this.options.showFunction(this.containers[link.key]);
						this.notify('afterChange',this.containers[link.key]);
					}
				},
				next: function(){
					this.links.each(function(link,i){
						if(this.activeLink == link && this.links[i + 1]){
							this.setActiveTab(this.links[i + 1]);
							throw $break;
						}
						}.bind(this));
					return false;
				},
				previous: function(){
					this.links.each(function(link,i){
						if(this.activeLink == link && this.links[i - 1]){
							this.setActiveTab(this.links[i - 1]);
							throw $break;
						}
						}.bind(this));
					return false;
				},
				first: function(){
					this.setActiveTab(this.links.first());
					return false;
				},
				last: function(){
					this.setActiveTab(this.links.last());
					return false;
				},
				notify: function(event_name){
					try{
						if(this.options[event_name])
						return [this.options[event_name].apply(this.options[event_name],$A(arguments).slice(1))];
					}catch(e){
						if(e != $break)
							throw e;
						else
							return false;
					}
				}
			});
			if(typeof(Object.Event) != 'undefined')
				Object.Event.extend(Control.Tabs);






		</script>
	</head>
	<body>


		<script type="text/javascript">





			var execute_time;
			var delay_time = 300;
			var type;

			createClickEvent = function()
			{
				// PCRE
				$('pcre_type_preg_match_all').observe('change', pcreSwap);
				$('pcre_type_preg_match').observe('change', pcreSwap);
				$('pcre_type_preg_replace').observe('change', pcreSwap);
				$('pcre_type_preg_split').observe('change', pcreSwap);

				$('pcre_modifiers_caseless').observe('change', pcre);
				$('pcre_modifiers_multiline').observe('change', pcre);
				$('pcre_modifiers_dotall').observe('change', pcre);
				$('pcre_modifiers_extended').observe('change', pcre);
				$('pcre_modifiers_anchored').observe('change', pcre);
				$('pcre_modifiers_dollar_endonly').observe('change', pcre);
				$('pcre_modifiers_analysis').observe('change', pcre);
				$('pcre_modifiers_ungreedy').observe('change', pcre);
				$('pcre_modifiers_extra').observe('change', pcre);
				$('pcre_modifiers_utf8').observe('change', pcre);

				$('pcre_flags_pattern_order').observe('change', pcre);
				$('pcre_flags_set_order').observe('change', pcre);
				$('pcre_flags_offset_capture').observe('change', pcre);
				$('pcre_flags_split_no_empty').observe('change', pcre);
				$('pcre_flags_split_delim_capture').observe('change', pcre);
				$('pcre_flags_split_offset_capture').observe('change', pcre);

				$('pcre_offset').observe('change', pcre);
				$('pcre_limit').observe('change', pcre);

				// JavaScript
				$('js_type_match').observe('change', jsSwap);
				$('js_type_replace').observe('change', jsSwap);
				$('js_type_split').observe('change', jsSwap);
				$('js_type_search').observe('change', jsSwap);

				$('js_modifiers_caseless').observe('change', js);
				$('js_modifiers_global').observe('change', js);


			}

			pcreSwap = function()
			{
				if ($('pcre_type_preg_match_all').checked)
				{
					$('replacement').readOnly = true;
					$('replacement').addClassName('disabled');
					$('replacement').value = '';

					$('pcre_flags_pattern_order').disabled = false;
					$('pcre_flags_set_order').disabled = false;
					$('pcre_flags_offset_capture').disabled = false;
					$('pcre_flags_split_no_empty').disabled = true;
					$('pcre_flags_split_no_empty').checked = false;
					$('pcre_flags_split_delim_capture').disabled = true;
					$('pcre_flags_split_delim_capture').checked = false;
					$('pcre_flags_split_offset_capture').disabled = true;
					$('pcre_flags_split_offset_capture').checked = false;
					$('pcre_offset').readOnly = false;
					$('pcre_offset').removeClassName('disabled');
					$('pcre_limit').readOnly = true;
					$('pcre_limit').addClassName('disabled');
					$('pcre_limit').value = '';
				}
				else if ($('pcre_type_preg_match').checked)
				{
					$('replacement').readOnly = true;
					$('replacement').addClassName('disabled');
					$('replacement').value = '';

					$('pcre_flags_pattern_order').disabled = true;
					$('pcre_flags_pattern_order').checked = false;
					$('pcre_flags_set_order').disabled = true;
					$('pcre_flags_set_order').checked = false;
					$('pcre_flags_offset_capture').disabled = false;
					$('pcre_flags_split_no_empty').disabled = true;
					$('pcre_flags_split_no_empty').checked = false;
					$('pcre_flags_split_delim_capture').disabled = true;
					$('pcre_flags_split_delim_capture').checked = false;
					$('pcre_flags_split_offset_capture').disabled = true;
					$('pcre_flags_split_offset_capture').checked = false;
					$('pcre_offset').readOnly = false;
					$('pcre_offset').removeClassName('disabled');
					$('pcre_limit').readOnly = true;
					$('pcre_limit').addClassName('disabled');
					$('pcre_limit').value = '';
				}
				else if ($('pcre_type_preg_replace').checked)
				{
					$('replacement').readOnly = false;
					$('replacement').removeClassName('disabled');

					$('pcre_flags_pattern_order').disabled = true;
					$('pcre_flags_pattern_order').checked = false;
					$('pcre_flags_set_order').disabled = true;
					$('pcre_flags_set_order').checked = false;
					$('pcre_flags_offset_capture').disabled = true;
					$('pcre_flags_offset_capture').checked = false;
					$('pcre_flags_split_no_empty').disabled = true;
					$('pcre_flags_split_no_empty').checked = false;
					$('pcre_flags_split_delim_capture').disabled = true;
					$('pcre_flags_split_delim_capture').checked = false;
					$('pcre_flags_split_offset_capture').disabled = true;
					$('pcre_flags_split_offset_capture').checked = false;
					$('pcre_offset').readOnly = true;
					$('pcre_offset').addClassName('disabled');
					$('pcre_offset').value = '';
					$('pcre_limit').readOnly = false;
					$('pcre_limit').removeClassName('disabled');
				}
				else if ($('pcre_type_preg_split').checked)
				{
					$('replacement').readOnly = true;
					$('replacement').addClassName('disabled');
					$('replacement').value = '';

					$('pcre_flags_pattern_order').disabled = true;
					$('pcre_flags_pattern_order').checked = false;
					$('pcre_flags_set_order').disabled = true;
					$('pcre_flags_set_order').checked = false;
					$('pcre_flags_offset_capture').disabled = true;
					$('pcre_flags_offset_capture').checked = false;
					$('pcre_flags_split_no_empty').disabled = false;
					$('pcre_flags_split_delim_capture').disabled = false;
					$('pcre_flags_split_offset_capture').disabled = false;
					$('pcre_offset').readOnly = true;
					$('pcre_offset').addClassName('disabled');
					$('pcre_offset').value = '';
					$('pcre_limit').readOnly = false;
					$('pcre_limit').removeClassName('disabled');
				}

				pcre();
			}

			pcre = function()
			{
				if ($F('pattern') != '')
				{
					type = 'pcre';

					var modifiers = '';

					if ($('pcre_modifiers_caseless').checked)
					{
						modifiers = modifiers + $('pcre_modifiers_caseless').value;
					}
					if ($('pcre_modifiers_multiline').checked)
					{
						modifiers = modifiers + $('pcre_modifiers_multiline').value;
					}
					if ($('pcre_modifiers_dotall').checked)
					{
						modifiers = modifiers + $('pcre_modifiers_dotall').value;
					}
					if ($('pcre_modifiers_extended').checked)
					{
						modifiers = modifiers + $('pcre_modifiers_extended').value;
					}
					if ($('pcre_modifiers_anchored').checked)
					{
						modifiers = modifiers + $('pcre_modifiers_anchored').value;
					}
					if ($('pcre_modifiers_dollar_endonly').checked)
					{
						modifiers = modifiers + $('pcre_modifiers_dollar_endonly').value;
					}
					if ($('pcre_modifiers_analysis').checked)
					{
						modifiers = modifiers + $('pcre_modifiers_analysis').value;
					}
					if ($('pcre_modifiers_ungreedy').checked)
					{
						modifiers = modifiers + $('pcre_modifiers_ungreedy').value;
					}
					if ($('pcre_modifiers_extra').checked)
					{
						modifiers = modifiers + $('pcre_modifiers_extra').value;
					}
					if ($('pcre_modifiers_utf8').checked)
					{
						modifiers = modifiers + $('pcre_modifiers_utf8').value;
					}

					var flags = '';

					if ($('pcre_flags_pattern_order').checked)
					{
						flags = flags + (flags ? ' | ' : '') + $('pcre_flags_pattern_order').value;
					}
					if ($('pcre_flags_set_order').checked)
					{
						flags = flags + (flags ? ' | ' : '') + $('pcre_flags_set_order').value;
					}
					if ($('pcre_flags_offset_capture').checked)
					{
						flags = flags + (flags ? ' | ' : '') + $('pcre_flags_offset_capture').value;
					}
					if ($('pcre_flags_split_no_empty').checked)
					{
						flags = flags + (flags ? ' | ' : '') + $('pcre_flags_split_no_empty').value;
					}
					if ($('pcre_flags_split_delim_capture').checked)
					{
						flags = flags + (flags ? ' | ' : '') + $('pcre_flags_split_delim_capture').value;
					}
					if ($('pcre_flags_split_offset_capture').checked)
					{
						flags = flags + (flags ? ' | ' : '') + $('pcre_flags_split_offset_capture').value;
					}

					new Ajax.Request('reg.php', {
						method: 'post',
						parameters: { 	pattern: $F('pattern'),
							subject: $F('subject'),
							replacement: $F('replacement'),
							type: Form.getInputs('regex','radio','pcre_type').find(function(radio) { return radio.checked; }).value,
							modifiers: modifiers,
							flags: flags,
							offset: $F('pcre_offset'),
							limit: $F('pcre_limit')
						},
						onSuccess: updateJSON
					});
				}
			}

			pcreWait = function()
			{
				var thisdate = new Date();
				var time_ms = thisdate.getTime();

				execute_time = time_ms;

				var t=setTimeout('pcreCheckTime(' + time_ms + ')', delay_time);
			}

			pcreCheckTime = function(time_ms)
			{
				if (execute_time == time_ms)
				{
					pcreSwap();
				}
			}



			jsSwap = function()
			{
				if ($('js_type_replace').checked)
				{
					$('replacement').readOnly = false;
					$('replacement').removeClassName('disabled');
				}
				else
				{
					$('replacement').readOnly = true;
					$('replacement').addClassName('disabled');
					$('replacement').value = '';
				}

				if ($('js_type_search').checked)
				{
					$('js_modifiers_global').checked = false;
					$('js_modifiers_global').disabled = true;
				}
				else
				{
					$('js_modifiers_global').disabled = false;
				}

				js();
			}

			js = function()
			{
				if ($F('pattern') != '')
				{
					type = 'js';

					var matches = '';
					var code = '';
					var result = '';
					var modifiers = '';

					if ($('js_modifiers_caseless').checked)
					{
						modifiers = modifiers + $('js_modifiers_caseless').value;
					}
					if ($('js_modifiers_global').checked)
					{
						modifiers = modifiers + $('js_modifiers_global').value;
					}
					var pattern=$F('pattern');
					console.log(pattern);
					pattern=pattern.replace(/^\//, '' );
					pattern=pattern.replace(/\/[ig]*$/, '' );
					console.log(pattern);
					var re = new RegExp(pattern, modifiers);

					var match = $F('subject').match(re);

					if (match)
					{
						for (var i = 0; i < match.length; i++)
						{
							var re_matches = new RegExp('(' + $F('pattern') + ')', modifiers);
							matches = $F('subject').replace(re_matches, '___START___$1___END___');
						}
					}

					if ($('js_type_match').checked)
					{
						result = match;
						code = 'string.match(' + re + ');'
					}
					else if( $('js_type_replace').checked)
					{
						result = $F('subject').replace(re, $F('replacement'));
						code = 'string.replace(' + re + ', ' + $F('replacement') + ');'
					}
					else if( $('js_type_split').checked)
					{
						result = $F('subject').split(re);
						code = 'string.split(' + re + ');'
					}
					else if( $('js_type_search').checked)
					{
						result = $F('subject').search(re);
						code = 'string.search(' + re + ');'
					}
					matches = matches.escapeHTML();

					matches_re = new RegExp('___START___(.+?)___END___', 'g');
					matches = matches.replace(matches_re, '<span class="matches">$1</span>');

					if (result)
					{
						for (var i = 0; i < result.length; i++)
						{
							result[i] = result[i].escapeHTML();
						}
					}

					$('matches').innerHTML = matches;
					$('code').innerHTML = code.escapeHTML();
					$('result').innerHTML = result;
				}
			}

			jsWait = function()
			{
				var thisdate = new Date();
				var time_ms = thisdate.getTime();

				execute_time = time_ms;

				var t=setTimeout('jsCheckTime(' + time_ms + ')', delay_time);
			}

			jsCheckTime = function(time_ms)
			{
				if (execute_time == time_ms)
				{
					jsSwap();
				}
			}



			loadTabs = function()
			{
				tabs = new Control.Tabs($('menu_tabs'), {defaultTab: 'pcre', afterChange: swapTab});
			}

			updateJSON = function(transport)
			{
				var json = transport.responseText.evalJSON();
				var matches = json.matches;

				$('matches').innerHTML = matches;
				$('code').innerHTML = json.code;
				$('result').innerHTML = json.result;
			}

			swapTab = function(element)
			{
				switch (element.id)
				{
					case 'pcre':
						$('pattern').observe('keyup', pcreWait);
						$('subject').observe('keyup', pcreWait);
						$('replacement').observe('keyup', pcreWait);

						$('pattern').stopObserving('keyup', jsWait);
						$('subject').stopObserving('keyup', jsWait);
						$('replacement').stopObserving('keyup', jsWait);

						$('titlePatternJs').hide();
						$('titlePatternPhp').show();

						pcreSwap();
						break;

					case 'js':
						$('pattern').stopObserving('keyup', pcreWait);
						$('subject').stopObserving('keyup', pcreWait);
						$('replacement').stopObserving('keyup', pcreWait);

						$('pattern').observe('keyup', jsWait);
						$('subject').observe('keyup', jsWait);
						$('replacement').observe('keyup', jsWait);

						$('titlePatternPhp').hide();
						$('titlePatternJs').show();

						jsSwap();
						break;

				}
			}


			document.observe('dom:loaded', loadTabs);
			document.observe('dom:loaded', createClickEvent);

			//]]>
		</script><form id="regex" name="regex" onsubmit="return false;">
			<div id="main">
				<div id="menu">
					<ul class="tabs" id="menu_tabs">
						<li><h2>Regular Expression Tester</h2></li>
						<li><a class="active" href="#pcre">PHP PCRE</a></li>
						<li><a href="#js">JavaScript</a></li>
						<li style="float:right;"><a href="http://localhost">My Projects</a></li>
					</ul>
				</div>
				<div class="evaluator reg">

					<p id="titlePatternPhp"><b>Pattern delimited by '#'</b> (start and end # will be added when needed)</p>
					<p id="titlePatternJs"><b>Pattern delimited by '/'</b> (start and end / will be added when needed)</p>
					<p><input id="pattern" class="box" type="text"></p>
					<p><b>Replacement</b></p>
					<p><input readonly="readonly" id="replacement" class="box disabled" type="text"></p>
					<p><b>Subject</b></p>
					<p><textarea style="height: 150px;" id="subject" class="box"></textarea></p>
					<p><b>Found</b></p>
					<p></p><div id="matches" class="box"></div><p></p>
					<p><b>Code</b></p>
					<p></p><div id="code" class="box"></div><p></p>
					<p><b>Result</b></p>
					<p></p><div id="result" class="box"></div><p></p>
				</div>
				<div id="regWrap">
					<div id="pcre">
						<div class="parameters">
							<p><input name="pcre_type" id="pcre_type_preg_match_all" value="preg_match_all" checked="checked" type="radio"> preg_match_all</p>
							<p><input name="pcre_type" id="pcre_type_preg_match" value="preg_match" type="radio"> preg_match</p>
							<p><input name="pcre_type" id="pcre_type_preg_replace" value="preg_replace" type="radio"> preg_replace</p>
							<p><input name="pcre_type" id="pcre_type_preg_split" value="preg_split" type="radio"> preg_split</p>
							<br>
							<p><input name="pcre_modifiers_caseless" id="pcre_modifiers_caseless" value="i" checked="checked" type="checkbox"> Caseless (i)</p>
							<p><input name="pcre_modifiers_multiline" id="pcre_modifiers_multiline" value="m" type="checkbox"> Multiline mode (m) + (*ANYCRLF)</p>
							<p><input name="pcre_modifiers_dotall" id="pcre_modifiers_dotall" value="s" type="checkbox"> Dot all (s)</p>
							<p><input name="pcre_modifiers_extended" id="pcre_modifiers_extended" value="x" type="checkbox"> Extended (x)</p>
							<p><input name="pcre_modifiers_anchored" id="pcre_modifiers_anchored" value="A" type="checkbox"> Anchored (A)</p>
							<p><input name="pcre_modifiers_dollar_endonly" id="pcre_modifiers_dollar_endonly" value="D" type="checkbox"> Dollar end only (D)</p>
							<p><input name="pcre_modifiers_analysis" id="pcre_modifiers_analysis" value="S" type="checkbox"> Extra analysis of pattern (S)</p>
							<p><input name="pcre_modifiers_ungreedy" id="pcre_modifiers_ungreedy" value="U" type="checkbox"> Pattern is ungreedy (U)</p>
							<p><input name="pcre_modifiers_extra" id="pcre_modifiers_extra" value="X" type="checkbox"> Extra (X)</p>
							<p><input name="pcre_modifiers_utf8" id="pcre_modifiers_utf8" value="u" type="checkbox"> Pattern is treated as UTF-8 (u)</p>
							<br>
							<p><input name="pcre_flags_pattern_order" id="pcre_flags_pattern_order" value="PREG_PATTERN_ORDER" type="checkbox"> Pattern order</p>
							<p><input name="pcre_flags_set_order" id="pcre_flags_set_order" value="PREG_SET_ORDER" type="checkbox"> Set order</p>
							<p><input name="pcre_flags_offset_capture" id="pcre_flags_offset_capture" value="PREG_OFFSET_CAPTURE" type="checkbox"> Offset capture</p>
							<p><input disabled="disabled" name="pcre_flags_split_no_empty" id="pcre_flags_split_no_empty" value="PREG_SPLIT_NO_EMPTY" type="checkbox"> Split no empty</p>
							<p><input disabled="disabled" name="pcre_flags_split_delim_capture" id="pcre_flags_split_delim_capture" value="PREG_SPLIT_DELIM_CAPTURE" type="checkbox"> Split delim capture</p>
							<p><input disabled="disabled" name="pcre_flags_split_offset_capture" id="pcre_flags_split_offset_capture" value="PREG_SPLIT_OFFSET_CAPTURE" type="checkbox"> Split offset capture</p>
							<br>
							<p>Offset</p>
							<p><input class="" name="pcre_offset" id="pcre_offset" type="text"></p>
							<p>Limit</p>
							<p><input class="disabled" readonly="readonly" name="pcre_limit" id="pcre_limit" type="text"></p>
						</div>
						<div class="help">
							<dl>
								<dt>.</dt>
								<dd>Any character</dd>
								<dt>^</dt>
								<dd>Start of subject (or line in multiline mode)</dd>
								<dt>$</dt>
								<dd>End of subject (or line in multiline mode)</dd>
								<dt>[</dt>
								<dd>Start character class definition</dd>
								<dt>]</dt>
								<dd>End character class definition</dd>
								<dt>|</dt>
								<dd>Alternates (OR)</dd>
								<dt>(</dt>
								<dd>Start subpattern</dd>
								<dt>)</dt>
								<dd>End subpattern</dd>
								<dt>\</dt>
								<dd>Escape character</dd>
								<dt>\n</dt>
								<dd>Newline (hex 0A)</dd>
								<dt>\r</dt>
								<dd>Carriage return (hex 0D)</dd>
								<dt>\t</dt>
								<dd>Tab (hex 09)</dd>
								<dt>\d</dt>
								<dd>Decimal digit</dd>
								<dt>\D</dt>
								<dd>Charchater that is not a decimal digit</dd>
								<dt>\h</dt>
								<dd>Horizontal whitespace character</dd>
								<dt>\H</dt>
								<dd>Character that is not a horizontal whitespace character</dd>
								<dt>\s</dt>
								<dd>Whitespace character</dd>
								<dt>\S</dt>
								<dd>Character that is not a whitespace character</dd>
								<dt>\v</dt>
								<dd>Vertical whitespace character</dd>
								<dt>\V</dt>
								<dd>Character that is not a vertical whitespace character</dd>
								<dt>\w</dt>
								<dd>"Word" character</dd>
								<dt>\W</dt>
								<dd>"Non-word" character</dd>
								<dt>\b</dt>
								<dd>Word boundary</dd>
								<dt>\B</dt>
								<dd>Not a word boundary</dd>
								<dt>\A</dt>
								<dd>Start of subject (independent of multiline mode)</dd>
								<dt>\Z</dt>
								<dd>End of subject or newline at end (independent of multiline mode)</dd>
								<dt>\z</dt>
								<dd>End of subject (independent of multiline mode)</dd>
								<dt>\G</dt>
								<dd>First matching position in subject</dd>
								<dt>n*</dt>
								<dd>Zero or more of n</dd>
								<dt>n+</dt>
								<dd>One or more of n</dd>
								<dt>n?</dt>
								<dd>Zero or one occurrences of n</dd>
								<dt>{n}</dt>
								<dd>n occurrences</dd>
								<dt>{n,}</dt>
								<dd>At least n occurrences</dd>
								<dt>{,m}</dt>
								<dd>At the most m occurrences</dd>
								<dt>{n,m}</dt>
								<dd>Between n and m occurrences</dd>
							</dl>
						</div>
					</div>
					<div id="js" style="display: none;">
						<div class="parameters">
							<p><input name="js_type" id="js_type_match" value="match" checked="checked" type="radio"> match</p>
							<p><input name="js_type" id="js_type_replace" value="replace" type="radio"> replace</p>
							<p><input name="js_type" id="js_type_split" value="split" type="radio"> split</p>
							<p><input name="js_type" id="js_type_search" value="search" type="radio"> search</p>
							<br>
							<p><input name="js_modifiers_caseless" id="js_modifiers_caseless" value="i" checked="checked" type="checkbox"> Caseless (i)</p>
							<p><input name="js_modifiers_global" id="js_modifiers_global" value="g" checked="checked" type="checkbox"> Global search (g)</p>
						</div>
						<div class="help">
							Help Javascript
							<dl>
								<dt>.</dt>
								<dd>Any character</dd>
								<dt>^</dt>
								<dd>Start of subject</dd>
								<dt>$</dt>
								<dd>End of subject</dd>
								<dt>[</dt>
								<dd>Start character class definition</dd>
								<dt>]</dt>
								<dd>End character class definition</dd>
								<dt>|</dt>
								<dd>Alternates (OR)</dd>
								<dt>(</dt>
								<dd>Start subpattern</dd>
								<dt>)</dt>
								<dd>End subpattern</dd>
								<dt>\b</dt>
								<dd>Word boundary</dd>
								<dt>\B</dt>
								<dd>Non-worn boundary</dd>
								<dt>\n</dt>
								<dd>Newline</dd>
								<dt>\f</dt>
								<dd>Form feed character</dd>
								<dt>\r</dt>
								<dd>Carriage return character</dd>
								<dt>\t</dt>
								<dd>Horizontal tab character</dd>
								<dt>\v</dt>
								<dd>Vertical tab character</dd>
								<dt>\w</dt>
								<dd>Word character</dd>
								<dt>\W</dt>
								<dd>Non-word character</dd>
								<dt>\d</dt>
								<dd>Digit</dd>
								<dt>\D</dt>
								<dd>Non-digit</dd>
								<dt>\s</dt>
								<dd>Space character, equialent to [ \t\r\n\v\f]</dd>
								<dt>\S</dt>
								<dd>Non-space character, equialent to [^ \t\r\n\v\f]</dd>
								<dt>\</dt>
								<dd>Escape character</dd>
								<dt>n*</dt>
								<dd>Zero or more of n</dd>
								<dt>n+</dt>
								<dd>One or more of n</dd>
								<dt>n?</dt>
								<dd>Zero or one occurrences of n</dd>
								<dt>{n}</dt>
								<dd>n occurrences</dd>
								<dt>{n,}</dt>
								<dd>At least n occurrences</dd>
								<dt>{,m}</dt>
								<dd>At the most m occurrences</dd>
								<dt>{n,m}</dt>
								<dd>Between n and m occurrences</dd>
							</dl>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</form>

	</body></html>