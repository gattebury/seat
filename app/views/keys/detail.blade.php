@extends('layouts.masterLayout')
@section('html_title', 'Key Details')

@section('page_content')

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>
                    {{ $key_information->keyID }}
                </h3>
                <p>
                    Key ID
                </p>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>
                    @if (strlen($key_information->type) > 0)
                        {{ $key_information->type }}
                    @else
                        Unknown
                    @endif
                </h3>
                <p>
                    Key Type
                </p>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-maroon">
            <div class="inner">
                <h3>
                    {{ count($key_characters) }}
                </h3>
                <p>
                    Characters on key
                </p>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        @if ($key_information->isOk == 1)
        	<div class="small-box bg-green">
        @else
        	<div class="small-box bg-red">
        @endif
        
            <div class="inner">
                <h3>
                    {{ $key_information->isOk }}
                </h3>
                <p>
                    @if ($key_information->isOk == 1)
                    	Key is OK
                    @else
                    	Key is NOT ok
                    @endif
                </p>
            </div>
        </div>
    </div><!-- ./col -->
</div>

<hr>

<div class="row">
    <div class="col-md-4">
        <!-- Danger box -->
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">Characters On Key</h3>
                <div class="box-tools pull-right">
                	<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                	<button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if (count($key_characters) > 0)
                	@foreach ($key_characters as $character)
                		<div class="row">
                			<div class="col-md-4">
                                <a href="{{ action('CharacterController@getView', array('characterID' => $character->characterID )) }}">
                                    <img src="http://image.eveonline.com/Character/{{ $character->characterID }}_64.jpg" class="img-circle pull-right">
                                </a>
    		            	</div>
    		            	<div class="col-md-8">
    		            		<p class="lead">{{ $character->characterName }}</p>
    		            		<p>{{ $character->corporationName }}</p>
    		            	</div>
                		</div>
                	@endforeach
                @else
                    No known characters on this key
                @endif
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->

    <div class="col-md-4">
        <!-- Success box -->
        <div class="box box-solid box-success">
            <div class="box-header">
                <h3 class="box-title">Recent Update Jobs</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body no-padding">
				<table class="table table-condensed table-hover">
				    <tbody>
				    	<tr>
					        <th>Scheduled</th>
					        <th>API</th>
					        <th>Scope</th>
					        <th>Status</th>
					        <th></th>
					    </tr>
					    @foreach ($recent_jobs as $job)
						    <tr>
						        <td>
						        	<span data-toggle="tooltip" title="" data-original-title="{{ $job->created_at }}">
				                		{{ Carbon\Carbon::parse($job->created_at)->diffForHumans() }}
				                	</span>
				                </td>
						        <td>{{ $job->api }}</td>
						        <td>{{ $job->scope }}</td>
						        <td>{{ $job->status }}</td>
						        <td>
						        	@if (strlen($job->output) > 0)
							        	<i class="fa fa-bullhorn pull-right" data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $job->output }}" data-trigger="hover"></i>
							        @endif
						        </td>
						    </tr>
						@endforeach
					</tbody>
				</table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <div id="job-result">
        	{{-- just provide the update now for character keys --}}
        	@if ($key_information->keyID <> 'Corporation')
	        	<button class="btn btn-primary btn-block" id="new-job">Update Key Now</button>
        	@endif
        </div>
    </div><!-- /.col -->

    <div class="col-md-4">
        <!-- Warning box -->
        <div class="box box-solid box-warning">
            <div class="box-header">
                <h3 class="box-title">Banned Calls</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-warning btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-warning btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body no-padding">
				<table class="table table-condensed table-hover">
				    <tbody>
				    	<tr>
					        <th>Scheduled</th>
					        <th>Access Mask</th>
					        <th>API</th>
					        <th>Scope</th>
					        <th></th>
					    </tr>
					    @foreach ($key_bans as $ban)
						    <tr>
						        <td>
						        	<span data-toggle="tooltip" title="" data-original-title="{{ $ban->created_at }}">
				                		{{ Carbon\Carbon::parse($ban->created_at)->diffForHumans() }}
				                	</span>
				                </td>
						        <td>{{ $ban->accessMask }}</td>
						        <td>{{ $ban->api }}</td>
						        <td>{{ $ban->scope }}</td>
						        <td>
						        	@if (strlen($ban->reason) > 0)
							        	<i class="fa fa-bullhorn pull-right" data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $ban->reason }}" data-trigger="hover"></i>
							        @endif
						        </td>
						    </tr>
						@endforeach
					</tbody>
				</table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div>

@stop

@section('javascript')

<script type="text/javascript">
	$("button#new-job").click(function() {

		$(this).addClass('disabled');
		$.ajax({
			type: "get",
			url: "{{ action('ApiKeyController@getUpdateJob', array('keyID' => $key_information->keyID)) }}", 
			success: function(data) {
				if (data.state == 'error') {
					$("div#job-result").html('An error occured when trying to schedule a update job for this key. The applicatin logs may be able to tell you why.');
				}
				if (data.state == 'existing') {
					$("div#job-result").html('An existing queued update job for this keyID is presend with jobID ' + data.jobID);
				}
				if (data.state == 'new') {
					$("div#job-result").html('A new update job was scheduled with jobID ' + data.jobID);
				}
			},
			complete: function(data) {
				console.log(data)
			}
		});
	});
</script>
@stop