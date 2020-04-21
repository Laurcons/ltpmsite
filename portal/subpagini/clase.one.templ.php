<templates>

	<template id="elev-row-template">

		<div class="row border p-2">

			<div class="col-md-3">

				<span class="badge badge-primary">{{nrcrt}}</span>
				<span class="badge badge-danger">{{Id}}</span>
				{{Nume}} {{Prenume}}

			</div>

			<div class="col-md-5">

				<b>Note:</b><br>

				{{#note}}

					<div class="dropdown d-inline"> <!-- nota id {{Id}}: {{Nota}} / {{Ziua}}.{{Luna}} -->

						<div class="nota nota-link"
							 data-toggle="dropdown">

							<h4>{{Nota}} <small>{{Ziua}} {{{lunaRoman}}}</small></h4>

						</div>

						<div class="dropdown-menu">

							<a class="dropdown-item bg-info text-white">Nota adaugata de {{profesor.Nume}} {{profesor.Prenume}}</a>
							<a class="dropdown-item bg-info text-white">la data de {{Timestamp}}</a>

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
					 data-elev-id="{{Id}}">
					<h4>+</h4>
				</div>

				<br><b>Absente:</b><br>

				{{#absente}}

					<div class="dropdown d-inline"> <!-- absenta id {{Id}}: {{Ziua}}.{{Luna}} -->

						<div class="absenta {{#Motivata}}absenta-motivata{{/Motivata}} absenta-link"
							 data-toggle="dropdown">

							<h4><small>{{Ziua}} {{{lunaRoman}}}</small></h4>

						</div>

						<div class="dropdown-menu">

							<a class="dropdown-item bg-info text-white">Absenta trecuta de {{profesor.Nume}} {{profesor.Prenume}}</a>
							<a class="dropdown-item bg-info text-white">la data de {{Timestamp}}</a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item bg-primary text-white"
							   data-action="motiveaza-absenta"
							   data-absenta-id="{{Id}}"
							   href="#">
								Motiveaza absenta
							</a>

						</div>

					</div>

				{{/absente}}

				<div class="absenta absenta-link"
					 data-toggle="modal"
					 data-target="#adauga-absenta-modal"
					 data-elev-id="{{Id}}">
					<h4>+</h4>
				</div>

			</div>

		</div>

	</template>

</templates>