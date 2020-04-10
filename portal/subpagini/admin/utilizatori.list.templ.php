<templates>

	<template id="utilizatori-table-row-template">

		<div class="row border border-top-0 p-2 table-row" data-utilizator-id="{{Id}}">

			<div class="col-md-3">

				<div class="d-none d-md-block">
					<span class="badge badge-primary">{{nrcrt}}</span>
					<span class="badge badge-danger mr-1">{{Id}}</span>
					{{Nume}} {{Prenume}} <small>({{Username}})</small>
				</div>
				<div class="d-block d-md-none h5">
					<span class="badge badge-primary">{{nrcrt}}</span>
					<span class="badge badge-danger mr-1">{{Id}}</span>
					{{Nume}} {{Prenume}} <small>({{Username}})</small>
				</div>

			</div>

			<div class="col-md-5">

				<b>Functia:</b> {{Functie}}
				<br>
				<b>Autoritatea:</b> {{Autoritate}}
				<br>

				{{#clasa}}
					{{#isProfesor}}
					<b>Diriginte la:</b> {{clasa.Nivel}}-{{clasa.Sufix}}
					{{/isProfesor}}

					{{#isElev}}
					<b>Elev in clasa:</b> {{clasa.Nivel}}-{{clasa.Sufix}}
					{{/isElev}}
				{{/clasa}}

				{{^clasa}}
				Nu apartine niciunei clase
				{{/clasa}}

				<br>

				{{#isElev}}
				<b>Numar matricol:</b> {{NrMatricol}} {{^NrMatricol}}&lt;nu exista&gt;{{/NrMatricol}}
				{{/isElev}}

			</div>

			<div class="col-md-4">

				<a class="btn btn-default border-primary" href="?p=admin:utilizatori&id={{Id}}">Detalii</a>

			</div>

		</div>

	</template>

	<template id="table-auxiliaries-template">

		<div class="row mb-3">

			<div class="col-md-4 d-flex">

				<div class="mr-3">
					Pagina:
				</div>

				<div class="w-100" data-pagination="utilizatori">

					<!-- filled with javascript -->

				</div>

			</div>

			<div class="col-md-4 d-flex">

				<div class="mr-3 flex-shrink-0">
					Intrari pe pagina:
				</div>

				<div class="w-100">

					<input data-tag="pagination-epp"
						   type="number"
						   class="form-control form-control-sm"
						   min="3"
						   max="200">

				</div>

			</div>

			<div class="col-md-4 d-flex">

				<div class="flex-shrink-0">

					<span class="d-none spinner-border spinner-border-sm text-primary" data-tag="data-loading"></span>

				</div>

			</div>

		</div>

	</template>

</templates>