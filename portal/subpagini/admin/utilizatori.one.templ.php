<templates>

	<template id="predare-row-template">

		<div class="row table-row border border-bottom-0 {{^hasMaterie}}border-top-0{{/hasMaterie}} p-2">

			<div class="col-md-3">

				<span class="badge badge-primary mr-2">{{nrcrt}}</span>
				{{#hasMaterie}}
					{{materie.Nume}}
				{{/hasMaterie}}

			</div>

			<div class="col-md-3">

				<b>{{clasa.Nivel}}-{{clasa.Sufix}}</b>, diriginte  
				{{clasa.diriginte.Nume}} {{clasa.diriginte.Prenume}}

			</div>

			<div class="col-md-6">

				<a href="?p=admin:clase&id={{clasa.Id}}" class="btn btn-default border-dark btn-sm">Gestionare {{clasa.Nivel}}-{{clasa.Sufix}}</a>

			</div>

		</div>

	</template>

</templates>