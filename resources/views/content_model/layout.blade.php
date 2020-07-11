@extends('layouts.app')

@push('css-plugins')
<link href="{{ asset('scripts/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('scripts/icheck/skins/all.css') }}" rel="stylesheet">
<link href="{{ asset('scripts/timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('scripts/codemirror/lib/codemirror.css') }}" rel="stylesheet">
<link href="{{ asset('scripts/codemirror/theme/neo.css') }}" rel="stylesheet">
<link href="{{ asset('scripts/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">		
<link href="{{ asset('css/styles.css') }}" rel="stylesheet">		
@endpush

@section('title')Content Model Builder
@endsection

@section('content')
<section class="section">
		<div class="section-header">
			<div class="col">
				<h1>Content Model Builder</h1>				
			</div>
			<div class="inspector">
			</div>
			<div class="col text-right">
				<div class="dropdown d-inline-block">
					<a role="button" id="content-model-setting" class="btn btn-info text-light"><i class="fas fa-cog"></i>Setting</a>
					<a role="button" id="btnGenerate" class="btn btn-primary text-light"><i class="fas fa-microchip"></i> Generate Now</a>
				</div>
			</div>
		</div>
		<div class="row bg-white p-3" style="margin : -10px 35px -20px 0px">
			<div class="col d-flex">
				<div class="text-bold">
					<b>Name : </b> 
				</div> 
				<div class="ml-2" id="display-content-model-name"></div>
			</div>
			<div class="col d-flex">
				<div class="font-bold">
					<b>Display Name : </b>  
				</div> 
				<div class="ml-2" id="content-model-display-name"></div>
			</div>
		</div>
		<div class="section-body">
				<div class="row mt-5">
					<div class="col-9">
						<div id="editor_area"></div>
						<textarea id="source_area" class="hide"></textarea>
						<div class="bg-white mt-4 p-4">
							<h5>List Relations</h5>
							<div id="list-of-relations"></div>
						</div>
					</div>
					<div class="col-3">
								<div class="sidemenu">
										<div class="sidemenu-inner">            
												<ul>
														<li class="has-tree active">
															<a role="button">
																<i class="fas fa-th-large"></i> Components <span class="caret"></span>
															</a>
															<ul id="toolbox" class="grid components">
																<li class="search-menu" data-target="#toolbox">
																	<input type="text" class="form-control" placeholder="Search components" id="search-components">
																</li>
															</ul>
														</li>
														<li>
															<div class="relation-field m-4">
																<button class="btn btn-block btn-primary" type="button" data-toggle="modal"  data data-target="#exampleModal" data-backdrop="false" id="addRelationButton">Add Relation</button>
															</div>
														</li>
													</ul>
										</div>
								</div>
					</div>
				</div>
		</div>

		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10px">
			<div class="modal-dialog" role="document">
				<form>
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Add Relation field</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
							<div class="form-group">
								<label for="name-relation">Name</label>
								<input type="text" name="name-relation" class="form-control" id="name-relation" placeholder="Enter relation name" required>
							</div>
							<div class="form-group">
								<label for="relation-description">Description</label>
								<textarea name="relation-description" id="relation-description" cols="30" rows="10" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label for="relation-option">Relation type</label>
								<select name="relation-type" id="relation-option" class="form-control" onclick="selectRelation()" required>
									<option value="">Select Relation Type</option>
									<option value="one-one">One on One</option>
									<option value="one-many">One to Many</option>
									<option value="many-many">Many to Many</option>
								</select>
							</div>
							<div class="form-group">
								<div id="whats"></div>
								<div id="whats2"></div>
								<div id="pivot-table-container"></div>
								<div id="referenced-model"></div>
								<div id="custom-referenced-model"></div>
							</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" onclick="setRelation()" data-dismiss="modal">Set Relation</button>
					</div>
				</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalEditRelation" tabindex="-1" role="dialog" aria-labelledby="editRelationModalLabel" aria-hidden="true" style="margin-top: 10px">
			<div class="modal-dialog" role="document">
				<form>
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Add Relation field</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
							<div class="form-group">
								<label for="name-relation">Name</label>
								<input type="text" name="name-relation" class="form-control" id="name-relation-edit" placeholder="Enter relation name" required>
							</div>
							<div class="form-group">
								<label for="relation-description">Description</label>
								<textarea name="relation-description" id="relation-description-edit" cols="30" rows="10" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label for="relation-option">Relation type</label>
								<select name="relation-type" id="relation-option-edit" class="form-control" onclick="selectRelation()" required>
									<option value="">Select Relation Type</option>
									<option value="one-one">One on One</option>
									<option value="one-many">One to Many</option>
									<option value="many-many">Many to Many</option>
								</select>
							</div>
							<div class="form-group">
								<div id="whats"></div>
								<div id="whats2"></div>
								<div id="pivot-table-container"></div>
								<div id="referenced-model">
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" onclick="setRelation()">Set Relation</button>
					</div>
				</form>
				</div>
			</div>
		</div>
@endsection

@push('scripts')
<script src="{{ asset('scripts/sweetalert/sweetalert.js') }}"></script>
<script src="{{ asset('scripts/cleave/dist/cleave.min.js') }}"></script>
<script src="{{ asset('scripts/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('scripts/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('scripts/timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('scripts/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('scripts/codemirror/lib/codemirror.js') }}"></script>
<script src="{{ asset('scripts/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('scripts/html2json/lib/Pure-JavaScript-HTML5-Parser/htmlparser.js') }}"></script>
<script src="{{ asset('scripts/html2json/src/html2json.js') }}"></script>
<script src="{{ asset('scripts/filesaver/FileSaver.min.js') }}"></script>
<script src="{{ asset('scripts/stuk-jszip/dist/jszip.min.js') }}"></script>
<script src="{{ asset('scripts/underscore/underscore.js') }}"></script>
<script src="{{ asset('scripts/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('scripts/showdown/dist/showdown.min.js') }}"></script>
<script src="{{ asset('scripts/htmlbeautify/htmlbeautify.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script>
	$('#addRelationButton').click(function(){
		let cm_name = localStorage.getItem('_content_model_generator_setting')["name"];		
	});

	let temp = [];
	function setRelation()
	{
		let relation_name = $('#name-relation').val();
		let relation_description = $('#relation-description').val();
		let relation_type = $('#relation-option').val();
		let pivot_table = $('#pivot-table').val();
		let relation_model_target = $('#relation-model').val();
		
		if(relation_model_target === "hmmm"){
			relation_model_target = $('#custom-relation-model').val();
		}

		let oneone = $('#oneOne').val();
		let onemany = $('#oneMany').val();

		let modifier;

		if(oneone){
			modifier = oneone;
		}else if(onemany){
			modifier = onemany;
		}else{
			modifier = "belongsToMany";
		}

		let relation_data = {
			"nama" : relation_name,
			"description" : relation_description,
			"type" : {
					"name" : relation_type,
					"modifier" : modifier,
					"pivot" : pivot_table
				},
			"target_model" : {
					"name" : relation_model_target
				}
		}

		console.log(relation_data);

		let info_cm = JSON.parse(localStorage.getItem('_content_model_generator_setting'));		

		relation_element = `
			<div class="for-relation form-group editor-draggable-element ui-droppable ui-draggable ui-draggable-handle" data-element-name="relation" data-element-db-type="references" id="${relation_name}RelationField" onClick="editRelationField()">
				<label class="field_name" data-store-input-display-name="Relasi"> ${ relation_name} </label>
				<input type="text" name="relasi" class="form-control bg-danger" disabled="disabled" data-store-input-name="reaasi" value="${relation_name}">
				 <div class="help-text">
					${ info_cm.display_name } 
					${ relation_type === 'many-many' ? "BelongsTo" : ''}
					${ relation_type === 'one-one' ? oneone : ''}						
					${ relation_type === 'one-many' ? onemany : ''}						
					${ relation_model_target }
				</div>
			</div>`

		check_relation_element = localStorage.getItem('saved_relation_element');
		
		_relation_data = localStorage.getItem("relation_data");

		if(_relation_data == undefined || _relation_data == null)
		{
			temp.push(relation_data);
			localStorage.setItem("relation_data", JSON.stringify(temp));
		}else{
			_relation_data = JSON.parse(_relation_data);
			_relation_data.push(relation_data);
			localStorage.setItem("relation_data", JSON.stringify(_relation_data));
		}

		if(check_relation_element != undefined)
		{
			check_relation_element += relation_element;
			localStorage.setItem('saved_relation_element', check_relation_element);
			// $('#list-of-relations').append(check_relation_element);

			
			// return;
		}else{
			localStorage.setItem('saved_relation_element', relation_element);
		}
		
		$('#list-of-relations').append(relation_element);
	}

	function editRelationField()
	{
		$('#modalEditRelation').modal(
			{
				backdrop: false, 
				dismiss: true, 
				keyboard: true, 
				focus: true
			});
	}

	function loadContentModel()
	{           
		if ($('#relation-model > option').length == 1) {
			$('#relation-model').empty().append('<option value="hmmm">No of these</option>');

				$.ajax({
						url: '{{ route('content_model.load') }}',
						dataType: 'json',
						type: 'POST',
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						success: function(res) {
							console.log(res.length);

							if(res.length > 0 ){
								res.forEach(function(cm){
									// console.log(cm);
									$("#relation-model").append(`<option value="${ cm.table_name }">${ cm.table_name }</option>`);
								});
							}else {

								if($('#relation-model').val() == "hmmm")
								{
									sementara = `
									<div id="custom-referenced-model-div" class="mt-2">
										<input type="text" name="custom-relation-model" id="custom-relation-model" class="form-control" placeholder="type your reference content model that didnt exist" required>
									</div>
									`;
	
									$("#custom-referenced-model").html(sementara);									
								};
							}

						},
						error: function(x, e) {
							console.log(x);
						}
				});
			}
	
			// referencedModelSelect(selectModel);
	}

	function selectRelation()
	{
		let selected_relation = $('#relation-option').val();

		if(selected_relation === 'one-one')
		{
			if ($('#oneOne').length == 0) 
			{
				let one_one_element = `
					<div id="whatsrole" class="mb-4">
						<label for="oneone">What ?</label>
						<select id="oneOne" class="form-control" name="oneOneSelect">
							<option value="hasOne">Has One</option>
							<option value="belongsTo">Belongs To</option>
						</select>
					</div>
				`;
	
				$("#whats").html(one_one_element);
			};
			
		}else{
			$("#whatsrole").remove();
		};

		if(selected_relation === 'one-many')
		{
			if ($('#oneMany').length == 0) 
			{
				let one_many_element = `
					<div id="whatsrole2" class="mb-4" >
						<label for="oneMany">What ?</label>
						<select id="oneMany" class="form-control" name="oneManySelect">
							<option value="hasMany">Has Many</option>
							<option value="belongsTo">Belongs To</option>
						</select>
					</div>
				`;
	
				$("#whats2").html(one_many_element);
			};
			
		}else{
			$("#whatsrole2").remove();
		};

		//show pivot table field
		if(selected_relation === 'many-many')
		{
			if ($('#pivot-table').length == 0) 
			{
				let pivot_table_element = `
					<div id="pivot-table-hmmm" class="mb-4">
						<label for="pivot-table">Pivot Table</label>
						<input type="text" id="pivot-table" name="pivot-table" class="form-control">
					</div>
				`;
	
				$("#pivot-table-container").append(pivot_table_element);
			};
			
		}else{
			$("#pivot-table-hmmm").remove();
		};

		//target model
		if(selected_relation != "")
		{
			if ($('#relation-model-div').length == 0) 
			{
				let referenced_model_element = `
					<div id="relation-model-div">
						<label for="relation-model">Referenced Model</label>
						<select name="relation-model" id="relation-model" class="form-control" onclick="loadContentModel()" required onchange="referencedModelSelectOnChange(this)">
						<option value="no-model">Select content model</option>
						</select>
					</div>
				`;

					$("#referenced-model").html(referenced_model_element);
			}else{
				$("#relation-model-div").remove();
			}
		}
	};
	
	function referencedModelSelectOnChange(selectModel){
		// alert("sini nfak");
		// console.log(selectModel.value ==="hmmm");
		if(selectModel.value === "hmmm"){
			let temp = `
			<div id="custom-referenced-model-div" class="mt-2">
				<input type="text" name="custom-relation-model" id="custom-relation-model" class="form-control" placeholder="type your reference content model that didnt exist" required>
				</div>
			`;
				$("#custom-referenced-model").append(temp);									
		}else{
			$("#custom-referenced-model-div").remove();
		};
	}
	// ------------------------------------------------------------
	let is_recover = false,
			is_ws = false;

	// Recover layout
	let _saved_layout = localStorage.getItem("_content_model_generator_layout"),
			_saved_setting = localStorage.getItem("_content_model_generator_setting");
			_saved_setting = JSON.parse(_saved_setting);

	if(_saved_layout && _saved_layout !== '{"node":"root","child":[]}' || _saved_setting) {
		is_recover = true;
		setTimeout(() => {
			localStorage.setItem('_content_model_generator_layout', _saved_layout);
		}, 1000);

		let get_setting = localStorage.getItem("_content_model_generator_setting");
		if(get_setting) {
			get_setting = JSON.parse(get_setting);
		}

		let name = (get_setting.name ? get_setting.name : ""),
				display_name = (get_setting.display_name ? get_setting.display_name : ""),
				description = (get_setting.description ? get_setting.description : "");

		$('#display-content-model-name').html(`
			${name}
		`);
		
		$('#content-model-display-name').html(`
			${ display_name }
		`);

		bsModal.create({
			title: '<i class="fas fa-heart-broken"></input> Recover Layout',
			body: 'We have found your last work <code>'+(_saved_setting.display_name ? _saved_setting.display_name : 'Untitled Content Model')+'</code>, would you like to recover it?',
			options: {
				'backdrop' : 'static'
			},
			buttons: [
				{
					text: 'Recover',
					class: 'btn btn-primary',
					handler: function(b) {
						localStorage.setItem('_content_model_generator_layout', _saved_layout);
						selector.source_area.val(_saved_layout);
						$("#list-of-relations").append(localStorage.getItem("saved_relation_element"));
						source.init();
						bsModal.hide();
					}
				},
				{
					text: 'Destroy',
					class: 'btn btn-default',
					handler: function(b) {
						localStorage.removeItem("saved_relation_element");
						localStorage.removeItem("relation_data");
						localStorage.removeItem('_content_model_generator_layout');
						localStorage.removeItem('_content_model_generator_setting');
						welcome_screen();
					}
				}
			]
		});
	}

	let welcome_screen = function() {				
				let ws_body = `<hr style="margin-top:-10px">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label>Content Model Name</label>
															<input type="text" class="form-control" id="content-model-name" placeholder="e.g: blog_post">
															<div class="help-text" id="help-text-welcome">An unique name, use _ instead of space</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Display Name</label>
															<input type="text"  class="form-control" placeholder="e.g: Blog Post" id="content-model-display-name" p>
															<div class="help-text">The name to be displayed in the view</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Description</label>
															<textarea class="form-control" rows="3" id="content-model-description"></textarea>
														</div>
													</div>
												</div>`


		bsModal.create({
			options: {
				'backdrop' : 'static'
			},
			class: 'modal-lg mt-5',
			title: '<i class="fas fa-flask"></i> Welcome to Content Model Builder',
			body: ws_body,
			buttons: [				
				{
					text: 'Cancel',
					class: 'btn btn-default',
					handler: function() {
						document.location = '{{ route('dashboard.index') }}';
					}
				},
				{
					text: 'Start',
					class: 'btn btn-lg btn-primary',
					id: 'btn-start',
					handler: function(b) {
						let name = b.find(".modal-body #content-model-name").val(),
								display_name = b.find(".modal-body #content-model-display-name").val(),
								description = b.find(".modal-body #content-model-description").val();

						if(!name) {
							b.find(".modal-body #content-model-name").focus();
							return;
						}else if(!display_name) {
							b.find(".modal-body #content-model-display-name").focus();
							return;
						}

						$.ajax({
								url: '{{ route('content_model.cek_name') }}',
								dataType: 'json',
								data: {name:name},
								type: 'POST',
								headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
								complete: function(data) {
									console.log(data.responseText);
									// console.log(data.responseText == "ada");
									if(data.responseText == "ada")
									{
										b.find(".modal-body #content-model-name").focus();
										$("#help-text-welcome").html("<span class='text-danger:red'><b>Please use an another name</b></span>");				
										// return;
									}else{
											let setting = {
												name: name,
												display_name: display_name,
												description: description,
											}
											localStorage.setItem("_content_model_generator_setting", JSON.stringify(setting));
											bsModal.hide();
											is_ws = false;
									}
								},
								error: function(xhr) {
									// console.log(xhr);
								}
							});

					}
				}
			]
		});
	}

	if(is_recover == false) {
		welcome_screen();
		is_ws = true;
	}

	let selector = {
		toolbox: $("#toolbox"),
		editor_area: $("#editor_area"),
		inspector: $(".inspector"),
		source_area: $("#source_area")
	}

	let request_url = {
		components: '{{ route('fields.file', ['json', 'components']) }}',
		intructions: '{{ route('fields.file', ['md', 'intructions']) }}',
		generate: '{{ route('content_model.generate') }}'
	}

	$(document).on('keydown', function(e) {		
		if(e.key == 'F1') {
			$("#search-components").focus();
			return false;
		}
	});

	let source = {
		init: function() {
			let _source = selector.source_area.val();

			if(_source) {				
				let html = source.toHTML(_source);
				editor_area.update(html);
			}else{
				source.update();			
			}
		},
		toHTML: function(html) {
			return json2html(JSON.parse(html));
		},
		update: function() {
			let _source = selector.editor_area.html();
					_source = $(_source);
					_source = $("<div>").append(_source);
					_source.find(".ui-draggable-dragging").remove();
					_source.find(".has-focused").removeClass('has-focused');
					_source = _source.html();
			let parse = html2json(_source);
					parse = JSON.stringify(parse);

			selector.source_area.val(parse);

			localStorage.setItem('_content_model_generator_layout', parse);
		}
	}
	selector.source_area.on("input", function() {
		source.init();
	});
	source.init();

	let toolbox_data, toolbox = {
		options: {
			revert: "invalid",
			cursorAt: { top: 30, left: 30 },
			helper: "clone",
			cursor: "move",
			start: function() {
				let pos = $(window).scrollTop();
				$(".sidemenu").css({
					overflow: 'initial',
					// top: -(pos-60)
				});
			},
			stop: function() {
				$(".sidemenu-inner").css({
					overflow: 'auto'
					// top: 60
				})
			}
		},
		add: function(elem) {
			selector.toolbox.append(elem);
			selector.toolbox.find("li:not(.header)").addClass("toolbox-item").draggable(toolbox.options);

			search_menu();
		},
		remove: function(sele) {
			selector.toolbox.find(sele).remove();
		},
		findByName: function(name) {
			let findByName = _(toolbox_data)
												.chain()
												.pluck('children')
												.flatten()
												.findWhere({name: name})
												.value();

			return findByName;
		},
		init: function() {
			toolbox.render();
		},
		load: function(success) {
			let result;
			$.ajax({
				url: request_url.components,
				dataType: 'json',
				beforeSend: function() {
					toolbox.add('<li id="loading-component">Loading Components ...</li>');
				},
				complete: function() {
					toolbox.remove("#loading-component");
				},
				success: function(data) {
					result = data;
					success.call(this, data);
					// console.log(this);
				}
			});
		},
		_extract: function(obj) {
			obj.forEach((comps) => {
				toolbox.add("<li id='group-" + comps.name + "' class='header'>" + comps.display_name + "</li>");
				if(comps.children) {
					comps.children.forEach((child) => {
						let _item = "<li>";
								_item += "<a role='button' id='tool-" + child.name + "' class='tool-item-" + child.name + "' data-item-name='" + child.name + "' title='" + child.display_name + "'>";
								_item += child.icon;
								_item += "<div>" + child.display_name + "</div>";
								_item += "</a>";
								_item += "</li>";
					  toolbox.add(_item);
					});
				}
			});
		},
		render: function() {
			toolbox.load(function(data) {
				if(typeof data == 'object') {
					toolbox._extract(data.data);
					toolbox_data = data.data;
				}
			});
		}
	}
	toolbox.init();

	let selected_element_object, selected_element, editor_area = {
		options: {
			accept: ".components li:not(.header), .editor-draggable-element",
			greedy: true,
			hoverClass: "droppable-hover",
			tolerance: 'pointer',
	    classes: {
	      "ui-droppable-active": "ui-state-highlight"
	    },
	    over: function(ev, ui) {
				// console.log(ui);
				// selector.editor_area.find(".editor-draggable-element").hide();

				// if(selector.editor_area.find(".text").length < 1){
				// 	selector.editor_area.addClass("has-empty");
				// 	selector.editor_area.append("<div class='text'>Drop your components here");
				// }
			},
			drop: function(ev, ui) {
				console.log("Disini kah");
				var toolbox_item = $(ui.draggable).find("a"),
						toolbox_item_name = toolbox_item.data('item-name'),
						_html;
					
				// console.log(_html);
				
				// console.log(toolbox_item);

				let toolbox_item_object = toolbox.findByName(toolbox_item_name),
						toolbox_item_element;

						console.log(toolbox_item_object);
						if(!$(ui.draggable).hasClass('toolbox-item')) {
									toolbox_item = $(ui.draggable);
									toolbox_item_name = editor_area.droppedGet(toolbox_item);
									toolbox_item.removeClass('origin-element');
									_html = toolbox_item;
									$(".origin-element").remove();
								}else{
									_html = $(toolbox_item_object.html);
									
									selector.editor_area.find(".editor-draggable-element").show();
									selector.editor_area.find(".text").remove();			
									
									var height_editor_area = $(selector.editor_area).height();

									if($("#editor_area").height() > 500 ){
										$("#editor_area").css('height', '+' + (100+height_editor_area) + 'px');
									}
								}

								selected_element_object = toolbox_item_object;
								if(!selected_element_object) {
									selected_element_object = toolbox.findByName(editor_area.droppedGet(toolbox_item));
								}

								if(typeof selected_element_object == 'object') {
									toolbox_item_element = _html;
								}else{
									swal('Whoopss', 'Sorry, element not recognized.');
									return;
								}
								
								// console.log(toolbox_item_element[0]);

								// let new_toolbox_item_element = toolbox_item_element[0].getElementsByClassName('field_name');
								// new_toolbox_item_element[0].innerText = field_name;
										
								editor_area.drop($('#editor_area.ui-droppable'), toolbox_item_element);
								bsModal.hide();
				// bsModal.create({
				// 	title: '<i class="fab fa-buromobelexperte"></i>  Data Type<hr>',
				// 	body: `
				// 		<div class="form-group" style="margin-top: -20px">
				// 			<label>Display name </label>
				// 			<input type="text" class="form-control" name="field_name" placeholder="e.g: post_title">
				// 		</div>
				// 		<div class="form-group">
				// 			<label>Api id</label>
				// 			<input type="text" class="form-control" placeholder="auto or custom by yours" name="api_id">
				// 		</div>`,
				// 	buttons: [
				// 		{
				// 			text: 'Create',
				// 			class: "btn btn-lg btn-primary",
				// 			handler: function(b) {
				// 				let field_name = b.find(".modal-body [name='field_name']").val(),
				// 						api_id = b.find(".modal-body [name='api_id']").val();

				// 				if(!field_name) {
				// 					b.find(".modal-body [name='field_name']").focus();
				// 					return;
				// 				}else if(!api_id) {
				// 					b.find(".modal-body [name='api_id']").focus();
				// 					return;
				// 				}

				// 				if(!$(ui.draggable).hasClass('toolbox-item')) {
				// 					toolbox_item = $(ui.draggable);
				// 					toolbox_item_name = editor_area.droppedGet(toolbox_item);
				// 					toolbox_item.removeClass('origin-element');
				// 					_html = toolbox_item;
				// 					$(".origin-element").remove();
				// 				}else{
				// 					_html = $(toolbox_item_object.html);
									
				// 					selector.editor_area.find(".editor-draggable-element").show();
				// 					selector.editor_area.find(".text").remove();			
									
				// 					var height_editor_area = $(selector.editor_area).height();

				// 					if($("#editor_area").height() > 500 ){
				// 						$("#editor_area").css('height', '+' + (100+height_editor_area) + 'px');
				// 					}
				// 				}

				// 				selected_element_object = toolbox_item_object;
				// 				if(!selected_element_object) {
				// 					selected_element_object = toolbox.findByName(editor_area.droppedGet(toolbox_item));
				// 				}

				// 				if(typeof selected_element_object == 'object') {
				// 					toolbox_item_element = _html;
				// 				}else{
				// 					swal('Whoopss', 'Sorry, element not recognized.');
				// 					return;
				// 				}
								
				// 				// console.log(toolbox_item_element[0]);

				// 				// let new_toolbox_item_element = toolbox_item_element[0].getElementsByClassName('field_name');
				// 				// new_toolbox_item_element[0].innerText = field_name;
										
				// 				editor_area.drop($('#editor_area.ui-droppable'), toolbox_item_element);
				// 				bsModal.hide();
				// 			}
				// 		}
				// 	]
				// });

				// console.log($('#editor_area.ui-droppable'));
				// console.log(toolbox_item_element);
			}
		},
		update: function(html) {
			selector.editor_area.html(html);
			editor_area.elementFunction(selector.editor_area.find(".editor-draggable-element"));
			editor_area.check();
		},
		droppedSet: function(elem, name, db_type) {
			elem.attr('data-element-name', name);
			elem.attr('data-element-db-type', db_type);
		},
		droppedGet: function(elem) {
			return elem.attr('data-element-name');
		},
		draggable_options: {
			cancel: false,
			revert: 'invalid',
			tolerance: "pointer",
			cursorAt: {
				top: 0,
				left: 0
			},
			helper: function() {
				let _this_draggable = $(this).clone();
				$(this).addClass('origin-element');

				return _this_draggable;
			}
		},
		drop: function(target_drop, elem) {
			editor_area.droppedSet(elem, selected_element_object.name, selected_element_object.db_type);
			// editor_area.droppedSet(elem, selected_element_object.db_type);
			elem = editor_area.elementFunction(elem);

			// console.log(elem);
			target_drop.append(elem);
			editor_area.check();

			source.update();
		},
		elementFunction: function(elem) {
			elem.addClass("editor-draggable-element");
			elem.droppable(editor_area.options);
			elem.draggable(editor_area.draggable_options);
			elem.on("contextmenu", editor_area.inspect);
			elem.on("click", function() {
				return false;
			});
			return elem;
		},
		inspect: function(e) {
			selected_element = $(e.target);
			if(!selected_element.hasClass('editor-draggable-element')) selected_element = selected_element.closest('.form-group');
			selected_element_name = editor_area.droppedGet(selected_element),
			selected_element_object = toolbox.findByName(selected_element_name);

			all_elements = $('.editor-draggable-element');

			if(selected_element.hasClass('editor-draggable-element')) {
				all_elements.removeClass('has-focused');
				selected_element.addClass('has-focused');
				inspector.run();
			}

			e.preventDefault();
		},
		selectedSet: function(name, value) {
			selected_element.attr('data-store-' + name, value);
		},
		selectedGet: function(name) {
			return selected_element.attr('data-store-' + name);
		},
		check: function() {
			if(selector.editor_area.html().length < 1) {
				selector.editor_area.addClass("has-empty");
				selector.editor_area.html("<div class='text'>Drop your components here.</div>");
			}else{
    		selector.editor_area.removeClass("has-empty");
    		selector.editor_area.find(".text").remove();
			}
		},
		init: function() {
			editor_area.check();
			selector.editor_area.droppable(editor_area.options);

			$(window).scroll(function(){
					var fromTop = $(window).scrollTop();
					$(".sidemenu").css('margin', '-' + (fromTop) + 'px 0px 0px 0px');
			});
		},
		tips: function(_ws) {
			let buttons;
			if(_ws) {
				buttons = [{
					text: 'Back',
					class: 'btn default',
					handler: function() {
						welcome_screen();
					}
				}]
			}else{
				buttons = [{
					text: 'Yes, i got it!',
					class: 'btn btn-primary',
					role: 'close'
				}]
			}

			bsModal.create({
				title: '<i class="fas fas-ios-lightbulb-outline"></i> Tips',
				bodyLoad: request_url.intructions,
				buttons: buttons
			});
		}
	}
	editor_area.init();

	let inspector_modal, count_list = 0, inspector = {
		reset: function() {
			selector.inspector.html("");
		},
		add: function(elem) {
			selector.inspector.append(elem);
		},
		addItem: function(id, elem) {
			selector.inspector.find('#inspector-group-' + id).append($("<div/>", {
				class: "inspector-control-group"
			})
			.append($("<label/>", {
				html: elem[0]
			}))
			.append($("<div/>", {
				class: "inspector-control",
				html: elem[1]
			})));
		},
		addGroup: function(title, id) {
			let create_group = $("<div/>", {
				id: 'inspector-group-' + id,
				class: 'inspector-group',
				html: `<h5>${title} </h5>`
			});
			selector.inspector.find(".inspector-group-inner").append(create_group);
		},
		addBlock: function(id, elem) {
			selector.inspector.find('#inspector-group-' + id).append($("<div/>", {
				class: "inspector-control-group"
			})
			.append($("<div/>", {
				html: elem
			})));
		},
		editable: function(value, selected_editable, opt) {
			_selected_element = selected_element;
			selected_element = (selected_editable.find !== undefined ? selected_element.find(selected_editable.find) : selected_element);

			// store to selected element as temporary attribute
			if(selected_editable.type == 'select') {
				editor_area.selectedSet(opt.name, value);
			}else if(selected_editable.type == 'input') {
				editor_area.selectedSet(selected_editable.name, value);
			}

			// store to selected element as real attribute
			if(selected_editable.selector == 'attr') {
				let attr_value = selected_element.attr(selected_editable.store_to);
				attr_value = (attr_value ? attr_value.trim() : '');

				if(selected_editable.type == 'select') {
					opt.list.forEach((item) => {
					  attr_value = attr_value.replace(" " + item.name, "");
					  attr_value = attr_value.replace(item.name, "");
					});
				}

				if(value !== 'false') {
					if((selected_editable.keep_old == undefined || selected_editable.keep_old == true) && selected_editable.type != 'input') {
						attr_value += ' ' + value;
					}else{
						attr_value = value;
					}
				}

				attr_value = attr_value.trim();
				selected_element.attr(selected_editable.store_to, attr_value);
			}else if(selected_editable.selector == 'html') {
				let html_value = selected_element.html();
				html_value.trim();
				
				if(selected_editable.store_to == 'this') {
					selected_element.html(value);
				}
			}

			selected_element = _selected_element;

			source.update();
		},
		removeElement: function(e) {
			selected_element.remove();
			editor_area.check();
			inspector.destroy();

			source.update();
		},
		createSelect: function(item, option, change) {
			let create_select = '<select class="inspector-input">';
					if(!option.primary) {
						create_select += "<option value='false'>None</option>";
					}
					option.list.forEach((opt) => {
						create_select += "<option value='" + opt.name + "' " + (inspector.getValue(item, option) == opt.name ? 'selected' : '') + ">" + opt.display_name + "</option>";
					});
					create_select += "</select>";

			create_select = $(create_select);
			create_select.on("change", function(e) {
				change.call(this, e);
			});
			return create_select;
		},
		createInput: function(item, keyup) {
			let create_input = '<input class="inspector-input" value="' + inspector.getValue(item) + '" ' + (item.placeholder ? "placeholder='" + item.placeholder + "'" : '') + '>';

			create_input = $(create_input);
			create_input.on("keyup", function(e) {
				keyup.call(this, e);
			});
			return create_input;
		},
		createButton: function(display_name, option, click) {
			let create_button = '<button class="' + option.class + '">';
					create_button += display_name;
					create_button += '</button>';

			create_button = $(create_button);
			create_button.click(function(e) {
				click.call(this, e);
			});
			return create_button;
		},
		getValue: function(selected_editable, option) {
			let get_value;

			// Set selected element as temporary
			_selected_element = selected_element;
			selected_element = (selected_editable.find !== undefined ? selected_element.find(selected_editable.find) : selected_element);

			if(selected_editable.selector == 'html') {
				get_value = editor_area.selectedGet(selected_editable.name);
				if(!get_value) {
					get_value = selected_element.html();
				}
			}else if(selected_editable.selector == 'attr') {
				get_value = editor_area.selectedGet(selected_editable.name);
				if(!get_value) {
					if(typeof option == 'object') {
						let get_attr_value = selected_element.attr(selected_editable.store_to);

						if(get_attr_value) {
							get_attr_value = get_attr_value.split(" ");

						  option.list.forEach((val_from_option) => {
								get_attr_value.forEach((val) => {
							    if(val_from_option.name == val) {
							    	get_value = val;
							    }
							  })
							});							
						}
					}else{
						get_value = selected_element.attr(selected_editable.store_to);
						if(!get_value) {
							get_value = '';
						}
					}
				}
			}

			selected_element = _selected_element;
			return get_value;
		},
		// Inspector modal
		createNew: function(data) {
			if($(".inspector-modal").length) {
				return;
			}

			let modal = '<div class="inspector-modal">';
					modal += '<h4>' + data.title + " <div class='close' onclick='inspector.destroyModal()'><i class='fas fas-close'></i></div></h4>";
					modal += '<div class="inspector-group-inner">';
					modal += '</div>';
					modal += '</div>';

			modal = $(modal);

			let left = selector.inspector.offset().left + selector.inspector.outerWidth() + 10,
					top = selector.inspector.offset().top;

			modal.css({
				left: left,
				top: top
			});

			selector.inspector.after(modal);
			modal.draggable({
				handle: '>h4',
				snap: '.editor-draggable-element, .inspector',
				cursor: 'move',
				containment: '.main'
			});
			modal.show();
			inspector_modal = modal;

			let create_new = inspector.addModalGroup('Create New', 'create-new');
			data.data.pattern.forEach((item) => {
				create_new.append($("<div/>", {
					class: 'inspector-control-group'
				})
				.append($("<label/>", {
					html: item.display_name
				}))
				.append($("<div/>", {
					class: 'inspector-control'
				})
				.append($("<input/>", {
					class: 'inspector-input create-new-option-input',
					id: 'create_new_option_' + item.name
				}))));
			});
			create_new.append($("<button/>", {
				class: 'btn btn-primary btn-block',
				html: 'Create',
			})
			.click(function() {
				inspector.addOption(data.data.pattern, data.data);
			}));

			$(".inspector-modal .inspector-group-inner").niceScroll({
				cursoropacitymin: .3
			});
		},
		addOption: function(pattern, data, stored) {
			let list = $("#inspector-modal-group-list"); 
			if(!list.length) {
				list = inspector.addModalGroup('List', 'list');

				let create_header = $("<div/>", {
					class: 'row'
				});
				list.append(create_header);
				pattern.forEach((item) => {
					create_header.append($("<div/>", {
						class: 'col-md-4 text-bold',
						html: item.display_name
					}));
				});
				create_header.append($("<div/>", {
					class: 'col-md-4 text-bold',
					html: 'Action'
				}));
			}


			let add_item = function(index) {
				let create_item = $("<div/>", {
					id: 'option_list_' + count_list,
					class: 'row option-list'
				});
				pattern.forEach((item) => {
					create_item.append($("<div/>", {
						class: 'col-md-4 option',
						"data-name": item.name,
						html: (stored ? stored[index][item.name] : $("#create_new_option_" + item.name).val())
					}));

					if(!stored)
						$("#create_new_option_" + item.name).val("");
				});
	
				create_item.append($("<div/>", {
					class: 'col-md-4'
				})
				.append($("<button/>", {
						class: 'btn btn-xs btn-danger',
						html: '<i class="fas fa-window-close"></i>'
					}).click(function() {
						let clone = data.clone;

						$(this).parent().parent().find('.option').each(function() {
							let __this = $(this);
							clone = clone.replace('{' + __this.data('name') + '}', __this.html());
						});

						let _html = selected_element.html();
						_html = _html.replace(clone, "");
						selected_element.html(_html);

						$(this).parent().parent().remove();

						if(list.find('.option-list').length < 1) {
							list.remove();
						}
					})));
	
				count_list++;
				list.sortable({
					items: '.option-list',
					cursor: 'move',
					update: function() {
						inspector.updateOptionHtml(data);
					}
				});
				list.append(create_item);
			}

			if(stored) {
				stored.forEach((opt, index) => {
					add_item(index);
				});
			}else{
					add_item();
			}

			inspector.updateOptionHtml(data);
		},
		updateOptionList: function(data) {
			let options = selected_element.attr('data-editor-options');
			
			if(options) {
				options = JSON.parse(options);
				inspector.addOption(data.pattern, data, options);
			}

		},
		updateOptionHtml: function(data) {
			_selected_element = selected_element;
			if(data.find == 'select') {
				selected_element.find('select').html("");
			}else{
				selected_element.html($(selected_element_object.html).html());
			}
			selected_element = (data.find !== undefined ? selected_element.find(data.find) : selected_element);

			let _data = [];
			$('.row.option-list').each(function(i) {
				let _this = $(this),
						clone = data.clone;

				let obj = {};
				_this.find('.option').each(function() {
					let __this = $(this);
					clone = clone.replace('{' + __this.data('name') + '}', __this.html());
					obj[__this.data('name')] = __this.html();
				});
				_data.push(obj);

				selected_element[data.selector]($(clone));
			});
			selected_element = _selected_element;
			selected_element.attr('data-editor-options', JSON.stringify(_data));

			source.update();
		},
		addModalGroup: function(title, id) {
			let create_group = $("<div/>", {
				id: 'inspector-modal-group-' + id,
				class: 'inspector-group',
				html: '<h5>' + title + '</h5>'
			});
			inspector_modal.find(".inspector-group-inner").append(create_group);
			return create_group;
		},
		destroyModal: function() {
			if($(".inspector-modal").length)
				inspector_modal.remove();
		},
		// End inspector modal
		init: function() {
			selector.inspector.show();
			
			selector.inspector.draggable({
				handle: '>h4',
				snap: '.editor-draggable-element',
				cursor: 'move',
				containment: '.main'
			});

			let top = event.clientY + $(window).scrollTop(),
					left = event.clientX;

			if(left + selector.inspector.outerWidth() >= $(document).outerWidth()) {
				left = left - selector.inspector.outerWidth();
			}

			selector.inspector.css({
				top: top,
				left: left
			});

			// add title
			selector.inspector.prepend("<h4>Inspector <div class='close' onclick='inspector.destroy()'><i class='fas fa-window-close'></i></div></h4>");
			selector.inspector.append('<div class="inspector-group-inner"></div>');

			// add group info
			inspector.addGroup('Info', 'info');

			selector.inspector.find('.inspector-group-inner').niceScroll({
				cursoropacitymin: .3
			});

			$(document).keydown(function(e) {
				if(e.keyCode == 46) {
					inspector.removeElement();
				}
				else if(e.keyCode == 27) {
					inspector.destroy();
				}
			});
		},
		run: function() {
				inspector.reset();

				let selected_element_editable = selected_element_object.editable;

				inspector.init();
				inspector.addItem("info", ["Selected Element", selected_element_object.display_name]);

				if(typeof selected_element_editable == 'object') {
					selected_element_editable.forEach((item) => {
						inspector.addGroup(item.display_name, item.name);

						if(item.type == 'select') {
							item.options.forEach((opt) => {
								inspector.addItem(item.name, [opt.display_name, inspector.createSelect(item, opt, function(e) {
									let value = $(e.target).find("option:selected").val();
									inspector.editable(value, item, opt);
								})]);
							});						
						}else if(item.type == 'input') {
							inspector.addItem(item.name, [item.display_name, inspector.createInput(item, function(e) {
								let value = $(e.target).val();
								inspector.editable(value, item);
							})]);
						}else if(item.type == 'addmore') {
							inspector.addItem(item.name, [item.display_name, inspector.createButton('Manage', {
								class:'btn btn-primary btn-sm btn-block'
							}, function(e) {
								inspector.createNew({
									title: item.display_name,
									data: item
								});
								inspector.updateOptionList(item);
							})]);
						}
					});
				}

				inspector.addGroup('Danger Area', 'danger-area');
				inspector.addBlock('danger-area',  inspector.createButton('Delete Element', {
					class: 'btn btn-danger btn-block'
				}, function() {
					inspector.removeElement();
				}));

				// initialization BS plugin
				bs_plugin();
		},
		destroy: function() {
			inspector.reset();
			inspector.destroyModal();
			selector.inspector.hide();
			$('.editor-draggable-element').removeClass("has-focused");
		}
	}

	$("#content-model-setting").on("click", function() {
		let get_setting = localStorage.getItem("_content_model_generator_setting");
		if(get_setting) {
			get_setting = JSON.parse(get_setting);
		}

		let name = (get_setting.name ? get_setting.name : ""),
				display_name = (get_setting.display_name ? get_setting.display_name : ""),
				description = (get_setting.description ? get_setting.description : "");

		bsModal.create({
			title: '<i class="fas fas-gear-b"></i> Content Model Setting',
			body: `
			<div class="form-group">
				<label>Content Model Name</label>
				<input type="text" class="form-control" id="input-content-model-name" name="content_model_name" value="${name}" placeholder="e.g: my_module">
				<div class="help-text">An unique name, use _ instead of space</div>
			</div>
			<div class="form-group">
				<label>Display Name</label>
				<input type="text" value="${display_name}" class="form-control" placeholder="My Module" name="content_model_display_name">
				<div class="help-text">The name to be displayed in the view</div>
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea class="form-control" id="description" rows="3" name="content_model_description">${description}</textarea>
			</div>`,
			buttons: [
				{
					text: 'Save Setting',
					class: "btn btn-primary",
					handler: function(b) {
						let name = b.find(".modal-body [name='content_model_name']").val(),
								display_name = b.find(".modal-body [name='content_model_display_name']").val(),
								description = b.find(".modal-body [name='content_model_description']").val();

						let setting = {
							name: name,
							display_name: display_name,
							description: description
						}
						localStorage.setItem("_content_model_generator_setting", JSON.stringify(setting));
						bsModal.hide();
					}
				}
			]
		})
	});

	$("#btnGenerate").on("click", function() {
		let _saved_layout = localStorage.getItem("_content_model_generator_layout"),
				_saved_setting = localStorage.getItem("_content_model_generator_setting"),
				_html = json2html(JSON.parse(_saved_layout)),
				_saved_setting_extracted = JSON.parse(_saved_setting);

		if($(_html).length == 0) {
			bsModal.create({
				title: 'Missing Element',
				body: 'You don\'t have a field',
				buttons: [
					{
						text: 'Close',
						class: 'btn btn-primary',
						role: 'close'
					}
				]
			});
			return;
		}

		let _body = '';
				_body += '<div class="row">';
				_body += '<div class="col-md-6">';
				_body += '<div class="form-group">';
				_body += '<label>Name</label>';
				_body += '<input type="text" class="form-control" value="'+_saved_setting_extracted.name+'" disabled>';
				_body += '</div>';
				_body += '</div>';
				_body += '<div class="col-md-6">';
				_body += '<div class="form-group">';
				_body += '<label>Display Name</label>';
				_body += '<input type="text" class="form-control" value="'+ _saved_setting_extracted.display_name +'" disabled>';
				_body += '</div>';
				_body += '</div>';
				_body += '</div>';
		bsModal.create({
			title: 'Content Model Generate',
			body: _body,
			class: 'modal-lg',
			buttons: [
				{
					text: 'Generate',
					class: 'btn btn-primary',
					handler: function(b, button) {
						let _saved_fields = [];
						
						$(_html).each(function(i) {
							let nama = $(this).find(":input").attr('name');
							_saved_fields[i] = {								
								name: nama,
								display_name: $(this).find("label").html(),
								// input_type : optional($(this).find(":input").attr('type')),
								input_type : optional($(this).find(":input").attr('data-type')),
								db_type : optional($(this).attr("data-element-db-type")),
								"validation" : {
									required: optional($(this).find(":input").attr('required')),
									unique: optional($(this).find(":input").attr('unique')),
									max: optional($(this).find(":input").attr('max')),
									min: optional($(this).find(":input").attr('min')),
									max_filesize: optional($(this).find(":input").attr('max-filesize'))
								},
							}
						});

						_saved_layout = generate_html(_html);
						let _button_text = button.html(),
								_data_to_send = {
									field_collection_in_html : _saved_layout,
									properties : _saved_setting,
									fields_collection : _saved_fields,
									relation_data :JSON.parse(localStorage.getItem("relation_data")),
									project_id : '{{ request()->session()->get('project')['id'] }}'									
								};

								console.log(_data_to_send);

						$.ajax({
							url: request_url.generate,
							data: _data_to_send,
							headers: {
								'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
							},
							type: 'POST',
							dataType: 'json',
							error: function(xhr) {
								if(xhr.responseText == "ok"){
									swal({
										title: 'Success',
										text: 'Content Model Generated Successfully',
										icon: 'success'
									}).then(function() {				
										window.location = '{{ route('content_model.index') }}';
									});
								}else{
									swal({
										title: 'Error',
										text: 'Any something wrong !',
										icon: 'error'
									}).then(function() {				
										// window.location = '{{ route('content_model.index') }}';
									});
								}
							},
							beforeSend: function() {
								button.html('Generating Conten Model ...');
								button.addClass('disabled');								
							},
							complete: function(e) {
								// console.log(e);								
								
								button.html(_button_text);
								button.removeClass('disabled');									
							}, success: function(e){
								console.log("success" + e);
									swal({
										title: 'Success',
										text: 'Content Model Generated Successfully',
										icon: 'success'
									}).then(function() {				
										window.location = '{{ route('content_model.index') }}';
									});
							}
						})
					}
				}
			]
		})
	});

var typingTimer;               
var doneTypingInterval = 200; 
var $input = $(".modal-body #content-model-name");

$input.on('keyup', function () {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

$input.on('keydown', function () {
  clearTimeout(typingTimer);
});

function doneTyping (name) {
	$.ajax({
		url: '{{ route('content_model.cek_name') }}',
		dataType: 'json',
		data: {name:name},
		type: 'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		complete: function(data) {
			console.log(data.responseText);
			// console.log(data.responseText == "ada");
			if(data.responseText == "ada")
			{
				$(".modal-body #content-model-name").focus()
				$("#help-text-welcome").html("<span class='text-danger:red'><b>Please use an another name</b></span>");				
				return;
			}else{
				$('#btn-start').prop('disabled', false);
			}
		},
		error: function(xhr) {
			// console.log(xhr);
		}
	});
}

</script>
@endpush