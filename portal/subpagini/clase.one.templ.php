<templates>

	<template id="elev-row-template">

		<div class="row border border-top-0 p-2 elev-row" data-elev-id="{{Id}}" data-elev-index="{{nrcrt}}">

			<div class="col-md-3">

				<span class="badge badge-primary">{{nrcrt}}</span>
				<span class="badge badge-danger">{{Id}}</span>

				{{Nume}} {{Prenume}}

				<div class="d-none d-md-block">
					<hr class="mb-2">
				</div>
				<div class="d-block d-md-none">
					<!-- empty, works as new row -->
				</div>

				<small>Sem. 1:</small>
				<span class="badge badge-info mb-2">{{media_sem1}}</span>
				<small>Sem. 2:</small>
				<span class="badge badge-info mb-2">{{media_sem2}}</span>
				<small>Gen.:</small>
				<span class="badge badge-info mb-2">{{media_gen}}</span>

				{{#mediaAlert}}
				<div class="alert alert-danger p-1 px-2">

					<strong>Atentie!</strong> Media semestriala a elevului se termina in .49! Va rugam sa ii mai acordati inca o nota pentru a-i definitiva media!

				</div>
				{{/mediaAlert}}

			</div>

			<div class="col-md-5">

				<b>Note:</b><br>

				{{#note}}

					<!-- nota id {{Id}}: {{Nota}} / {{Ziua}}.{{Luna}} -->
					<div class="dropdown d-inline">

						<div class="nota nota-link {{#isTeza}}nota-teza{{/isTeza}}"
							 data-toggle="dropdown">

							<h4>{{Nota}} <small>{{Ziua}} {{{lunaRoman}}}</small></h4>

						</div>

						<div class="dropdown-menu">

							<a class="dropdown-item bg-info text-white cursor-default">Nota <b>{{#isTeza}}la teza{{/isTeza}}{{#isOral}}la oral{{/isOral}}{{#isTest}}la test{{/isTest}}</b> adaugata de <b>{{profesor.Nume}} {{profesor.Prenume}}</b></a>
							<a class="dropdown-item bg-info text-white cursor-default">la data de <b>{{Timestamp}}</b></a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item bg-danger text-white"
							   data-toggle="modal"
							   href="#anuleaza-nota-modal"
							   data-nota-id="{{Id}}"
							   data-nota-json="{{json}}">
								Anuleaza nota
							</a>

						</div>

					</div>

				{{/note}}

				<div class="nota nota-link"
					 data-toggle="modal"
					 data-target="#noteaza-modal"
					 data-elev-id="{{Id}}"
					 data-elev-nume="{{Nume}} {{Prenume}}"
					 data-elev-has-teza="{{hasTeza}}">
					<h4>+</h4>
				</div>

				<br><b>Absente:</b><br>

				{{#absente}}

					<!-- absenta id {{Id}}: {{Ziua}}.{{Luna}} -->
					<div class="dropdown d-inline"> 

						<div class="absenta {{#Motivata}}absenta-motivata{{/Motivata}} absenta-link"
							 data-toggle="dropdown">

							<h4><small>{{Ziua}} {{{lunaRoman}}}</small></h4>

						</div>

						<div class="dropdown-menu">

							<a class="dropdown-item bg-info text-white cursor-default">Absenta trecuta de <b>{{profesor.Nume}} {{profesor.Prenume}}</b></a>
							<a class="dropdown-item bg-info text-white cursor-default">la data de <b>{{Timestamp}}</b></a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item bg-primary text-white"
							   data-action="motiveaza-absenta"
							   data-absenta-id="{{Id}}"
							   href="#">
							   	{{#Motivata}}Demotiveaza absenta{{/Motivata}}
								{{^Motivata}}Motiveaza absenta{{/Motivata}}
							</a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item bg-danger text-white"
							   data-toggle="modal"
							   data-target="#anuleaza-absenta-modal"
							   data-absenta-id="{{Id}}"
							   data-absenta-data="{{Ziua}} {{Luna}}"
							   href="#">
								Anuleaza absenta
							</a>

						</div>

					</div>

				{{/absente}}

				<div class="absenta absenta-link"
					 data-toggle="modal"
					 data-target="#adauga-absenta-modal"
					 data-elev-id="{{Id}}"
					 data-elev-nume="{{Nume}} {{Prenume}}">
					<h4>+</h4>
				</div>

			</div>

			<div class="col-md">

				<div class="d-md-none d-block font-weight-bold">
					Optiuni:
				</div>

			</div>

		</div>

	</template>

	<template id="preferinte-teza-row-template">

		<div class="form-row">

			<div class="col-6">

				<span class="badge badge-primary">{{nrcrt}}</span>
				<!--<span class="badge badge-danger">{{Id}}</span>-->
				{{Nume}} {{Prenume}}

			</div>

			<div class="col-3">

				<input type="checkbox"
					   form="preferinte-teza-form"
					   id="preferinta-teza-modal-elev-{{Id}}-da"
					   onchange="$('#preferinta-teza-modal-elev-{{Id}}-nu').prop('checked', !$(this).prop('checked'))"
					   name="elev[{{Id}}]"
					   value="da">

			</div>

			<div class="col-3">

				<input type="checkbox"
					   form="preferinte-teza-form"
					   id="preferinta-teza-modal-elev-{{Id}}-nu"
					   onchange="$('#preferinta-teza-modal-elev-{{Id}}-da').prop('checked', !$(this).prop('checked'))"
					   name="elev[{{Id}}]"
					   value="nu">

			</div>

		</div>

	</template>

	<template id="motivare-row-template">

		<tr>

			<td class="text-nowrap">
				<span class="badge badge-primary">{{nrcrt}}</span>
				{{Nume}} {{Prenume}}
			</td>

			<td>
				{{absenteMotivate}}
			</td>

			<td>
				{{absenteNemotivate}}
			</td>

			<td class="text-nowrap">
				<button type="button"
						class="btn btn-sm btn-default border-primary"
						data-toggle="modal"
						data-target="#motivari-modal"
						data-elev-id="{{Id}}">
					{{nr_motivari}} motivari
				</button>
			</td>

		</tr>

	</template>

	<template id="motivari-modal-template">

		<p>Lista cu motivările elevului <b>{{Nume}} {{Prenume}}</b>.</p>

		<button type="button"
				class="btn btn-default border-primary btn-sm mb-3">
			Adaugă motivare
		</button>

		<div class="collapse" id="motivari-modal-collapse">

			<div class="form-row">

				

			</div>

		</div>

		<div class="table-responsive">

			<table class="table table-sm table-hover">

				<thead>

					<th>Detalii</th>
					<th>Opțiuni</th>

				</thead>

				<tbody>

					<!--{{#motivari}}-->
 
						<tr>

							<td>

								<span class="badge badge-primary">{{nrcrt}}</span>
								<span class="badge badge-danger">{{Id}}</span>
								{{Motiv}}
								<br>

								Tip: <span class="text-capitalize">{{Tip}}</span><br>
								{{#isPerioada}}
									Perioada: ..
								{{/isPerioada}}
								{{#isMaterie}}
									La materia: {{materie.Nume}}
								{{/isMaterie}}

							</td>

							<td>
								<button class="btn btn-sm border-danger btn-default"
										data-action="sterge-motivare-btn"
										data-motivare-id="{{Id}}"
										data-elev-id="{{elevId}}">
									Șterge motivare
								</button>
							</td>

						</tr>

					<!--{{/motivari}}-->

				</tbody>

			</table>

		</div>

		<script>
			attachMotivariModalEventHandlers();
		</script>

	</template>

</templates>