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

					<div class="dropdown nota-dropdown d-inline">

						<div class="nota nota-link"
							 data-toggle="dropdown">

							<h4>{{Nota}} <small>{{Ziua}} {{{lunaRoman}}}</small></h4>

						</div>

						<div class="dropdown-menu">

							<a class="dropdown-item bg-primary text-white">Nota adaugata de {{profesor.Nume}} {{profesor.Prenume}}</a>
							<a class="dropdown-item bg-primary text-white">la data de {{Timestamp}}</a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item bg-danger text-white"
							   data-toggle="modal"
							   href="#anuleaza-nota-modal"
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

					<div class="absenta {{#Motivata}}absenta-motivata{{/Motivata}}">

						<h4><small>{{Ziua}} {{{lunaRoman}}}</small></h4>

					</div>

				{{/absente}}

				<div class="absenta absenta-link">
					<h4>+</h4>
				</div>

			</div>

		</div>

	</template>

</templates>