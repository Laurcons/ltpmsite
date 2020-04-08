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

</templates>