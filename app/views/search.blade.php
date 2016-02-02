<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel PHP Framework</title>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js" crossorigin="anonymous"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/yeti/bootstrap.min.css" rel="stylesheet" integrity="sha256-daEYF2SGTkiPl4cmxH06AOMnZ+Hb8wBpvs7DqvceszY= sha512-xmSDqcgDrroCG8Sp/p0IArjjB3lO0m0Yde0tm1mOFD4BwmsvZnVNfHgw7icU6q4ScrTCQKCokxnYMy/hUUfGrg==" crossorigin="anonymous">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script>
		function split_op(selector){
			var plan = jQuery(selector).val();
			var plans = plan.match(/[\s\S]{1,650}\n\n/g) || [];
			var total = plans.length;
			jQuery('#split_op').empty();
			$.each(plans, function( index, value ) {
				jQuery('<h1/>', {
					html: 'OP: '+(index+1)+'/'+total,
					style: 'width: 100%; margin: 10px 0px; padding: 10px 0px;'
				}).appendTo('#split_op');
				jQuery('<textarea/>', {
					id: 'op'+index,
					html: value,
					style: 'width: 100%; margin: 1em; padding: 1em;'
				}).appendTo('#split_op');
				jQuery('<hr/>').appendTo('#split_op');
			});
		}
		function clear_op(){
			jQuery('#split_op').empty();
		}
	</script>
	<style>

		body {
			color: #4a4a4a;
			padding-top: 70px;
		}

		.search {
			margin: 10px 100px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
	</style>{{--

	<script>
		navigator.registerProtocolHandler("",
				"https://www.google.co.uk/?uri=%s",
				"Burger handler");
	</script>--}}
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/search">lnk search</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li>
						<a data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm">
							Search
						</a>
					</li>
					<li>
						<a data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
							Query
						</a>
					</li>
					<li>
						<a href="http://lk.tavernbrawl.ch/LK-US-8/map/">
							MAP
						</a>
					</li>
					<li>
						<a href="http://lordsandknights.enjoyed.today/SelfTrickle/">
							Trickle
						</a>
					</li>
					<li>
						<a href="http://gildor.myds.me/battlecalc.jsp">
							Calculator
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="jumbotron">
		<div class="container">
			<ol class="breadcrumb">
				<li>
					<a class="origin" href='l+k://coordinates?{{ $origin['mapX'] }},{{ $origin['mapY'] }}&{{ $inputs['server'] }}'>
						Search Origin: {{ $origin['name'] or 'INVALID ORIGIN' }}
					</a>
				</li>
			</ol>

			<form class="collapse" id="collapseForm">
				<div class="panel panel-default">
					<div class="panel-heading">
						Origin: {{ $origin['name'] or 'INVALID ORIGIN' }}
					</div>
					<div class="panel-body">
						@if( !empty($inputs['playerInfo']) && !empty($origin['playerID']) && !empty($players[$origin['playerID']]) )
							<a href="l+k://player?{{$origin['playerID']}}&{{ $inputs['server'] }}">
								{{ $players[$origin['playerID']]['nick'] }} ({{ $players[$origin['playerID']]['points'] }} / #{{ $players[$origin['playerID']]['rank'] }})
							</a>
							<br/>
						@endif
						@if( !empty($inputs['allianceInfo']) && !empty($origin['allianceID']) && !empty($alliances[$origin['allianceID']]) )
							<a href="l+k://alliance?{{$origin['allianceID']}}&{{ $inputs['server'] }}">
								{{ $alliances[$origin['allianceID']]['name'] }} ({{ $alliances[$origin['allianceID']]['points'] }})
							</a>
							<br/>
						@endif
						<div class="form-group">
							<label for="max">Server</label>
							<select class="form-control" id="server" name="server" onchange="jQuery('#originX').val('');jQuery('#originY').val('')">
								<option
								@if( !empty($inputs['server']) && $inputs['server'] == 125 )
									selected
								@endif>US9</option>
								<option
										@if( !empty($inputs['server']) && $inputs['server'] == 113 )
										selected
										@endif>US8</option>
							</select>
						</div>
							<div class="form-group">
								<label for="link">lnk Link</label>
								<input type="text" class="form-control" id="link" placeholder="lnk://,,,"
									   value="{{ $origin['mapX'] or '' }}">
							</div>
						<div class="form-group">
							<label for="originX">Origin X</label>
							<input type="number" class="form-control" name="originX" id="originX" placeholder="Number"
								value="{{ $origin['mapX'] or '' }}">
						</div>
						<div class="form-group">
							<label for="originY">Origin Y</label>
							<input type="number" class="form-control" name="originY" id="originY" placeholder="Number"
								   value="{{ $origin['mapY'] or '' }}">
						</div>

						<a class="origin" href='l+k://coordinates?{{ $origin['mapX'] }},{{ $origin['mapY'] }}&{{ $inputs['server'] }}'>
							l+k://coordinates?{{ $origin['mapX'] }},{{ $origin['mapY'] }}&{{ $inputs['server'] }}
						</a>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">Result Filters</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="size">Number of Total Results</label>
							<input type="number" class="form-control" name="habitats[size]" id="size" placeholder="Number"
								   value="{{ $inputs['habitats']['size'] or '100' }}">
						</div>

						<div class="form-group">
							<label for="points">Castle Exact Size (comma seperated)</label>
							<input type="text" class="form-control" name="habitats[points]" id="points" placeholder="Number[, Number, ...]"
							@if( !empty($inputs['habitats']['points']) )
								@if( is_array($inputs['habitats']['points']) )
									value="{{ implode(',',$inputs['habitats']['points']) }}"
								@else
								   	value="{{$inputs['habitats']['points']}}"
								@endif
							@endif
									>
						</div>
						<div class="form-group">
							<label for="min">Castle Minimum Size</label>
							<select class="form-control" id="min" name="habitats[min]">
								@if( !empty($inputs['habitats']['min']) && $inputs['habitats']['min'] > 0 )
									<option>{{$inputs['habitats']['min']}}</option>
								@endif
								<option value="">ANY</option>
								<option>40</option>
								<option>100</option>
								<option>200</option>
								<option>289</option>
								<option>1500</option>
								<option>1600</option>
								<option>1700</option>
								<option>1797</option>
							</select>
						</div>
						<div class="form-group">
							<label for="max">Castle Maximum Size</label>
							<select class="form-control" id="max" name="habitats[max]">
								@if( !empty($inputs['habitats']['max']) && $inputs['habitats']['max'] > 0 )
									<option>{{$inputs['habitats']['max']}}</option>
								@endif
								<option value="">ANY</option>
								<option>40</option>
								<option>100</option>
								<option>200</option>
								<option>289</option>
								<option>1500</option>
								<option>1600</option>
								<option>1700</option>
								<option>1797</option>
							</select>
						</div>

{{--						<div class="form-group">
							<label for="max">Alliances</label>
							<select multiple class="form-control" id="max" name="habitats[alliances][]">
								@foreach( $alliances as $id=>$data )
									<option value="{{ $id }}">{{ $data['name'] }}</option>
								@endforeach
							</select>
						</div>--}}
						<div class="form-group">
							<label for="alliancesIDs">Alliance IDs (comma seperated)</label>
							<input type="text" class="form-control" name="habitats[alliancesIDs]" id="alliancesIDs" placeholder="Number[, Number, ...]"
							    @if( !empty($inputs['habitats']['alliancesIDs']) )
									@if( is_array($inputs['habitats']['alliancesIDs']) )
										value="{{ implode(',',$inputs['habitats']['alliancesIDs']) }}"
									@else
										value="{{$inputs['habitats']['alliancesIDs']}}"
									@endif
								@endif
							>
						</div>

{{--						<div class="form-group">
							<label for="max">Players</label>
							<select multiple class="form-control" id="max" name="habitats[players][]">
								@foreach( $players as $id=>$data )
									<option value="{{ $id }}">{{ $data['nick'] }}</option>
								@endforeach
							</select>
						</div>--}}
						<div class="form-group">
							<label for="playerIDs">Player IDs (comma seperated)</label>
							<input type="text" class="form-control" name="habitats[playerIDs]" id="playerIDs" placeholder="Number[, Number, ...]"
								   @if( !empty($inputs['habitats']['playerIDs']) )
								   @if( is_array($inputs['habitats']['playerIDs']) )
								   value="{{ implode(',',$inputs['habitats']['playerIDs']) }}"
								   @else
								   value="{{$inputs['habitats']['playerIDs']}}"
									@endif
									@endif
							>
						</div>

						<span class="label label-warning">Check If In Alliance</span>
						<div class="radio">
							<label>
								<input type="radio" name="habitats[in_alliance]" id="in_allianceY" value="no"
								@if( !empty($inputs['habitats']['in_alliance']) && $inputs['habitats']['in_alliance'] == 'no' )
									checked
								@endif
								>
								NOT in any alliance
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="habitats[in_alliance]" id="in_allianceN" value="yes"
									   @if( !empty($inputs['habitats']['in_alliance']) && $inputs['habitats']['in_alliance'] == 'yes' )
									   checked
										@endif
								>
								IN an alliance
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="habitats[in_alliance]" id="in_allianceE" value="either"
									   @if( empty($inputs['habitats']['in_alliance']) || $inputs['habitats']['in_alliance'] == 'either' )
									   checked
										@endif
								>
								ANY CASTLE
							</label>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">Display Results</div>
					<div class="panel-body">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="ops"
									   @if( !empty($inputs['ops']) )
									   checked
										@endif
								> Ops Sheet
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="distance"
									   @if( !empty($inputs['distance']) )
									   checked
										@endif
								> Distance from Origin
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="playerInfo"
									   @if( !empty($inputs['playerInfo']) )
									   checked
										@endif
								> Player Info
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="allianceInfo"
									   @if( !empty($inputs['allianceInfo']) )
									   checked
										@endif
								> Alliance Info
							</label>
						</div>
					</div>
				</div>

				<button type="submit" class="btn btn-default">Submit</button>
			</form>

		</div>
	</div>
	<div class="collapse" id="collapseExample">
			@if( !empty($inputs['habitats']['query_string']) )
				<h3>habitats</h3>
				<pre {{--style="display:none;"--}}>
				{{$inputs['habitats']['query_string']}}
				</pre>
			@endif

			@if( !empty($inputs['alliances']['query_string']) )
				<h3>alliances</h3>
				<pre {{--style="display:none;"--}}>
				{{$inputs['alliances']['query_string']}}
				</pre>
			@endif

			@if( !empty($inputs['players']['query_string']) )
				<h3>players</h3>
				<pre {{--style="display:none;"--}}>
				{{$inputs['players']['query_string']}}
				</pre>
			@endif
	</div>

	<div class="container">
		<h1>Copy from here.</h1>
		<!-- Example row of columns -->
		<textarea name="plan" id="plan" style="width:100%;height:10em;">
@if( !empty($habitats) )
@foreach ($habitats as $id => $castle)
@if( !empty($inputs['playerInfo']) && !empty($castle['playerID']) && !empty($players[$castle['playerID']]) )
{{ $players[$castle['playerID']]['nick'] }} ({{ $players[$castle['playerID']]['points'] }} / #{{ $players[$castle['playerID']]['rank'] }})
@endif
@if( !empty($inputs['allianceInfo']) && !empty($castle['allianceID']) && !empty($alliances[$castle['allianceID']]) )
{{ $alliances[$castle['allianceID']]['name'] }} ({{ $alliances[$castle['allianceID']]['points'] }})
@endif
[{{ $castle['points'] }} pts] @if( !empty($castle['name']) )
	{{  $castle['name'] }}
@else
Free Castle {{  $id }}
@endif
l+k://coordinates?{{ $castle['mapX'] }},{{ $castle['mapY'] }}&{{ $inputs['server'] }}
@if( !empty($inputs['distance']) )
Distance:{{ $castle['_search_score'] }}
@endif
@if( !empty($inputs['ops']) )
$ 💰:
+ 💣:
@endif

@endforeach
@endif
		</textarea>
		<button class="btn btn-primary" onclick="split_op('#plan');">Split Op</button>
		<button class="btn btn-warning" onclick="clear_op();">Clear Op Splits</button>
		<div id="split_op"></div>
	</div>

	<div class="container">
		<h1>Linked list</h1>
		<!-- Example row of columns -->
		<div class="row">
			<div class="col-md-4">
			@if( !empty($habitats) )
				@foreach ($habitats as $id => $castle)
					@if( !empty($inputs['playerInfo']) && !empty($castle['playerID']) && !empty($players[$castle['playerID']]) )
						<a href="l+k://player?{{$castle['playerID']}}&{{ $inputs['server'] }}">
							{{ $players[$castle['playerID']]['nick'] }} ({{ $players[$castle['playerID']]['points'] }} / #{{ $players[$castle['playerID']]['rank'] }})
						</a>
						<br/>
					@endif
					@if( !empty($inputs['allianceInfo']) && !empty($castle['allianceID']) && !empty($alliances[$castle['allianceID']]) )
						<a href="l+k://alliance?{{$castle['allianceID']}}&{{ $inputs['server'] }}">
							{{ $alliances[$castle['allianceID']]['name'] }} ({{ $alliances[$castle['allianceID']]['points'] }})
						</a>
						<br/>
					@endif
					[{{ $castle['points'] }} pts]
					@if( !empty($castle['name']) )
						{{  $castle['name'] }}
					@else
						Free Castle {{  $id }}
					@endif
					<br/>
					<a href='l+k://coordinates?{{ $castle['mapX'] }},{{ $castle['mapY'] }}&{{ $inputs['server'] }}'>
						l+k://coordinates?{{ $castle['mapX'] }},{{ $castle['mapY'] }}&{{ $inputs['server'] }}
					</a><br/>
					@if( !empty($inputs['distance']) )
							Distance:{{ $castle['_search_score'] }}<br/>
					@endif
					@if( !empty($inputs['ops']) )
						$ 💰:<br/>
						+ 💣:<br/>
					@endif
					<br/>

				@endforeach
			@endif
		</div>
	</div>
</body>
</html>
