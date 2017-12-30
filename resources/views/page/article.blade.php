@extends('layouts.simple')

@section('title', $pub->titulo)

@section('body', 'class=background')

@section('content')
<section class="background-is-light">
	<br>
	<div class="container">
		@include('partials.message')
		<div class="columns">
			<div class="column is-8">
				<div class="card-plain">
					<div class="card-image post-title" style="background:linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.5)), url({{$pub->imagen}}) center/cover no-repeat scroll">
						<div class="title-content">
							<h3 class="title is-3" style="color: #fff; margin: 0px;">{{$pub->titulo}}</h3>
							<div class="title-info">
								<p style="color: rgba(255, 255, 255, 0.6);">
									<small>Autor: {{$pub->user->nombre}} {{$pub->user->apellido}}</small>
								</p>
								<p style="color: rgba(255, 255, 255, 0.6);">
									<small>Fecha: {{$pub->fecha}}</small>
								</p>
							</div>
						</div>
					</div>
					<div class="card-content">
						<div class="content">
							{!! $pub->contenido !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="background-is-soft">
	<div class="container">
		<br>
		<div class="columns">
			<div class="card-plain">
				<div class="card-image">
					<div class="hero is-info">
						<div class="hero-body">
							<div class="container has-text-centered">
								<h3 class="title">
									Comentarios
								</h3>
							</div>
						</div>
					</div>
					@if(count($pub->comments) == 0)
						<section class="background-is-light">
							<div class="has-text-centered">
								<br><br>
								<h3 class="subtitle is-3">
									Nadie ha comentado aún, se el primero.
								</h3>
								<br><br>
							</div>
						</section>
					@endif
				</div>
				@if(Auth::check())
					<div class="card-content">
						<form method="POST" action="{{ url('comment/new/'.$pub->id) }}">
							{{ csrf_field() }}
							<textarea id="contenido" name="contenido" class="textarea" placeholder="Danos tu opinión."></textarea>
							<br>
							<div class="level">
								<div class="level-left"></div>
								<div class="level-right">
									<button type="submit" class="button is-primary">
										<span class="icon">
											<i class="fa fa-commenting-o" aria-hidden="true"></i>
										</span>
										<span>Comentar</span>
									</button>
								</div>
							</div>
						</form>
						<hr>
					</div>
				@endif
				@if(count($pub->comments) > 0)
					<div class="card-content">
						@foreach($pub->comments as $commentary)
							@if($commentary->estado == 1)
								<article class="media">
									<div class="media-content">
										<div class="content">
											<p>
												<strong>{{$commentary->user->nombre}} {{$commentary->user->apellido}}</strong> <small>{{$commentary->user->usuario}} {{$commentary->fecha}}</small>
												<br>
												{{$commentary->contenido}}
											</p>
											@if(Auth::check())
												<div class="level is-mobile">
													<div class="level-left">
														@if(Auth::user()->tipo == 1)
														<a class="level-item" href="{{ url('comment/hide/'.$pub->id.'/'.$commentary->id) }}">
															<i class="fa fa-eye" aria-hidden="true"></i>
														</a>
														<a class="level-item del" href="{{url('comment/delete/'.$pub->id.'/'.$commentary->id)}}">
															<i class="fa fa-eraser" aria-hidden="true"></i>
														</a>
														@endif
														@if(Auth::user()->id == $commentary->usuario_id)
															<a class="level-item edt">
																<i class="fa fa-pencil" aria-hidden="true"></i>
															</a>
															<a class="level-item del" href="{{url('comment/delete/'.$pub->id.'/'.$commentary->id)}}">
																<i class="fa fa-eraser" aria-hidden="true"></i>
															</a>
														@endif												
													</div>
												</div>
											@endif
										</div>
									</div>
									@if(Auth::check())
										@if(Auth::user()->tipo == 1 && $commentary->estado == 0)
											<div class="media-right">
												<span class="tag is-warning">
													<i class="fa fa-exclamation" aria-hidden="true"></i>
													Comentario Oculto
												</span>
											</div>
										@endif
									@endif
								</article>
								@if(Auth::check())
									@if(Auth::user()->id == $commentary->usuario_id)
										<div class="comment" style="display:none;">
											<form method="POST" action="{{ url('comment/edit/'.$pub->id.'/'.$commentary->id) }}">
												{{ csrf_field() }}
												<textarea class="textarea" name="comentario">{{ $commentary->contenido }}</textarea>
												<br>
												<div class="level">
													<div class="level-left"></div>
													<div class="level-right">
														<button class="button is-primary level-item">
															<span>Editar Comentario</span>
															<span class="icon">
																<i class="fa fa-commenting-o" aria-hidden="true"></i>
															</span>
														</button>
														<button class="button is-danger level-item cnl">
															<span>Cancelar</span>
															<span class="icon">
																<i class="fa fa-ban" aria-hidden="true"></i>
															</span>
														</button>
													</div>
												</div>
											</form>
											<hr>
										</div>
									@endif
								@endif
							@elseif(Auth::check())
								@if(Auth::user()->tipo == 1)
									<article class="media">
										<div class="media-content">
											<div class="content">
												<p>
													<strong>{{$commentary->user->nombre}} {{$commentary->user->apellido}}</strong> <small>{{$commentary->user->usuario}} {{$commentary->fecha}}</small>
													<br>
													{{$commentary->contenido}}
												</p>
												@if(Auth::check())
													<div class="level is-mobile">
														<div class="level-left">
															@if(Auth::user()->tipo == 1)
															<a class="level-item" href="{{ url('comment/show/'.$pub->id.'/'.$commentary->id) }}">
																<i class="fa fa-eye" aria-hidden="true"></i>
															</a>
															<a class="level-item del" href="{{url('comment/delete/'.$pub->id.'/'.$commentary->id)}}">
																<i class="fa fa-eraser" aria-hidden="true"></i>
															</a>
															@endif
															@if(Auth::user()->id == $commentary->usuario_id)
																<a class="level-item edt">
																	<i class="fa fa-pencil" aria-hidden="true"></i>
																</a>
																<a class="level-item del" href="{{url('comment/delete/'.$pub->id.'/'.$commentary->id)}}">
																	<i class="fa fa-eraser" aria-hidden="true"></i>
																</a>
															@endif												
														</div>
													</div>
												@endif
											</div>
										</div>
										@if(Auth::check())
											@if(Auth::user()->tipo == 1 && $commentary->estado == 0)
												<div class="media-right">
													<span class="tag is-warning">
														<i class="fa fa-exclamation" aria-hidden="true"></i>
														Comentario Oculto
													</span>
												</div>
											@endif
										@endif
									</article>
									@if(Auth::check())
										@if(Auth::user()->id == $commentary->usuario_id)
											<div class="comment" style="display:none;">
												<form method="POST" action="{{ url('comment/edit/'.$pub->id.'/'.$commentary->id) }}">
													{{ csrf_field() }}
													<textarea class="textarea" name="comentario">{{ $commentary->contenido }}</textarea>
													<br>
													<div class="level">
														<div class="level-left"></div>
														<div class="level-right">
															<button class="button is-primary level-item">
																<span>Editar Comentario</span>
																<span class="icon">
																	<i class="fa fa-commenting-o" aria-hidden="true"></i>
																</span>
															</button>
															<button class="button is-danger level-item cnl">
																<span>Cancelar</span>
																<span class="icon">
																	<i class="fa fa-ban" aria-hidden="true"></i>
																</span>
															</button>
														</div>
													</div>
												</form>
												<hr>
											</div>
										@endif
									@endif
								@endif
							@endif
						@endforeach
					</div>
				@endif
			</div>
		</div>
	</div>
	<br><br>
</section>
@endsection